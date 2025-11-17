<?php

if (php_sapi_name() !== 'cli') {
    die("This script must be run from the command line.\n");
}

require_once("./config/db_con.php");

// Check if admin user already exists

$query = "SELECT COUNT(*) FROM users WHERE role = 'admin'";
$stmt = $pdo->prepare($query);
$stmt->execute();

if ($stmt->fetchColumn() > 0) 
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