<?php
ini_set('display_errors', 0);
require_once __DIR__ . '/../../../bootstrap.php';

use App\Helpers\Auth;
use App\Controllers\AdminController;

// Only admin & auditor can download user reports
Auth::requireRole(['admin', 'auditor']);

$controller = new AdminController();
$controller->exportUsers();