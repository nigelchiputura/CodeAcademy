<?php

namespace App\Services;

/**
 * Gmail-compatible SMTP sender.
 *
 * Supports:
 * - STARTTLS on port 587
 * - TLS encryption with certificate validation
 * - SNI (Server Name Indication)
 * - AUTH LOGIN
 * - No external dependencies
 *
 * Works locally and in production.
 */
class SmtpService
{
    private string $host;
    private int $port;
    private string $username;
    private string $password;
    private string $fromEmail;
    private string $fromName;
    private int $timeout = 30;

    private $socket;

    public function __construct(array $config = [])
    {
        $cfg = $config ?: require __DIR__ . '/../Config/smtp.php';

        $this->host      = $cfg['host'];
        $this->port      = $cfg['port'] ?? 587;
        $this->username  = $cfg['username'];
        $this->password  = $cfg['password'];
        $this->fromEmail = $cfg['from_email'];
        $this->fromName  = $cfg['from_name'];
    }

    public function sendHtml(string $to, string $subject, string $html, ?string $alt = null): bool
    {
        $boundary = md5(uniqid('', true));
        $alt = $alt ?? strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $html));

        $headers =
            "From: {$this->fromName} <{$this->fromEmail}>\r\n" .
            "MIME-Version: 1.0\r\n" .
            "Content-Type: multipart/alternative; boundary=\"{$boundary}\"\r\n";

        $body  = "--{$boundary}\r\n";
        $body .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n{$alt}\r\n\r\n";
        $body .= "--{$boundary}\r\n";
        $body .= "Content-Type: text/html; charset=UTF-8\r\n\r\n{$html}\r\n\r\n";
        $body .= "--{$boundary}--\r\n";

        return $this->send($to, $subject, $headers, $body);
    }

    private function send(string $to, string $subject, string $headers, string $body): bool
    {
        // IMPORTANT: Gmail requires SNI + TLS context
        $contextOptions = [
            'ssl' => [
                'verify_peer'       => true,
                'verify_peer_name'  => true,
                'allow_self_signed' => false,
                'crypto_method'     => STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT,
                'SNI_enabled'       => true,
                'peer_name'         => $this->host
            ]
        ];
        $context = stream_context_create($contextOptions);

        // Connect to server
        $this->socket = stream_socket_client(
            "tcp://{$this->host}:{$this->port}",
            $errno,
            $errstr,
            $this->timeout,
            STREAM_CLIENT_CONNECT,
            $context
        );

        if (!$this->socket) {
            throw new \Exception("SMTP connection failed: $errno - $errstr");
        }

        $this->expect(220);

        $this->sendCommand("EHLO localhost");
        $this->expect(250);

        // STARTTLS upgrade
        $this->sendCommand("STARTTLS");
        $this->expect(220);

        // Activate TLS encryption with SNI
        if (!stream_socket_enable_crypto($this->socket, true, STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT)) {
            throw new \Exception("Failed to enable TLS encryption.");
        }

        // Must EHLO again after STARTTLS
        $this->sendCommand("EHLO localhost");
        $this->expect(250);

        // AUTH LOGIN
        $this->sendCommand("AUTH LOGIN");
        $this->expect(334);

        $this->sendCommand(base64_encode($this->username));
        $this->expect(334);

        $this->sendCommand(base64_encode($this->password));
        $this->expect(235);

        // MAIL FROM
        $this->sendCommand("MAIL FROM:<{$this->fromEmail}>");
        $this->expect(250);

        // RCPT TO
        $this->sendCommand("RCPT TO:<{$to}>");
        $this->expect(250);

        // DATA
        $this->sendCommand("DATA");
        $this->expect(354);

        // Build final message
        $message  = "Subject: " . $this->encodeSubject($subject) . "\r\n";
        $message .= $headers . "\r\n" . $body . "\r\n.\r\n";

        fwrite($this->socket, $message);
        $this->expect(250);

        $this->sendCommand("QUIT");
        fclose($this->socket);

        return true;
    }

    private function sendCommand(string $command)
    {
        fwrite($this->socket, $command . "\r\n");
    }

    private function readResponse(): string
    {
        $data = '';
        while ($line = fgets($this->socket, 512)) {
            $data .= $line;
            if (preg_match('/^\d{3} /', $line)) {
                break;
            }
        }
        return $data;
    }

    private function expect(int $code)
    {
        $response = $this->readResponse();
        if ((int)substr($response, 0, 3) !== $code) {
            throw new \Exception("SMTP error: Expected {$code}, got: {$response}");
        }
    }

    private function encodeSubject(string $subject): string
    {
        return '=?UTF-8?B?' . base64_encode($subject) . '?=';
    }
}
