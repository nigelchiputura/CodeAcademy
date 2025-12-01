<?php

require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../functions.php';

use App\Controllers\ChatbotController;
require_valid_csrf_token();

$controller = new ChatbotController();
$controller->handle();
