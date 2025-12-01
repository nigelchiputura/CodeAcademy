<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Services\TwilioService;
use App\Repositories\ActivityLogRepository;
use App\Repositories\LoginAttemptRepository;


class AdminService
{
    private UserRepository $users;
    private LoginAttemptRepository $loginAttempts;
    private ActivityLogRepository $activityLog;

    public function __construct()
    {
        $this->users = new UserRepository();
        $this->loginAttempts = new LoginAttemptRepository;
        $this->activityLog = new ActivityLogRepository;
        require_once __DIR__ . '/../../functions.php';
    }

    /* -------------------------
        READ
    --------------------------*/
    public function getAllUsers(): array
    {
        return array_map(fn($u) => $u->sanitizeForFrontend(), $this->users->getAll());
    }

    public function searchUsers(string $term): array
    {
        return array_map(fn($u) => $u->sanitizeForFrontend(), $this->users->search($term));
    }

    public function getUsers(array $filters = []): array
    {
        // For now we only support filtering by status; you can extend later
        if (!empty($filters['status'])) {
            $users = $this->users->filterByStatus($filters['status']);
        } else {
            $users = $this->users->getAll();
        }

        return array_map(fn($u) => $u->sanitizeForFrontend(), $users);
    }

    /* -------------------------
        CREATE
    --------------------------*/
    public function addUser(array $data): array
    {
        if (inputEmpty($data['first_name'], $data['last_name'], $data['phone'], $data['email'])) {
            return ['type' => 'error', 'message' => 'Fill in all fields'];
        }

        $plainPassword = generatePassword();
        $passwordHash = password_hash($plainPassword, PASSWORD_BCRYPT);

        $userId = $this->users->create([
            'phone' => $data['phone'],
            'email' => $data['email'],
            'username' => $data['username'] ?? null,
            'password_hash' => $passwordHash,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'created_by' => $_SESSION['user_id'] ?? null
        ]);

        $this->users->assignRoles($userId, $data['roles'] ?? ['student']);
        $this->activityLog->log($_SESSION['user_id'], "{$_SESSION['name']} Created User", "User {$data['phone']} added");

        try {
            $sms = new TwilioService();
            $sms->sendSms(
                $data['phone'], 
                "Welcome to CodeWithNigey Academy. \nLogin: {$data['phone']} \nPassword: {$plainPassword}"
            );
            return ['type' => 'success', 'message' => 'User created successfully & SMS sent'];
        } catch (\Throwable $e) {
            return ['type' => 'warning', 'message' => 'User created but SMS failed'];
        }
    }

