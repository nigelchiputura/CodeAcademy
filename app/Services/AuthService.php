<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\LoginAttemptRepository;

class AuthService
{
    private UserRepository $users;
    private LoginAttemptRepository $loginAttempts;

    public function __construct()
    {
        $this->users = new UserRepository();
        $this->loginAttempts = new LoginAttemptRepository();
        require_once __DIR__ . '/../../functions.php';
    }

    public function login(string $phone, string $password): array
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? null;
        $user = $this->users->findByPhone($phone);

        // If user not found OR soft deleted
        if (!$user) {
            // log as failed attempt with no user_id
            $this->loginAttempts->log(null, $phone, 'wrong_password', false, $ip);
            return ['error' => 'Account not found'];
        }

        // If already disabled or locked
        if ($user->status === 'disabled' || $user->status === 'locked') {
            $this->loginAttempts->log($user->id, $phone, 'account_locked', false, $ip);
            return ['error' => 'Account is disabled or locked'];
        }

        // Incorrect password
        if (!password_verify($password, $user->password_hash)) {

            // log failed attempt
            $this->loginAttempts->log($user->id, $phone, 'wrong_password', false, $ip);

            // Check if we should lock the account
            $failed = $this->loginAttempts->countRecentFailedAttemptsForUser($user->id, 15);

            if ($failed >= 5) {
                // lock account
                $this->users->setStatus($user->id, 'locked');
                return ['error' => 'Too many failed attempts. Account has been locked.'];
            }

            return ['error' => 'Incorrect password'];
        }

        // Successful login
        $this->loginAttempts->log($user->id, $phone, 'success', true, $ip);

        require_once __DIR__ . '/../config/session.php';

        // Session structure
        $_SESSION['user_id']      = $user->id;
        $_SESSION['roles']        = $user->roles;            // array of role names
        $_SESSION['active_role']  = $user->roles[0] ?? null; // default first
        $_SESSION['name']         = $user->getFullName();

        // Update last login time
        $this->users->updateLastLogin($user->id);

        // Handle temporary password (force first-time change)
        if ($user->is_password_temporary) {
            $_SESSION['force_password_reset'] = true;
            return ['reset_required' => true, 'user' => $user];
        }

        return ['success' => true, 'user' => $user];
    }

    public function updatePassword(int $userId, array $data): array
    {
        $user = $this->users->findById($userId);

        if (!$user) {
            return ['error' => 'User not found'];
        }

        if ($data['new_password'] !== $data['confirm_new_password']) {
            return ['error' => 'Passwords do not match'];
        }

        // If not temporary password, verify old password
        if (!$user->is_password_temporary && !password_verify($data['old_password'], $user->password_hash)) {
            return ['error' => 'Incorrect current password'];
        }

        $hash = password_hash($data['new_password'], PASSWORD_BCRYPT);

        $success = $this->users->updatePassword($userId, $hash);

        if ($success) {

            // Handle status change for first-time setup
            if ($user->is_password_temporary) {
                $this->users->setStatus($userId, 'active');
                unset($_SESSION['force_password_reset']);  // only unset if temporary
            }

            return ['success' => 'Password updated successfully'];
        }

        return ['error' => 'Failed to update password'];
    }

    public function getSessionUser(): ?User
    {
        if (!isset($_SESSION['user_id'])) return null;

        return $this->users->findById((int)$_SESSION['user_id']);
    }
}
