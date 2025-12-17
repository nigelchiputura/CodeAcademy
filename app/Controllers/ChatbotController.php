<?php

namespace App\Controllers;

use App\Services\ChatbotAdminService;
use App\Repositories\ChatbotRepository;
use App\Helpers\Auth;

class ChatbotController
{
    private ChatbotAdminService $service;
    private ChatbotRepository $repo;

    public function __construct()
    {
        $this->service = new ChatbotAdminService();
        $this->repo = new ChatbotRepository();
    }

    public function index()
    {
        outputFlashMessage();
        $faqs = $this->service->getAll();
        require __DIR__ . '/../Views/admin/chatbot.php';
    }

    public function create()
    {
        Auth::requireRole(['admin']);

        $_SESSION['flash_time'] = time();
        $response = $this->service->create($_POST);
        $_SESSION[$response['type']] = $response['message'];

        header("Location: /admin/chatbot.php");
        exit;
    }

    public function update()
    {
        Auth::requireRole(['admin']);

        $id = (int)$_POST['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = 'Missing FAQ ID';
            header("Location: /admin/chatbot.php");
            exit;
        }

        $_SESSION['flash_time'] = time();
        $response = $this->service->update($_POST);
        $_SESSION[$response['type']] = $response['message'];

        header("Location: /admin/chatbot.php");
        exit;
    }

    public function delete()
    {
        Auth::requireRole(['admin']);

        $id = $_POST['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = 'Missing FAQ ID';
            header("Location: /admin/chatbot.php");
            exit;
        }
        
        $_SESSION['flash_time'] = time();
        $response = $this->service->delete($id);
        $_SESSION[$response['type']] = $response['message'];

        header("Location: /admin/chatbot.php");
        exit;
    }
}
