<?php

declare(strict_types=1);

function inputEmpty(string ...$fields) {
    foreach ($fields as $field) {
        if (empty($field)) {
            return true;
        }
    } return false;
}

function usernameIncorrect(bool|array $result) {
    if (!$result) {
        return true;
    } return false;
}

function passwordIncorrect(string $password, string $hashedPassword) {
    if (!password_verify($password, $hashedPassword)) {
        return true;
    } return false;
}

function passwordsMatch(string $password1, string $password2) {
    if ($password1 === $password2) {
        return true;
    } return false;
}

function outputUsername() {
    if (isset($_SESSION['user_id'])) {
        echo "<p>You are logged in as ".$_SESSION['username']."</p>";
    } else {
        echo "Please login to continue";
    }
}

function checkValidationErrors() {
    if (isset($_SESSION['errors'])) {
        $errors = $_SESSION['errors'];

        echo "<br>";
        foreach ($errors as $error) {
            echo "<p class='error display-msg' id='error-msg'>$error</p>";
            return;
        }
    }
}

function outputSuccessMessage() {
    if (isset($_SESSION['success_msg'])) {
        $successMsg = $_SESSION['success_msg'];

        echo "<br>";
        echo "<p class='success display-msg' id='success-msg'>$successMsg</p>";
        return;
    }
}

function generatePassword(int $length = 12) {
    $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $lower = 'abcdefghijklmnopqrstuvwxyz';
    $numbers = '0123456789';
    $symbols = '!@#%^&*()_-=+;:,.?';

    // Ensure password has at least one of each
    $all = $upper . $lower .$numbers . $symbols; 
    $password = '';
    $password .=$upper[random_int(0, strlen($upper) - 1)]; 
    $password .= $lower[random_int(0, strlen($lower) - 1)];
    $password .=$numbers[random_int(0, strlen($numbers) - 1)]; 
    $password .= $symbols[random_int(0, strlen($symbols) - 1)];

    for ($i = 4; $i < $length; $i++) {
        $password .= $all[random_int(0, strlen($all) - 1)];
    }
    
    // Shuffle the result for randomness
    return str_shuffle($password);
}

function checkForFirstLogin(array $user) {
    if ($user["last_login"] === null && $user["role"] != "admin") {
        header("Location: /auth/password_change.php");
        die();
    }
}

function isAuthenticated() {
    if (!isset($_SESSION["user_id"])) {
        return false;
    } return true;
}

function isAdmin() {
    if (!isset($_SESSION["user_id"]) && !$_SESSION["role"] == "admin") {
        return false;
    } return true;
}

function removeFlashMessage() {
    if (isset($_SESSION["success_msg"]) && isset($_SESSION["flash_time"])) {
        if (time() - $_SESSION["flash_time"] > 5) {
            unset($_SESSION["success_msg"]);
            unset($_SESSION["flash_time"]);
        }
    }
}