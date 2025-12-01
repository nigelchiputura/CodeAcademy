<?php

require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../functions.php';

use App\Controllers\AuthController;
use App\Helpers\Auth;

Auth::requireLogin();

$controller = new AuthController();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_valid_csrf_token();
    $controller->updatePassword();
} else {
    $controller->showUpdatePassword();
}