<?php

namespace App\Repositories;

use App\Config\Database;
use PDO;

class PasswordResetRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function createReset(int $userId, string $code, int $ttlMinutes = 15): void
    {
        // Optional: mark old tokens as used
        $this->db->prepare("
            UPDATE password_resets 
            SET used = 1 
            WHERE user_id = ? AND used = 0
        ")->execute([$userId]);

        $stmt = $this->db->prepare("
            INSERT INTO password_resets (user_id, reset_token, expires_at, used)
            VALUES (:user_id, :reset_token, DATE_ADD(NOW(), INTERVAL :ttl MINUTE), 0)
        ");

        $stmt->execute([
            ':user_id'     => $userId,
            ':reset_token' => $code,       // plain code for now
            ':ttl'         => $ttlMinutes,
        ]);
    }

    public function findValidReset(int $userId, string $code): ?array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM password_resets
            WHERE user_id = :user_id
              AND reset_token = :token
              AND used = 0
              AND expires_at > NOW()
            ORDER BY reset_id DESC
            LIMIT 1
        ");

        $stmt->execute([
            ':user_id' => $userId,
            ':token'   => $code,
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function markUsed(int $resetId): void
    {
        $stmt = $this->db->prepare("
            UPDATE password_resets SET used = 1 WHERE reset_id = ?
        ");
        $stmt->execute([$resetId]);
    }
}
