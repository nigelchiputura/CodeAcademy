<?php

namespace App\Repositories;

use App\Config\Database;
use PDO;

class LoginAttemptRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function log(?int $userId, ?string $phoneAttempted, string $reason, bool $success, ?string $ipAddress): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO login_attempts (user_id, phone_attempted, reason, ip_address, success)
            VALUES (:user_id, :phone_attempted, :reason, :ip_address, :success)
        ");

        $stmt->execute([
            ':user_id'         => $userId,
            ':phone_attempted' => $phoneAttempted,
            ':reason'          => $reason,
            ':ip_address'      => $ipAddress,
            ':success'         => $success ? 1 : 0,
        ]);
    }

    /**
     * Count failed attempts in the last N minutes for a given user
     */
    public function countRecentFailedAttemptsForUser(int $userId, int $minutes = 15): int
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) 
            FROM login_attempts
            WHERE user_id = :user_id
              AND success = 0
              AND reason = 'wrong_password'
              AND attempted_at >= (NOW() - INTERVAL :minutes MINUTE)
        ");

        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':minutes', $minutes, PDO::PARAM_INT);
        $stmt->execute();

        return (int)$stmt->fetchColumn();
    }

    public function getByFilters(array $filters = []): array
    {
        $sql = "
            SELECT la.*, u.phone, u.username
            FROM login_attempts la
            LEFT JOIN users u ON la.user_id = u.user_id
            WHERE 1=1
        ";
        $params = [];

        if (!empty($filters['success'])) {
            $sql .= " AND la.success = :success";
            $params[':success'] = (bool)$filters['success'];
        }

        if (!empty($filters['reason'])) {
            $sql .= " AND la.reason = :reason";
            $params[':reason'] = $filters['reason'];
        }

        if (!empty($filters['from'])) {
            $sql .= " AND la.attempted_at >= :from";
            $params[':from'] = $filters['from'];
        }

        if (!empty($filters['to'])) {
            $sql .= " AND la.attempted_at <= :to";
            $params[':to'] = $filters['to'];
        }

        $sql .= " ORDER BY la.attempted_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}