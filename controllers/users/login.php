<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    try {
        require_once('../../config/db_con.php');
        require_once('../../models/users/UserManager.php');
        require_once('../../validation.php');

        $UserManager = new UserManager($pdo);

        // ERROR EXCEPTIONS
        $errors = [];

        if (inputEmpty($username, $password)) {
            $errors["empty_input"] = "Fill in all fields!";
        }

        $user = $UserManager->getUserByUsername($username);

        if (usernameIncorrect($user)) {
            $errors["login_incorrect"] = "Incorrect login info!";
        }
        if (!usernameIncorrect($user) && passwordIncorrect($password, $user["password"])) {
            $errors["login_incorrect"] = "Incorrect login info!";
        }
        
        require_once("../../config/session.php");

        if ($errors) {
            $_SESSION["errors"] = $errors;
            header("Location: /auth/login.php");
            die();
        }
        
        unset($_SESSION['errors']);

        // $newSessionId = session_create_id();
        // $sessionId = $newSessionId ."_". $user["user_id"];
        // session_id($sessionId);

        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["role"] = $user["role"];
        $_SESSION["username"] = htmlspecialchars($user["username"]);
        $_SESSION['last_regeneration'] = time();

        checkForFirstLogin($user);

        $UserManager->updateLastLogin($user["user_id"]);

        if ($_SESSION["role"] === "admin") {

            header("Location: ../../views/admin/index.php");

        } else {

            header("Location: ../../index.php");

        }

        $pdo = null;
        $stmt = null;
        die();

    } catch (PDOException $e) {
        die("Query Failed: ".$e->getMessage());
    }
} else {
    header("Location: ../../index.php");
    die();
}