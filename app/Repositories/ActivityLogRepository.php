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
    
    public function getAll(): array
    {
        $stmt = $this->db->prepare("
            SELECT al.*, u.username
            FROM activity_log al
            LEFT JOIN users u ON u.user_id = al.user_id
            ORDER BY created_at DESC
        ");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function search(array $filters, int $limit, int $offset): array
    {
        $query = "
            SELECT al.*, u.username
            FROM activity_log al
            LEFT JOIN users u ON u.user_id = al.user_id
            WHERE 1
        ";

        $params = [];

        if (!empty($filters['q'])) {
            $query .= " AND (al.action LIKE :q OR al.details LIKE :q)";
            $params[':q'] = '%' . $filters['q'] . '%';
        }

        if (!empty($filters['action'])) {
            $query .= " AND al.action = :action";
            $params[':action'] = $filters['action'];
        }

        if (!empty($filters['user_id'])) {
            $query .= " AND al.user_id = :user_id";
            $params[':user_id'] = $filters['user_id'];
        }

        $query .= " ORDER BY al.created_at DESC LIMIT :offset, :limit";

        $stmt = $this->db->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function countFiltered(array $filters): int
    {
        $query = "
            SELECT COUNT(*) 
            FROM activity_log al
            WHERE 1
        ";

        $params = [];

        if (!empty($filters['q'])) {
            $query .= " AND (al.action LIKE :q OR al.details LIKE :q)";
            $params[':q'] = '%' . $filters['q'] . '%';
        }

        if (!empty($filters['action'])) {
            $query .= " AND al.action = :action";
            $params[':action'] = $filters['action'];
        }

        if (!empty($filters['user_id'])) {
            $query .= " AND al.user_id = :user_id";
            $params[':user_id'] = $filters['user_id'];
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        return (int)$stmt->fetchColumn();
    }

    public function getDistinctActions(): array
    {
        $stmt = $this->db->query("
            SELECT DISTINCT action 
            FROM activity_log 
            ORDER BY action ASC
        ");

        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }
}
