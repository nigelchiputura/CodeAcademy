<?php

namespace App\Controllers;

use App\Services\AuthService;
use App\Services\PasswordResetService;
use App\Helpers\Auth;

class AuthController
{
    private AuthService $service;
    private PasswordResetService $passwordResets;

    public function __construct()
    {
        $this->service        = new AuthService();
        $this->passwordResets = new PasswordResetService();
        require_once __DIR__ . '/../../functions.php';
    }

    public function showLogin()
    {
        Auth::redirectIfAuthenticated();
        outputFlashMessage();
        require __DIR__ . '/../Views/auth/login.php';
    }

    public function login()
    {
        $_SESSION['flash_time'] = time();

        $response = $this->service->login($_POST['phone'], $_POST['password']);

        if (isset($response['error'])) {
            $_SESSION['error'] = $response['error'];
            header("Location: /admin-login");
            exit;
        }

        // If temporary password, force reset
        if (isset($response['reset_required'])) {
            header("Location: /update_password.php");
            exit;
        }

        session_regenerate_id(true);

        // Route based on active role
        // Auth::redirectToActiveRolePortal();
        header("Location: /admin/dashboard.php");

        exit;
    }

    public function showUpdatePassword()
    {
        Auth::requireLogin();
        outputFlashMessage();
        $user = $this->service->getSessionUser();
        require __DIR__ . '/../Views/auth/update_password.php';
    }

    public function updatePassword()
    {
        $_SESSION['flash_time'] = time();

        $response = $this->service->updatePassword(
            intval($_SESSION['user_id']),
            $_POST
        );

        if (isset($response['error'])) {
            $_SESSION['error'] = $response['error'];
            header("Location: /update_password.php");
            exit;
        }

        $_SESSION['success'] = $response['success'];

        Auth::redirectToActiveRolePortal();
        exit;
    }

    public function showForgotPassword()
    {
        outputFlashMessage();
        require __DIR__ . '/../Views/auth/forgot_password.php';
    }

    public function requestPasswordReset()
    {
        $_SESSION['flash_time'] = time();

        $response = $this->passwordResets->requestReset($_POST['phone'] ?? '');

        $_SESSION[$response['type']] = $response['message'];
        header("Location: /forgot-password.php");
        exit;
    }

    public function showResetPasswordForm()
    {
        outputFlashMessage();
        require __DIR__ . '/../Views/auth/reset_password.php';
    }

    public function handlePasswordReset()
    {
        $_SESSION['flash_time'] = time();

        $response = $this->passwordResets->resetPassword(
            $_POST['phone']        ?? '',
            $_POST['reset_code']   ?? '',
            $_POST['new_password'] ?? '',
            $_POST['confirm_password'] ?? ''
        );

        if ($response['type'] === 'success') {
            $_SESSION['success'] = $response['message'];
            header("Location: /admin-login");
        } else {
            $_SESSION['error'] = $response['message'];
            header("Location: /reset-password");
        }
        exit;
    }
}
