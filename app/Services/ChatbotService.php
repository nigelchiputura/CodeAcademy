<?php

namespace App\Services;

use App\Repositories\ChatbotRepository;

class ChatbotService
{
    private ChatbotRepository $faq;

    public function __construct()
    {
        $this->faq = new ChatbotRepository();
    }

    public function reply(string $message): array
    {
        $message = trim($message);

        if ($message === '') {
            return [
                'answer' => "Hi 👋 I'm Nigey Academy Assistant.\n\n" .
                            "You can ask things like:\n" .
                            "• *How do I log in?*\n" .
                            "• *How do I pay fees?*\n" .
                            "• *What is the auditor demo account?*",
                'matched' => false,
            ];
        }

        $match = $this->faq->searchFaq($message);

        if ($match) {
            return [
                'answer'  => $match['answer'],
                'matched' => true,
            ];
        }

        return [
            'answer'  => "I'm not sure about that yet 🤔\n\n" .
                         "For now you can:\n" .
                         "• Browse the top navigation for pages\n" .
                         "• Log in with the *auditor* account to explore the admin portal\n\n" .
                         "You can also ask: *login*, *fees*, *results*, *contact*, etc.",
            'matched' => false,
        ];
    }
}
