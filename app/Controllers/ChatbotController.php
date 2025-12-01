<?php

namespace App\Controllers;

use App\Services\ChatbotService;

class ChatbotController
{
    private ChatbotService $service;

    public function __construct()
    {
        $this->service = new ChatbotService();
    }

    public function handle(): void
    {
        // Basic JSON endpoint
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }

        // Optional: very light CSRF check if you have a token helper
        session_start();
        if (
            empty($_POST['csrf_token']) ||
            empty($_SESSION['csrf_token']) ||
            !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
        ) {
            http_response_code(403);
            echo json_encode(['error' => 'Invalid CSRF token']);
            return;
        }

        $message = $_POST['message'] ?? '';
        $reply = $this->service->reply($message);

        echo json_encode($reply);
    }
}
