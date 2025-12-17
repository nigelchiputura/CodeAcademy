<?php

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../functions.php';

use App\Helpers\Auth;
use App\Controllers\ChatbotController;

Auth::requireRole(['admin', 'auditor']);
require_valid_csrf_token();

$controller = new ChatbotController();
$controller->index();