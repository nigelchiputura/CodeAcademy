<?php

require_once __DIR__ . '/../../bootstrap.php';

use App\Helpers\Auth;
use App\Controllers\AdminController;

Auth::requireRole(['admin', 'auditor']);

$controller = new AdminController();
$controller->recycleBin();
