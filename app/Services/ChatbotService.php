<?php

namespace App\Services;

use App\Repositories\ChatbotRepository;

class ChatbotService
{
    private ChatbotRepository $repo;

    public function __construct()
    {
        $this->repo = new ChatbotRepository();
    }

    public function getReply(string $input): string
    {
        $faqs = $this->repo->getAll();
        $inputLower = strtolower($input);

        $bestScore = 0;
        $bestAnswer = "Sorry, I'm not sure about that. Try asking something else!";

        foreach ($faqs as $faq) {
            $question = strtolower($faq->question);

            // Score based on keyword overlap
            $score = $this->similarityScore($inputLower, $question);

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestAnswer = $faq->answer;
            }
        }

        return $bestAnswer;
    }

    private function similarityScore(string $input, string $question): float
    {
        similar_text($input, $question, $percent);
        return $percent;
    }
}
