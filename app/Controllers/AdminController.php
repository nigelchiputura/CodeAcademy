<?php

namespace App\Controllers;

use App\Services\AdminService;
use App\Repositories\ActivityLogRepository;
use App\Helpers\Auth;


class AdminController
{
    private AdminService $service;

    public function __construct()
    {
        $this->service = new AdminService();
        require_once __DIR__ . '/../../functions.php';
    }

    public function dashboard()
    {
        outputFlashMessage();
        $recent = (new ActivityLogRepository())->getRecent();
        $users = $this->service->getAllUsers();
        require __DIR__ . '/../Views/admin/dashboard.php';
    }

    public function users()
    {
        outputFlashMessage();
        $users = $this->service->getAllUsers();
        require __DIR__ . '/../Views/admin/users.php';
    }

    public function searchUsers()
    {
        $users = $this->service->searchUsers($_GET['users'] ?? '');
        require __DIR__ . '/../Views/admin/search.php';
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
        require __DIR__ . '/../Views/admin/recycle_bin.php';
    }

    public function restoreUser()
    {
        Auth::requireRole(["admin"]);

        $_SESSION['flash_time'] = time();
        $response = $this->service->restoreUser($_POST['user_id']);
        $_SESSION[$response['type']] = $response['message'];
        header("Location: /admin/recycle_bin.php");
        exit;
    }

    public function restoreSelected()
    {
        Auth::requireRole(["admin"]);
        
        $_SESSION['flash_time'] = time();
        $response = $this->service->restoreSelected($_POST['user_ids'] ?? []);
        $_SESSION[$response['type']] = $response['message'];
        header("Location: /admin/recycle_bin.php");
        exit;
    }

    public function exportUsers(): void
    {
        $format = $_GET['format'] ?? 'csv';
        $filters = [];

        if (!empty($_GET['status'])) {
            $filters['status'] = $_GET['status']; // e.g. active/locked/disabled
        }

        $this->service->exportUsers($format, $filters);
    }

    public function exportLoginAttempts(): void
    {
        $format = $_GET['format'] ?? 'csv';
        $filters = [];

        if (!empty($_GET['reason'])) {
            $filters['reason'] = $_GET['reason']; // e.g. wrong_password
        }
        if (!empty($_GET['success'])) {
            $filters['success'] = $_GET['success'] === '1';
        }
        if (!empty($_GET['from'])) {
            $filters['from'] = $_GET['from']; // 2025-01-01
        }
        if (!empty($_GET['to'])) {
            $filters['to'] = $_GET['to']; // 2025-01-31
        }

        $this->service->exportLoginAttempts($format, $filters);
    }

}