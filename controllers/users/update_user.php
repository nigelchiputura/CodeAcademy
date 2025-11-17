<?php

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["user-update"])) {
    $userId = (int)trim($_POST["user-update"]);
    $username = trim($_POST["username-update"]);
    $role = trim($_POST["role-update"]);
    $fullName = trim($_POST["full_name-update"]);
    $email = trim($_POST["email-update"]);
    $phoneNumber = trim($_POST["phone-update"]);

    try {
        require_once('../../config/db_con.php');
        require_once('../../models/users/UserManager.php');
        require_once('../../validation.php');

        $UserManager = new UserManager($pdo);

        // ERROR EXCEPTIONS
        $errors = [];

        if (inputEmpty($username, $role, $fullName, $email, $phoneNumber)) {
            $errors["empty_input"] = "Fill in all fields!";
        }

        require_once("../../config/session.php");

        if ($errors) {
            $_SESSION["errors"] = $errors;
        } else {
            unset($_SESSION['errors']);

            $UserManager->updateUserInfo(
                $userId,
                $username,
                $role,
                $phoneNumber,
                $fullName,
                $email
            );
        }

        header("Location: /views/admin/dashboard.php?request=users");
        die();

    } catch (PDOException $e) {
        die("Query Failed: ".$e->getMessage());
    }
} else {
    header("Location: /views/admin/dashboard.php?request=users");
    die();
}