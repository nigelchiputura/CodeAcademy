<?php

namespace App\Models;

class Chatbot
{
    public ?int $id = null;
    public string $question;
    public string $answer;
    public string $created_at;

    public function __construct(array $data = [])
    {
        if (isset($data['faq_id'])) {
            $this->id = (int)$data['faq_id'];
        }

        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function sanitizeForFrontend(): array
    {
        return [
            'id'                => $this->id,
            'question'          => $this->question,
            'answer'            => $this->answer,
            'created_at'        => $this->created_at,
        ];
    }
}