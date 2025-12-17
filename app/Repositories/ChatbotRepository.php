<?php

namespace App\Repositories;

use App\Config\Database;
use App\Models\Chatbot;
use PDO;

class ChatbotRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM chatbot_faq ORDER BY faq_id DESC");
        return array_map(fn($s) => new Chatbot($s), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function search(string $term): array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM chatbot_faq
            WHERE question LIKE :term
        ");

        $stmt->execute([':term' => "%$term%"]);
        return array_map(fn($s) => new Chatbot($s), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function insert(string $question, string $answer): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO chatbot_faq (question, answer)
            VALUES (?, ?)
        ");
        return $stmt->execute([$question, $answer]);
    }

    public function update(int $id, string $question, string $answer): bool
    {
        $stmt = $this->db->prepare("
            UPDATE chatbot_faq 
            SET question = ?, answer = ?
            WHERE faq_id = ?
        ");
        return $stmt->execute([$question, $answer, $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM chatbot_faq WHERE faq_id = ?");
        return $stmt->execute([$id]);
    }
}