<?php

namespace App\Repositories;

use App\Config\Database;
use PDO;

class ChatbotRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    /**
     * Very simple FAQ search.
     * Returns the best-matching question/answer pair or null.
     */
    public function searchFaq(string $message): ?array
    {
        $term = '%' . $message . '%';

        $stmt = $this->db->prepare("
            SELECT faq_id, question, answer
            FROM chatbot_faq
            WHERE question LIKE :q OR answer LIKE :q
            ORDER BY created_at DESC
            LIMIT 1
        ");

        $stmt->execute([':q' => $term]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }
}