<?php 
    require_once("../../includes/header.php");
    require_once("../../validation.php");
    require_once("../../config/session.php");
    require_once("../../config/db_con.php");
    require_once("../../models/users/UserManager.php");

    $userManager = new UserManager($pdo);

    $users = $userManager->getAllUsers();

    if (isset($_SESSION["user_id"]) && $_SESSION["role"] === "admin" ) {
?>

    <?php require_once("../../includes/admin/navbar.php") ?>

    <section id="admin">

        <?php require_once("../../includes/admin/sidebar.php") ?>

        <main>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="display-6 m-0">Welcome <?php echo $_SESSION["username"] ?></h1>
            </div>
            <hr>

            <div class="rounded-pill">

                <form class="d-flex mb-5" action="./search_user.php" method="get">

                    <input class="form-control me-2 rounded-pill text-center" type="search" name="<?= $_GET["request"] ?>" placeholder="Search <?= $_GET["request"] ?>" aria-\ label="Search">

                    <button class="btn btn-outline-secondary rounded-pill" type="submit">
                            <i class="fas fa-search"></i>
                            <!-- Search -->
                    </button>

                </form>

            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="text-capitalize"><?php echo $_GET["request"] ?></h4>
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fas fa-user-plus"></i> Add New User
                </button>
            </div>

            <div class="d-flex justify-content-between mb-3">
                <button class="btn btn-sm btn-danger" id="deleteSelectedBtn" disabled>
                    <i class="fas fa-trash-alt me-2"></i> Delete Selected
                </button>
            </div>

            <?php require_once("../../includes/admin/table.php") ?>

        </main>
        
        <?php
         checkValidationErrors();
         outputSuccessMessage();
         removeFlashMessage();
        ?>

    </section>

    <?php require_once("../../includes/admin/crud_user_modals.php") ?>
    
    <script src="../../assets/static/js/admin.js"></script>

    <script>
        setTimeout(function() {
            const message = document.querySelector(".display-msg");
            if (message) {
                message.style.opacity = 0;
            }
        }, 6000);
    </script>

<?php 
    }
    else {
        header("Location: ../../auth/login.php");
    }
    require_once("../../includes/footer.php");  
?>