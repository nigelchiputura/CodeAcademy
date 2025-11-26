<?php

namespace App\Services;

use App\Repositories\UserRepository;

class AdminService
{
    private UserRepository $users;

    public function __construct()
    {
        $this->users = new UserRepository();
        require_once __DIR__ . '/../../functions.php';
    }

    public function getAllUsers()
    {
        return $this->users->getAll();
    }

    public function searchUsers(string $term)
    {
        return $this->users->getUsersByName("%$term%");
    }

    public function deleteUser(int $id): array
    {
        if ($this->users->isLastAdmin($id)) {
            return ['type' => 'error', 'message' => 'Cannot delete the only remaining admin.'];
        }

        $this->users->delete($id);
        return ['type' => 'success', 'message' => 'User deleted successfully'];
    }

    public function deleteSelected(array $ids): array
    {
        if (empty($ids)) {
            return ['type' => 'error', 'message' => 'No users selected'];
        }

        foreach ($ids as $id) {
            if ($this->users->isLastAdmin($id)) {
                return ['type' => 'error', 'message' => 'Cannot delete the last admin'];
            }
        }

        $this->users->multiDelete($ids);
        return ['type' => 'success', 'message' => count($ids) . ' users deleted successfully'];
    }

    public function addUser(array $data): array
    {
        if (inputEmpty($data['username'], $data['role'], $data['full_name'], $data['email'], $data['phone'])) {
            return ['type' => 'error', 'message' => 'Fill in all fields'];
        }

        $passwordPlain = generatePassword();
        $passwordHash = password_hash($passwordPlain, PASSWORD_BCRYPT);

        $this->users->create([
            'username' => $data['username'],
            'password' => $passwordHash,
            'role' => strtolower($data['role']),
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone' => $data['phone']
        ]);

        try {
            $sms = new TwilioService();
            $sms->sendSms($data['phone'], "Welcome...\nUsername: {$data['username']}\nPassword: {$passwordPlain}");
            return ['type' => 'success', 'message' => 'User created & SMS sent'];
        } catch (\Throwable $e) {
            return ['type' => 'error', 'message' => 'User created, SMS failed: ' . $e->getMessage()];
        }
    }

    public function updateUser(array $data): array
    {
        if ($this->users->isLastAdmin($data['user_id']) && $data['role'] !== 'Admin') {
            return ['type' => 'error', 'message' => 'Cannot change role of last admin'];
        }

        $this->users->updateUserInfo($data);
        return ['type' => 'success', 'message' => 'User updated successfully'];
    }
}