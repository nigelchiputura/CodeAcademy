<?php

namespace App\Controllers;

use App\Services\AuthService;
use App\Helpers\Auth;

class AuthController
{
    private AuthService $service;

    public function __construct()
    {
        $this->service = new AuthService();
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

        if(isset($response['error'])) {
            $_SESSION['error'] = $response['error'];
            header("Location: /public/login.php");
            exit;
        }

        $user = $response['user'];
        
        session_regenerate_id(true);

        switch ($user->role) {

            case 'admin':
                header("Location: /public/admin/dashboard.php");
                break;

            case 'teacher':
                header("Location: /public/teacher/dashboard.php");
                break;

            case 'parent':
                header("Location: /public/parent/dashboard.php");
                break;

            case 'student':
                header("Location: /public/student/dashboard.php");
                break;

            default:
                header("Location: /public/login.php");
        }
        exit;
    }


    public function showRegister()
    {
        outputFlashMessage();
        require __DIR__ . '/../Views/auth/register.php';
    }

    public function register()
    {
        // Ensure user is logged in and admin
        Auth::requireRole(["admin"]);

        $response = $this->service->register($_POST);

        if(isset($response['error'])) {
            $_SESSION['error'] = $response['error'];
            header("Location: /admin/add_user.php");
            exit;
        }

        header("Location: /admin/users.php");
    }

    public function showUpdatePassword()
    {
        outputFlashMessage();
        $user = $this->service->getSessionUser();
        require __DIR__ . '/../Views/auth/update_password.php';
    }

    public function updatePassword()
    {
        $_SESSION['flash_time'] = time();

        $response = $this->service->updatePassword($_POST);

        if(isset($response['error'])) {
            $_SESSION['error'] = $response['error'];
            // die($response['error']);
            header("Location: /public/update_password.php");
            exit;
        }

        $_SESSION['success'] = 'Password updated successfully';
        header("Location: /public/index.php");
        exit;
    }
}
