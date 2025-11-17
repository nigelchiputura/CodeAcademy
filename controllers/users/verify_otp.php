<?php
require '../../config/db_con.php';
require '../../validation.php';
require '../../models/users/password_reset.php';
require '../../models/users/UserManager.php';

$UserManager = new UserManager($pdo);

$phone    = $_POST['phone'] ?? '';
$otp      = $_POST['otp'] ?? '';
$password = $_POST['password'] ?? '';

if (inputEmpty($phone, $otp, $password)) {
    die("All fields required.");
}

// Find user
$user = $UserManager->getUserByPhone($phone);

if (!$user) {
    die("Invalid request.");
}

$user_id = $user['user_id'];

// Validate OTP
$confirm_otp = validate_otp($pdo, $user_id, $otp);

if (!$confirm_otp) {
    die("Invalid or expired code.");
}

// Update password
$UserManager->updatePassword($user_id, $password);

// Clean up OTPs
delete_otps($pdo, $user_id);

echo "Password reset successful!";
