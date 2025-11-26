<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class AuthService
{
    private UserRepository $users;

    public function __construct()
    {
        $this->users = new UserRepository();
        require_once __DIR__ . '/../../functions.php';
    }

    public function login(string $phone, string $password): ?array
    {
        $user = $this->users->findByPhone($phone);

        if(!$user) {
            return ['error' => 'User not found'];
        }

        if(!password_verify($password, $user->password)) {
            return ['error' => 'Incorrect password'];
        }

        require_once __DIR__ . '/../config/session.php';

        $_SESSION['user_id'] = $user->id;
        $_SESSION['role'] = $user->role;
        $_SESSION['name'] = $user->full_name;

        return ['success' => true, 'user' => $user];
    }

    public function register(array $data): array
    {
        if($this->users->findByPhone($data['phone'])) {
            return ['error' => 'Phone number already registered'];
        }

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        $success = $this->users->create($data);

        return $success ? ['success' => true] : ['error' => 'Registration failed'];
    }
    
    public function updatePassword(array $data): array
    {   
        $user = $this->getSessionUser();

        if (inputEmpty($data['old_password'], $data['new_password'])) {
            return ['error' => 'Fill out all fields!'];
        }
        
        if ($data['new_password'] !== $data['confirm_new_password']) {
            return ['error' => 'Passwords do not match!'];
        }
        
        if(!password_verify($data['old_password'], $user->password) && $user->last_login) {
            return ['error' => 'Incorrect password'];
        }

        $data['new_password'] = password_hash($data['new_password'], PASSWORD_BCRYPT);
        $data['user_id'] = intval($data['user_id']);

        $success = $this->users->updatePassword($data);

        return $success ? ['success' => true] : ['error' => 'Password update failed'];
    }

    public function getSessionUser(): User
    {
        $userId = intval($_SESSION['user_id']);
        $user = $this->users->findById($userId);

        return $user;
    }
}