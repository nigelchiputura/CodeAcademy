<?php
require '../../config/twilio.php';
require '../../config/db_con.php';
require '../../validation.php';
require '../../models/users/password_reset.php';

$phone = $_POST['phone'] ?? '';

if (inputEmpty($phone)) {
    die("Phone number required.");
}

// Check if user exists
$user = get_user($pdo, $phone);

if (!$user) {
    die("If registered, you’ll get a code.");
}

$user_id = $user['user_id'];

// Rate limiting: max 3 requests/hour
rate_limit($pdo, $user_id);

// Generate OTP
$otp = rand(100000, 999999);

save_otp($pdo, $user_id, $otp);

// Send SMS via Twilio
try {
    $twilio->messages->create($phone, [
        "from" => TWILIO_NUMBER,
        "body" => "Your password reset code is: $otp (valid 10 mins)"
    ]);
    echo "If registered, you’ll get a code.";
} catch (Exception $e) {
    echo "SMS Error: " . $e->getMessage();
}
