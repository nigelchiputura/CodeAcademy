<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    private Client $client;
    private string $fromNumber;

    public function __construct()
    {
        // Load config
        $config = require __DIR__ . '/../Config/twilio.php';

        $this->fromNumber = $config['from'];

        // Twilio SDK client
        $this->client = new Client(
            $config['sid'],
            $config['token']
        );
    }

    public function sendSms(string $phone, string $message): void
    {
        $to = '+263' . substr($phone, 1);

        $this->client->messages->create($to, [
            'from' => $this->fromNumber,
            'body' => $message,
        ]);
    }
}
