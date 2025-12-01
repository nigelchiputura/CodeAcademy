<?php

require_once __DIR__ . '/../bootstrap.php';

use App\Helpers\Auth;

Auth::requireLogin();

if (!isset($_GET['role'])) {
    header('Location: /public/index.php');
    exit;
}

$role = strtolower($_GET['role']);
$available = $_SESSION['roles'] ?? [];

if (in_array($role, $available, true)) {
    $_SESSION['active_role'] = $role;
}

Auth::redirectToActiveRolePortal();
