<?php

// declare(strict_types=1);

function get_user(object $pdo, string $phone) {
    $query = "SELECT * FROM users WHERE phone = :phone";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":phone", $phone);
    $stmt->execute();
    $user = $stmt->fetch();

    return $user;
}

function rate_limit(object $pdo, int $user_id) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM password_resets WHERE user_id = ? AND created_at > (NOW() - INTERVAL 1 HOUR)");
    $stmt->execute([$user_id]);
    $reqCount = $stmt->fetchColumn();
    if ($reqCount >= 3) {
        die("Too many requests. Try again later.");
    }        
}

function save_otp(object $pdo, int $user_id, int $otp) {
    $stmt = $pdo->prepare("INSERT INTO password_resets (user_id, otp, created_at, expires_at) VALUES (?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 10 MINUTE))");
    $stmt->execute([$user_id, $otp]);
}

function validate_otp(object $pdo, int $user_id, int $otp) {
    $query = "SELECT * FROM password_resets WHERE user_id = :user_id AND otp = :otp AND expires_at > NOW() ORDER BY id DESC LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->bindParam(":otp", $otp);
    $stmt->execute();
    $result = $stmt->fetch();

    return $result;
}

function delete_otps(object $pdo, int $user_id) {
    $query = "DELETE FROM password_resets WHERE user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();
}