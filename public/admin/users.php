<?php

require_once __DIR__ . '/../../bootstrap.php';

use App\Helpers\Auth;
use App\Controllers\AdminController;

Auth::requireRole(['admin']);

$controller = new AdminController();
$controller->users();
