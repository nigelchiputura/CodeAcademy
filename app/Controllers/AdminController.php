<?php

namespace App\Controllers;

use App\Services\AdminService;
use App\Repositories\ActivityLogRepository;
use App\Helpers\Auth;


class AdminController
{
    private AdminService $service;
    private ActivityLogRepository $logs;

    public function __construct()
    {
        $this->service = new AdminService();
        $this->logs = new ActivityLogRepository();
        require_once __DIR__ . '/../../functions.php';
    }

    public function dashboard()
    {
        outputFlashMessage();
        $recent = $this->logs->getRecent();
        $activityLogs = $this->logs->getAll();
        $users = $this->service->getAllUsers();

        // Dashboard primary stats
        $primaryStats = [
            [
                'key'   => 'users',
                'label' => 'Total Users',
                'count' => count($users),
                'icon'  => 'users',
                'color' => 'primary',
                'link'  => '/admin/users.php',
            ],
            [
                'key'   => 'students',
                'label' => 'Students',
                'count' => 78, // TODO
                'icon'  => 'user-graduate',
                'color' => 'success',
                'link'  => '#',
            ],
            [
                'key'   => 'teachers',
                'label' => 'Teachers',
                'count' => 98, // TODO
                'icon'  => 'chalkboard-teacher',
                'color' => 'info',
                'link'  => '#',
            ],
            [
                'key'   => 'payments',
                'label' => 'Payments',
                'count' => 238, // TODO
                'icon'  => 'credit-card',
                'color' => 'warning',
                'link'  => '#',
            ],
            [
                'key'   => 'activity_logs',
                'label' => 'Activity Logs',
                'count' => count($activityLogs),
                'icon'  => 'history',
                'color' => 'secondary',
                'link'  => '/admin/activity_log.php',
            ],
        ];

        require __DIR__ . '/../Views/admin/dashboard.php';
    }

    public function activityLog() {

        $filters = [
            'q'       => $_GET['q'] ?? null,
            'action'  => $_GET['action'] ?? null,
            'user_id' => $_GET['user_id'] ?? null,
        ];

        // Pagination
        $page  = max(1, (int)($_GET['page'] ?? 1));
        $limit = 10;
        $offset = ($page - 1) * $limit;

        // Count total logs for pagination
        $totalLogs  = $this->logs->countFiltered($filters);
        $totalPages = ceil($totalLogs / $limit);

        // Retrieve filtered logs
        $activityLogs = $this->logs->search($filters, $limit, $offset);

        // For dropdown filters
        $actionsList = $this->logs->getDistinctActions();
        $usersList   = $this->service->getAllUsers();

        // $activityLogs = $this->logs->getAll();
        require __DIR__ . '/../Views/admin/activity_log.php';
    }

    public function users()
    {
        outputFlashMessage();
        $userRepo = new \App\Repositories\UserRepository();

        // Filters
        $roleFilter = $_GET['role'] ?? null;
        $searchQuery = $_GET['users'] ?? null;

        // Roles dropdown
        $rolesList = $userRepo->getAllRoles();

        if ($roleFilter) {
            $users = $userRepo->filterByRole($roleFilter);
        } elseif ($searchQuery) {
            $users = $userRepo->search($searchQuery);
        } else {
            $users = $userRepo->getAll();
        }

        require __DIR__ . '/../Views/admin/users.php';
    }

    public function searchUsers()
    {
        $users = $this->service->searchUsers($_GET['users'] ?? '');
        require __DIR__ . '/../Views/admin/partials/users/search.php';
    }

    public function addUser()
    {
        Auth::requireRole(["admin"]);

        $_SESSION['flash_time'] = time();
        $response = $this->service->addUser($_POST);
        $_SESSION[$response['type']] = $response['message'];
        header("Location: /admin/users.php");
        exit;
    }

    public function updateUser()
    {
        Auth::requireRole(["admin"]);

        $_SESSION['flash_time'] = time();
        $response = $this->service->updateUser($_POST);
        $_SESSION[$response['type']] = $response['message'];
        header("Location: /admin/users.php");
        exit;
    }

    public function deleteUser()
    {
        Auth::requireRole(["admin"]);

        $_SESSION['flash_time'] = time();
        $response = $this->service->deleteUser($_POST['user_id']);
        $_SESSION[$response['type']] = $response['message'];
        header("Location: /admin/users.php");
        exit;
    }

    public function deleteSelected()
    {
        Auth::requireRole(["admin"]);

        $_SESSION['flash_time'] = time();
        $response = $this->service->deleteSelected($_POST['user_ids'] ?? []);
        $_SESSION[$response['type']] = $response['message'];
        header("Location: /admin/users.php");
        exit;
    }

    public function recycleBin()
    {
        outputFlashMessage();
        $users = $this->service->getDeletedUsers();
        require __DIR__ . '/../Views/admin/partials/users/recycle_bin.php';
    }

    public function restoreUser()
    {
        Auth::requireRole(["admin"]);

        $_SESSION['flash_time'] = time();
        $response = $this->service->restoreUser($_POST['user_id']);
        $_SESSION[$response['type']] = $response['message'];
        header("Location: /admin/users/recycle_bin.php");
        exit;
    }

    public function restoreSelected()
    {
        Auth::requireRole(["admin"]);
        
        $_SESSION['flash_time'] = time();
        $response = $this->service->restoreSelected($_POST['user_ids'] ?? []);
        $_SESSION[$response['type']] = $response['message'];
        header("Location: /admin/users/recycle_bin.php");
        exit;
    }

    public function exportUsers(): void
    {
        $format = $_GET['format'] ?? 'csv';
        $filters = [];

        if (!empty($_GET['status'])) {
            $filters['status'] = $_GET['status']; 
        }

        $this->service->exportUsers($format, $filters);
    }

    public function exportLoginAttempts(): void
    {
        $format = $_GET['format'] ?? 'csv';
        $filters = [];

        if (!empty($_GET['reason'])) {
            $filters['reason'] = $_GET['reason'];
        }
        if (!empty($_GET['success'])) {
            $filters['success'] = $_GET['success'] === '1';
        }
        if (!empty($_GET['from'])) {
            $filters['from'] = $_GET['from'];
        }
        if (!empty($_GET['to'])) {
            $filters['to'] = $_GET['to'];
        }

        $this->service->exportLoginAttempts($format, $filters);
    }

    public function hardDelete()
    {
        Auth::requireRole(['admin']);

        $id = $_POST['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = 'Missing service ID';
            header("Location: /admin/services/recycle_bin.php");
            exit;
        }

        $_SESSION['flash_time'] = time();
        $this->service->users->hardDelete((int)$id);

        $_SESSION['success'] = 'User permanently deleted';

        header("Location: /admin/users/recycle_bin.php");
        exit;
    }
}