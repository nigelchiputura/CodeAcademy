<?php

namespace App\Repositories;

use App\Config\Database;
use PDO;

class ActivityLogRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function log(?int $userId, string $action, ?string $details = null): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO activity_log (user_id, action, details)
            VALUES (:user_id, :action, :details)
        ");

        $stmt->execute([
            ':user_id' => $userId,
            ':action'  => $action,
            ':details' => $details
        ]);
    }

    public function getRecent(int $limit = 10): array
    {
        $stmt = $this->db->prepare("
            SELECT al.*, u.username
            FROM activity_log al
            LEFT JOIN users u ON u.user_id = al.user_id
            ORDER BY created_at DESC
            LIMIT ?
        ");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
