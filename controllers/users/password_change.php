<?php
require_once('../../config/session.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    
    $old_password = trim($_POST['old-password']);
    $new_password = trim($_POST['new-password']);
    $confirm_password = trim($_POST['confirm-new-password']);

    require_once('../../models/users/UserManager.php');
    require_once('../../config/db_con.php');

    $UserManager = new UserManager($pdo);

    $username = $_SESSION['username'];
    $user = $UserManager->getUserByUsername($username);

    $hashed_password = $user['password'];
    $user_id = $user['user_id'];

    require_once('../../validation.php');

    $errors = [];

    if ($user["last_login"] !== null) {

        if (inputEmpty($old_password, $new_password, $confirm_password)) {
            $errors["empty_input"] = "Fill in all fields!";
        }

        if (passwordIncorrect($old_password, $hashed_password)) {
            $errors["incorrect_password"] = "Incorrect password!";
        }
    } else {
        
        if (inputEmpty($new_password, $confirm_password)) {
            $errors["empty_input"] = "Fill in all fields!";
        }

    }

    if (!passwordsMatch($new_password, $confirm_password)) {
        $errors["passwords_do_not_match"] = "Passwords do not match!";
    }

    if ($errors) {
        $_SESSION['errors'] = $errors;
        header("Location: /auth/password_change.php");
        die();
    }

    $UserManager->updatePassword($user_id, $new_password);
    unset($_SESSION['errors']);

    if ($user["last_login"] === null) {
        $UserManager->updateLastLogin($_SESSION["user_id"]);
    }

    header('Location: /index.php');
    die();

} else {
    header('Location: /index.php');
}