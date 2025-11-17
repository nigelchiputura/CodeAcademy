<?php
require_once('../validation.php');

if (!isAuthenticated()) {
    header("Location: ../../auth/login.php");
}

require_once('../includes/header.php');
require_once('../config/session.php');
require_once('../config/db_con.php');
require_once('../models/users/UserManager.php');

$userManager = new UserManager($pdo);
$user = $userManager->getUserById($_SESSION["user_id"]);

?>

<div class="form-page">
    <h2 class="display-4 text-center fw-bold">Password Change</h2>
    <form action="/controllers/users/password_change.php" method="post">
        <?php if ($user["last_login"]) { ?>
        <input class="form-control" type="password" name="old-password" placeholder="Old Password">
        <?php } ?>
        <input class="form-control" type="password" name="new-password" placeholder="New Password">
        <input class="form-control" type="password" name="confirm-new-password" placeholder="Confirm New Password">
        <input type="submit" name="password-change-submit"  value="Change Password">
    </form>
</div>
<?php 
checkValidationErrors();
require_once('../includes/footer.php') 
?>