    /* -------------------------
        UPDATE
    --------------------------*/
    public function updateUser(array $data): array
    {
        if ($this->users->isLastAdmin($data['user_id']) && !in_array('admin', $data['roles'])) {
            return ['type' => 'error', 'message' => 'Cannot remove role admin from last admin'];
        }

        $this->users->update([
            'user_id' => $data['user_id'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'username' => $data['username'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'status' => $data['status'],      // NEW
            'updated_by' => $_SESSION['user_id']
        ]);

        $this->users->updateUserRoles($data['user_id'], $data['roles']);
        $this->activityLog->log($_SESSION['user_id'], "{$_SESSION['name']} Updated User", "User \"{$data['first_name']} {$data['last_name']}\" Was Updated");

        return ['type' => 'success', 'message' => 'User updated successfully'];
    }

    /* -------------------------
        DELETE (Soft Delete)
    --------------------------*/
    public function deleteUser(int $id): array
    {
        if ($this->users->isLastAdmin($id)) {
            return ['type' => 'error', 'message' => 'Cannot delete last remaining admin'];
        }

        $this->users->softDelete($id);
        $this->activityLog->log($_SESSION['user_id'], "{$_SESSION['name']} Deleted User", "ID: {$id}");

        return ['type' => 'success', 'message' => 'User moved to recycle bin'];
    }

    public function deleteSelected(array $ids): array
    {
        if (empty($ids)) {
            return ['type' => 'error', 'message' => 'No users selected'];
        }

        if (!$this->users->softDeleteMultiple($ids)) {
            return ['type' => 'error', 'message' => 'Delete prevented (admin protection)'];
        }

        $this->activityLog->log($_SESSION['user_id'], "{$_SESSION['name']} Deleted {count($ids)} Users", "IDs: {$ids}");

        return ['type' => 'success', 'message' => count($ids) . ' users archived'];
    }

    public function restoreUser(int $id): array
    {
        $this->users->restore($id);

        $this->activityLog->log($_SESSION['user_id'], "{$_SESSION['name']} Restored Deleted User", "ID: {$id}");

        return ['type' => 'success', 'message' => 'User restored successfully'];
    }

    public function restoreSelected(array $ids): array
    {
        if (empty($ids)) {
            return ['type' => 'error', 'message' => 'No users selected'];
        }

        $this->users->restoreMultiple($ids);
        $this->activityLog->log($_SESSION['user_id'], "{$_SESSION['name']} Restored {count($ids)} Deleted Users", "IDs: {$ids}");

        return ['type' => 'success', 'message' => count($ids) . ' users restored'];
    }

    public function getDeletedUsers(): array
    {
        return $this->users->getDeleted();
    }

    /**
     * Returns [headers, rows] ready for ExportService::streamCsv/Txt
     */
    public function getUsersForExport(array $filters = []): array
    {
        $sanitized = $this->getUsers($filters); // same data as table

        $headers = [
            'ID',
            'Username',
            'Roles',
            'Phone',
            'Email',
            'First Name',
            'Last Name',
            'Status',
            'Phone Verified',
            'Created At',
            'Last Login',
        ];

        $rows = array_map(function (array $u) {
            return [
                $u['id'],
                $u['username'],
                implode(',', $u['roles']),
                $u['phone'],
                $u['email'],
                $u['first_name'],
                $u['last_name'],
                $u['status'],
                $u['phone_verified'] ? 'yes' : 'no',
                $u['created_at'],
                $u['last_login'],
            ];
        }, $sanitized);

        return [$headers, $rows];
    }

    /**
     * Convenience wrapper if you ever want the service to stream directly.
     */
    public function exportUsers(string $format, array $filters = []): void
    {
        [$headers, $rows] = $this->getUsersForExport($filters);
        $date = date('Y-m-d');

        if ($format === 'txt') {
            $this->activityLog->log($_SESSION['user_id'], "{$_SESSION['name']} Exported Users", "Downloaded User Txt");
            ExportService::streamTxt("users_{$date}.txt", $headers, $rows);
        } else {
            $this->activityLog->log($_SESSION['user_id'], "{$_SESSION['name']} Exported Users", "Downloaded User CSV");
            ExportService::streamCsv("users_{$date}.csv", $headers, $rows);
        }
    }

    public function getLoginAttemptsForExport(array $filters = []): array
    {
        $attempts = $this->loginAttempts->getByFilters($filters);

        $headers = [
            'Attempt ID',
            'User ID',
            'Username',
            'Phone Attempted',
            'Reason',
            'IP Address',
            'Success',
            'Attempted At',
        ];

        $rows = array_map(function (array $a) {
            return [
                $a['attempt_id'],
                $a['user_id'],
                $a['username'] ?? '',
                $a['phone_attempted'],
                $a['reason'],
                $a['ip_address'],
                $a['success'] ? 'yes' : 'no',
                $a['attempted_at'],
            ];
        }, $attempts);

        return [$headers, $rows];
    }

    public function exportLoginAttempts(string $format, array $filters = []): void
    {
        [$headers, $rows] = $this->getLoginAttemptsForExport($filters);
        $date = date('Y-m-d');

        if ($format === 'txt') {
            $this->activityLog->log($_SESSION['user_id'], "{$_SESSION['name']} Downloaded User Login Attempts", "Downloaded In TXT format");
            ExportService::streamTxt("login_attempts_{$date}.txt", $headers, $rows);
        } else {
            $this->activityLog->log($_SESSION['user_id'], "{$_SESSION['name']} Downloaded User Login Attempts", "Downloaded In CSV format");
            ExportService::streamCsv("login_attempts_{$date}.csv", $headers, $rows);
        }
    }

}
