<?php 
require_once('./includes/header.php');
require_once('./validation.php');
require_once('./config/db_con.php');
require_once('./config/session.php');
require_once('./models/users/UserManager.php');

$UserManager = new UserManager($pdo);
$user = $UserManager->getUserById($_SESSION["user_id"]);

checkForFirstLogin($user);
?>

<h1 class="text-center display-3">Welcome To CodeWithNigey Academy</h1>
<h1 class="text-center display-4">Start Your Coding Journey Here!</h1>
<form action="./auth/logout.php" method="post">
    <button type="submit" name="logout-submit" class="btn btn-warning nowrap">
        <i class="fas fa-sign-out-alt"></i>
        <span>Logout</span>
    </button>
</form>

<?php echo $_SESSION["role"] ?>

<?php require_once('./includes/footer.php');?>