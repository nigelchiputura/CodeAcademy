<?php

namespace App\Helpers;

class Auth
{
    public static function requireLogin()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login.php");
            exit;
        }
    }

    public static function requireRole(array $roles)
    {
        self::requireLogin();

        if (!in_array($_SESSION['role'], $roles)) {
            http_response_code(403);
            echo "Access Denied.";
            exit;
        }
    }

    public static function redirectIfAuthenticated() {
        if (isset($_SESSION['user_id'])) {
            header("Location: /index.php");
            exit;
        }
    }
}
