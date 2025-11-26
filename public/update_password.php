<?php

require_once __DIR__ . '/../bootstrap.php';

use App\Controllers\AuthController;
use App\Helpers\Auth;

Auth::requireLogin();

$controller = new AuthController();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->updatePassword();
} else {
    $controller->showUpdatePassword();
}