<?php

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["user-create"])) {
    $username = trim($_POST["username-create"]);
    $role = trim($_POST["role-create"]);
    $fullName = trim($_POST["full_name-create"]);
    $email = trim($_POST["email-create"]);
    $phoneNumber = trim($_POST["phone-create"]);

    try {
        require_once('../../config/db_con.php');
        require_once('../../models/users/UserManager.php');
        require_once('../../validation.php');
        require_once('../../config/twilio.php');

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

            $password = generatePassword();

            try {
                $twilio->messages->create($phoneNumber, [
                    "from" => TWILIO_NUMBER,
                    "body" => "Welcome to Nigey Academy. \nYour username is: $username \nYour password is $password"
                ]);
            } catch (Exception $e) {
                echo "SMS Error: " . $e->getMessage();
                die();
            }

            $UserManager->createUser(
                $username,
                $password,
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