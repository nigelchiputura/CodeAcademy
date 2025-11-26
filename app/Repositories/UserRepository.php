<?php

namespace App\Repositories;

use App\Config\Database;
use App\Models\User;
use PDO;

class UserRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function findByPhone(string $phone): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE phone = ?");
        $stmt->execute([$phone]);

        $user = $stmt->fetch();

        return $user ? new User($user) : null;
    }

    public function findById(int $id): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->execute([$id]);

        $user = $stmt->fetch();

        return $user ? new User($user) : null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO users (username, password, role, email, phone, full_name)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['username'],
            $data['password'],
            $data['role'],
            $data['email'],
            $data['phone'],
            $data['full_name']
        ]);
    }
    
    public function updateUserInfo(array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE users SET username = ?, role = ?, email = ?, phone = ?, full_name = ?
            WHERE user_id = ?
        ");

        return $stmt->execute([
            $data['username'],
            $data['role'],
            $data['email'],
            $data['phone'],
            $data['full_name'],
            $data['user_id']
        ]);
    }
    
    public function updatePassword(array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE users SET password = ?
            WHERE user_id = ?
        ");

        return $stmt->execute([
            $data['new_password'],
            $data['user_id']
        ]);
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM users ORDER BY user_id DESC");
        $rows = $stmt->fetchAll();

        return array_map(fn($u) => new User($u), $rows);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE user_id = ?");
        return $stmt->execute([$id]);
    }

    public function multiDelete(array $userIds): bool
    {
        $placeholders = implode(',', array_fill(0, count($userIds), '?'));
        $stmt = $this->db->prepare("DELETE FROM users WHERE user_id IN ($placeholders)");
        return $stmt->execute($userIds);
    }

    public function getUsersByName(string $searchQuery): array
    {
        $stmt = $this->db->prepare("
            SELECT user_id, username, role, phone, email, full_name, created_at
            FROM users
            WHERE full_name LIKE :searchQuery
            OR username LIKE :searchQuery
            OR phone LIKE :searchQuery
            OR role LIKE :searchQuery
        ");

        $stmt->bindParam(':searchQuery', $searchQuery);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($row) => new User($row), $results);
    }

    public function isLastAdmin(int $id): bool
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM users WHERE role='admin'");
        $count = $stmt->fetchColumn();

        if ($count <= 1) {
            $check = $this->db->prepare("SELECT role FROM users WHERE user_id = ?");
            $check->execute([$id]);
            $role = $check->fetchColumn();

            return $role === 'admin';
        }

        return false;
    }
}
