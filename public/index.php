<?php
require_once __DIR__ . '/../bootstrap.php';

// trim query string and leading slash
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// AUTH URLS
if ($uri === 'admin-login') {
    (new \App\Controllers\AuthController())->showLogin();
    exit;
}

if ($uri === 'forgot-password') {
    (new \App\Controllers\AuthController())->showForgotPassword();
    exit;
}

if ($uri === 'reset-password') {
    (new \App\Controllers\AuthController())->showResetPasswordForm();
    exit;
}

// PUBLIC URLS
if ($uri === '' || $uri === 'home') {
    (new \App\Controllers\IndexController());
    exit;
}

// Chatbot AJAX endpoint
if ($uri === 'chatbot/query') {
    (new \App\Controllers\Public\ChatbotController())->query();
    exit;
}

// OTHER ROUTES
http_response_code(404);
require __DIR__ . '/../app/Views/public/404.php';