<?php

namespace App\Controllers\Public;

use App\Services\ChatbotService;

class ChatbotController
{
    private ChatbotService $bot;

    public function __construct()
    {
        $this->bot = new ChatbotService();
    }

    public function query(): void
    {
        header('Content-Type: application/json');

        $input = trim($_POST['message'] ?? '');

        if ($input === '') {
            echo json_encode(['reply' => "Please type a question."]);
            return;
        }

        $reply = $this->bot->getReply($input);

        echo json_encode(['reply' => $reply]);
    }
}