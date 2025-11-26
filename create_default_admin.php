<?php

require_once("./config/db_con.php");
require_once("./models/users/UserManager.php");

$userManager = new UserManager($pdo);

if (php_sapi_name() !== 'cli') {
    die("This script must be run from the command line.\n");
}

require_once("./config/db_con.php");

// Check if admin user already exists

$adminCount = $userManager->fetchAdminCount();

if ($adminCount > 0) 
    die("Admin user already exists.");

// Get user input from CLI
echo "Enter admin username: ";
$username = trim(fgets(STDIN));

echo "Enter admin phone: ";
$phone = trim(fgets(STDIN));

echo "Enter admin password: ";
$password = trim(fgets(STDIN));


// Hash the password
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Insert into DB
$query = "INSERT INTO users (username, phone, password, role) VALUES (?, ?, ?, ?)";
$insert = $pdo->prepare($query);
$insert->execute([$username, $phone, $hashedPassword, "admin"]);

echo "Admin user created successfully.\n";