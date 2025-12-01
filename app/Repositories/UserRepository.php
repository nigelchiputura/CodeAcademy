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

    /* -------------------------
        FIND OPERATIONS
    --------------------------*/

    public function findByPhone(string $phone): ?User
    {
        $stmt = $this->db->prepare("
            SELECT * FROM users 
            WHERE phone = ? AND deleted_at IS NULL
        ");
        $stmt->execute([$phone]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ? $this->mapUserWithRoles($user) : null;
    }

    public function findById(int $id): ?User
    {
        $stmt = $this->db->prepare("
            SELECT * FROM users 
            WHERE user_id = ? AND deleted_at IS NULL
        ");
        $stmt->execute([$id]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ? $this->mapUserWithRoles($user) : null;
    }

    /* -------------------------
        CREATE USER
    --------------------------*/
    public function create(array $data): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO users (phone, email, username, password_hash, first_name, last_name, created_by)
            VALUES (:phone, :email, :username, :password_hash, :first_name, :last_name, :created_by)
        ");

        $stmt->execute([
            ':phone'         => $data['phone'],
            ':email'         => $data['email'] ?? null,
            ':username'      => $data['username'] ?? null,
            ':password_hash' => $data['password_hash'],
            ':first_name'    => $data['first_name'],
            ':last_name'     => $data['last_name'],
            ':created_by'    => $data['created_by'] ?? null
        ]);

        return (int)$this->db->lastInsertId();
    }

    /* Assign roles after create */
    public function assignRoles(int $userId, array $roleNames): void
    {
        foreach ($roleNames as $role) {
            $stmt = $this->db->prepare("
                INSERT INTO user_roles (user_id, role_id)
                SELECT :user_id, role_id FROM roles WHERE name = :role
            ");
            $stmt->execute([
                ':user_id' => $userId,
                ':role' => strtolower($role)
            ]);
        }
    }

    /* -------------------------
        UPDATE USER
    --------------------------*/
    public function update(array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE users 
            SET phone = ?, email = ?, username = ?, first_name = ?, last_name = ?, status = ?, updated_by = ?, updated_at = NOW()
            WHERE user_id = ?
        ");

        return $stmt->execute([
            $data['phone'],
            $data['email'],
            $data['username'],
            $data['first_name'],
            $data['last_name'],
            $data['status'],
            $data['updated_by'],
            $data['user_id']
        ]);
    }

    public function updatePassword(int $userId, string $hash): bool
    {
        $stmt = $this->db->prepare("
            UPDATE users SET password_hash = ?, is_password_temporary = 0 WHERE user_id = ?
        ");
        return $stmt->execute([$hash, $userId]);
    }

    public function updateLastLogin(int $userId): bool
    {
        $stmt = $this->db->prepare("
            UPDATE users SET last_login = NOW() WHERE user_id = ?
        ");
        return $stmt->execute([$userId]);
    }

    /* -------------------------
        UPDATE ROLES
    --------------------------*/

    public function updateUserRoles(int $userId, array $roles): bool
    {
        // Prevent removal of admin if this is last admin
        if ($this->isLastAdmin($userId) && !in_array('admin', $roles)) {
            return false;
        }

        // Remove existing roles
        $deleteStmt = $this->db->prepare("DELETE FROM user_roles WHERE user_id = ?");
        $deleteStmt->execute([$userId]);

        // Reassign roles
        foreach ($roles as $role) {
            $insertStmt = $this->db->prepare("
                INSERT INTO user_roles (user_id, role_id)
                SELECT :user_id, role_id FROM roles WHERE name = :role
            ");
            $insertStmt->execute([
                ':user_id' => $userId,
                ':role' => strtolower($role)
            ]);
        }

        return true;
    }

    /* -------------------------
        DELETE / SOFT DELETE
    --------------------------*/
    public function softDelete(int $id): bool
    {
        if ($this->isLastAdmin($id)) return false;

        $stmt = $this->db->prepare("UPDATE users SET deleted_at = NOW() WHERE user_id = ?");
        return $stmt->execute([$id]);
    }

    public function softDeleteMultiple(array $ids): bool
    {
        foreach ($ids as $id) {
            if ($this->isLastAdmin($id)) return false;
        }

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->db->prepare("UPDATE users SET deleted_at = NOW() WHERE user_id IN ($placeholders)");

        return $stmt->execute($ids);
    }

    public function isLastAdmin(int $id): bool
    {
        $check = $this->db->query("
            SELECT COUNT(*) FROM user_roles ur
            JOIN roles r ON ur.role_id = r.role_id
            WHERE r.name='admin'
        ");

        if ($check->fetchColumn() <= 1) {
            $stmt = $this->db->prepare("
                SELECT r.name FROM user_roles ur
                JOIN roles r ON ur.role_id = r.role_id
                WHERE ur.user_id = ?
            ");
            $stmt->execute([$id]);
            return $stmt->fetchColumn() === 'admin';
        }

        return false;
    }

    public function getDeleted(): array
    {
        $stmt = $this->db->query("
            SELECT * FROM users 
            WHERE deleted_at IS NOT NULL
            ORDER BY deleted_at DESC
        ");

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($u) => $this->mapUserWithRoles($u), $rows);
    }

    public function restore(int $id): bool
    {
        $stmt = $this->db->prepare("UPDATE users SET deleted_at = NULL WHERE user_id = ?");
        return $stmt->execute([$id]);
    }

    public function restoreMultiple(array $ids): bool
    {
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->db->prepare("UPDATE users SET deleted_at = NULL WHERE user_id IN ($placeholders)");
        return $stmt->execute($ids);
    }

    /* -------------------------
        SEARCH & LIST
    --------------------------*/
    public function getAll(): array
    {
        $stmt = $this->db->query("
            SELECT user_id, phone, email, username, first_name, last_name, status, phone_verified, 
                last_login, created_at, updated_at
            FROM users
            WHERE deleted_at IS NULL
            ORDER BY user_id DESC
        ");

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($u) => $this->mapUserWithRoles($u), $rows);
    }

    public function search(string $query): array
    {
        $stmt = $this->db->prepare("
            SELECT user_id, phone, email, username, first_name, last_name, status, phone_verified, 
               last_login, created_at, updated_at
            FROM users
            WHERE deleted_at IS NULL
            AND (
                first_name LIKE :q OR
                last_name LIKE :q OR
                phone LIKE :q OR
                email LIKE :q OR
                username LIKE :q
            )
        ");

        $stmt->execute([':q' => "%$query%"]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($row) => $this->mapUserWithRoles($row), $rows);
    }

    public function filterByStatus(string $status): array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM users
            WHERE deleted_at IS NULL
            AND status = :status
            ORDER BY user_id DESC
        ");
        $stmt->execute([':status' => $status]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($u) => $this->mapUserWithRoles($u), $rows);
    }

    /* -------------------------
        UTILITY
    --------------------------*/
    private function mapUserWithRoles(array $userData): User
    {
        $stmt = $this->db->prepare("
            SELECT r.name FROM roles r
            JOIN user_roles ur ON ur.role_id = r.role_id
            WHERE ur.user_id = ?
        ");
        $stmt->execute([$userData['user_id']]);

        $roles = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $userData['roles'] = $roles;

        return new User($userData);
    }

    public function setStatus(int $userId, string $status): bool
    {
        $stmt = $this->db->prepare("
            UPDATE users SET status = ?, updated_at = NOW()
            WHERE user_id = ?
        ");

        return $stmt->execute([$status, $userId]);
    }

    public function getExportData(): array
    {
        $stmt = $this->db->query("
            SELECT user_id, first_name, last_name, phone, email, status, created_at 
            FROM users 
            WHERE deleted_at IS NULL
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
