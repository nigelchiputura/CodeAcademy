<?php

require_once __DIR__ . '/../../../bootstrap.php';
require_once __DIR__ . '/../../../functions.php';

use App\Helpers\Auth;
use App\Controllers\AdminController;

Auth::requireRole(['admin']);
require_valid_csrf_token();

$controller = new AdminController();
$controller->deleteSelected();
