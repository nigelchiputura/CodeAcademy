<?php

namespace App\Services;

/**
 * Simple email sending service using PHP mail().
 *
 * - Supports HTML + plain text fallback (multipart/alternative)
 * - Encodes subjects properly (UTF-8 safe)
 */
class EmailService
{
    private string $fromEmail;
    private string $fromName;

    public function __construct()
    {
        $config = require __DIR__ . '/../Config/email.php';

        $this->fromEmail = $config['from_email'] ?? 'no-reply@example.com';
        $this->fromName  = $config['from_name'] ?? 'Website Notification';
    }

    /**
     * Send an HTML email.
     *
     * @param string $toEmail
     * @param string $subject
     * @param string $html
     * @param string|null $altText
     * @return bool
     */
    public function sendHtml(string $toEmail, string $subject, string $html, ?string $altText = null): bool
    {
        $boundary = md5(uniqid((string)time(), true));

        $headers = [
            "From: {$this->fromName} <{$this->fromEmail}>",
            "Reply-To: {$this->fromEmail}",
            "MIME-Version: 1.0",
            "Content-Type: multipart/alternative; boundary=\"{$boundary}\"",
            "X-Mailer: PHP/" . phpversion()
        ];

        // fallback plain text version
        $plain = $altText ?? strip_tags(
            str_replace(['<br>', '<br/>', '<br />'], "\n", $html)
        );

        $body  = "--{$boundary}\r\n";
        $body .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
        $body .= $plain . "\r\n\r\n";

        $body .= "--{$boundary}\r\n";
        $body .= "Content-Type: text/html; charset=UTF-8\r\n\r\n";
        $body .= $html . "\r\n\r\n";

        $body .= "--{$boundary}--";

        return mail($toEmail, $this->encodeSubject($subject), $body, implode("\r\n", $headers));
    }

    private function encodeSubject(string $subject): string
    {
        return '=?UTF-8?B?' . base64_encode($subject) . '?=';
    }
}
