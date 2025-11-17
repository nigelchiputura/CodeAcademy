<?php
declare(strict_types=1);

require_once('../config/session.php');
require_once('../validation.php');
?>

<?php require_once('../includes/header.php'); ?>

<?php if (!isset($_SESSION['user_id'])) { ?>

<div class="login">
    
    <h1 class="mb-5 mt-3 display-6">Welcome To Nigey Academy</h1>
    <form action="/controllers/users/login.php" method="post" class="w-75 login--form p-4 form-control shadow">
        <h1 class="display-6 mb-5 fw-bold"><?php outputUsername() ?></h1>
        <input type="text" name="username" placeholder="Enter Username" class="form-control mb-3" required>
        <input type="password" name="password" placeholder="Enter Password" class="form-control mb-3" required>
        <input type="submit" name="login-submit" value="Login" class="submit mb-3 w-100 btn btn-success">
        <p><a href="">Forgot Your Password? Click Here To Reset.</a></p>
    </form>
    
</div>

<?php 
    } else {
        if ($_SESSION["role"] === "admin") {
            header("Location: ../views/admin/index.php");
        } else {
            header("Location: ../index.php");
        }
        die();
    }
    
    checkValidationErrors();
    require_once('../includes/footer.php');
?>