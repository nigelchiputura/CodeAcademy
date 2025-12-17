<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Repositories\UserRepository;
use App\Config\Database;

$days = 30;

// cutoff datetime
$cutoff = date('Y-m-d H:i:s', strtotime("-$days days"));

$userRepo = new UserRepository();

// Purge users
$stmt = Database::connection()->prepare("
    DELETE FROM users 
    WHERE deleted_at IS NOT NULL 
    AND deleted_at < ?
");
$stmt->execute([$cutoff]);

echo "Purged soft-deleted items older than $days days\n";
