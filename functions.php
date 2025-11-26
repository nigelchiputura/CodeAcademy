<?php

function removeFlashMessage($sessionVar) {
    if (isset($_SESSION["success"]) || isset($_SESSION["error"])) {
        if (time() - $_SESSION['flash_time'] > 5) {
            unset($_SESSION[$sessionVar]);
            unset($_SESSION["flash_time"]);
        }
    }
}

function outputFlashMessage() {
    if (isset($_SESSION['error'])) {
        $errorMsg = $_SESSION['error'];

        echo "<p class='error display-msg' id='success-msg'>$errorMsg</p>";
        removeFlashMessage("error");
    }
    if (isset($_SESSION['success'])) {
        $successMsg = $_SESSION['success'];

        echo "<p class='success display-msg' id='success-msg'>$successMsg</p>";
        removeFlashMessage("success");
    }
}

function inputEmpty(string ...$fields) {
    foreach ($fields as $field) {
        if (empty($field)) {
            return true;
        }
    } return false;
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