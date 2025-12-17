<?php

namespace App\Helpers;

use App\Repositories\UserRepository;

class Auth
{
    public static function requireLogin()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /admin-login");
            exit;
        }
    }

    public static function requireRole(array $requiredRoles)
    {
        self::requireLogin();

        $userRoles = $_SESSION['roles'] ?? [];

        if (!array_intersect($requiredRoles, $userRoles)) {
            http_response_code(403);
            echo "Access Denied.";
            exit;
        }
    }


    public static function redirectIfAuthenticated()
    {
        if (!isset($_SESSION['user_id'])) return;

        $repo = new UserRepository();
        $user = $repo->findById($_SESSION['user_id']);

        if ($user && $user->is_password_temporary) {
            header("Location: /update_password.php");
            exit;
        }

        // redirect based on highest access role
        if ($user->isAdmin()) {
            header("Location: /admin/dashboard.php");
        } else if ($user->isAuditor()) {
            header("Location: /admin/dashboard.php");
        } elseif ($user->isTeacher()) {
            header("Location: /teacher/dashboard.php");
        } elseif ($user->isParent()) {
            header("Location: /parent/dashboard.php");
        } else {
            header("Location: /student/dashboard.php");
        }

        exit;
    }

    public static function redirectToActiveRolePortal(): void
    {
        self::requireLogin();

        $active = $_SESSION['active_role'] ?? null;

        if ($active === null) {
            $roles = $_SESSION['roles'] ?? [];
            $active = $roles[0] ?? null;
            $_SESSION['active_role'] = $active;
        }

        switch ($active) {
            case 'admin':
                header('Location: /admin/dashboard.php');
                break;

            case 'teacher':
                header('Location: /teacher/dashboard.php');
                break;

            case 'parent':
                header('Location: /parent/dashboard.php');
                break;

            case 'student':
                header('Location: /student/dashboard.php');
                break;

            case 'auditor':
                header('Location: /admin/dashboard.php');
                break;

            default:
                header('Location: /');
        }

        exit;
    }

    // public function hasRoleAny(array $roles): bool
    // {
    //     foreach ($roles as $role) {
    //         if ($this->hasRole($role)) return true;
    //     }
    //     return false;
    // }
}
