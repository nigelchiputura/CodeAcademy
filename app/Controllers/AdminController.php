<?php

namespace App\Controllers;

use App\Services\AdminService;

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

    public function deleteUser()
    {
        $_SESSION['flash_time'] = time();
        $response = $this->service->deleteUser($_POST['user_id']);

        $_SESSION[$response['type']] = $response['message'];
        header("Location: /public/admin/users.php");
        exit;
    }

    public function deleteSelected()
    {
        $_SESSION['flash_time'] = time();
        $response = $this->service->deleteSelected($_POST['user_ids'] ?? []);

        $_SESSION[$response['type']] = $response['message'];
        header("Location: /public/admin/users.php");
        exit;
    }

    public function addUser()
    {
        $_SESSION['flash_time'] = time();
        $response = $this->service->addUser($_POST);

        $_SESSION[$response['type']] = $response['message'];
        header("Location: /public/admin/users.php");
        exit;
    }

    public function updateUser()
    {
        $_SESSION['flash_time'] = time();
        $response = $this->service->updateUser($_POST);

        $_SESSION[$response['type']] = $response['message'];
        header("Location: /public/admin/users.php");
        exit;
    }
}
