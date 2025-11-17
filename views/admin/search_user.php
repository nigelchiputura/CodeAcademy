<?php
require_once("../../config/session.php");
require_once("../../config/db_con.php");
require_once("../../models/users/UserManager.php");
require_once("../../validation.php");
require_once("../../includes/header.php");
?>

<div class='container pt-5'>

    <?php
    if (isAdmin()) {
        $queryParameter = trim($_GET["users"]);
        $searchTerm = "%".$queryParameter."%";

        $userManager = new UserManager($pdo);

        $users = $userManager->getUsersByName($searchTerm);

        if (!$users) {
            echo "<p class='display-6 fw-bold text-danger'>No users match Your Search Parameter!<p>";
            die();
        }

        require_once("../../includes/admin/table.php");
        require_once("../../includes/admin/crud_user_modals.php");

    ?>

</div>
<script src="../../assets/static/js/admin.js"></script>

<?php 
    require_once("../../includes/footer.php");
    } else {
        header("Location: ../../index.php");
    }
?>