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
            
            <div class="stats-container mb-5">
                <div class="row g-4">
                    <div class="col-md-3 col-sm-6">
                        <div class="stat-card shadow-sm p-4 rounded fade-in">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h2 class="fw-bold mb-0 text-primary">
                                        <?php echo count($userManager->getAllUsers()); ?>
                                    </h2>
                                    <small class="text-muted">Total Users</small>
                                </div>
                                <i class="fas fa-users fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="stat-card shadow-sm p-4 rounded fade-in">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h2 class="fw-bold mb-0 text-success">
                                        <?php echo rand(30, 150); // Replace with count from DB ?>
                                    </h2>
                                    <small class="text-muted">Total Students</small>
                                </div>
                                <i class="fas fa-user-graduate fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="stat-card shadow-sm p-4 rounded fade-in">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h2 class="fw-bold mb-0 text-info">
                                        <?php echo rand(5, 30); // Replace with actual course count ?>
                                    </h2>
                                    <small class="text-muted">Total Courses</small>
                                </div>
                                <i class="fas fa-book fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="stat-card shadow-sm p-4 rounded fade-in">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h2 class="fw-bold mb-0 text-warning">
                                        <?php echo rand(200, 500); // Replace with actual payment count ?>
                                    </h2>
                                    <small class="text-muted">Payments Recorded</small>
                                </div>
                                <i class="fas fa-credit-card fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                
                <h4>Modules</h4>

            </div>

            <div class="dash-link-container">
                
                    <a class="dash-link p-4" href="./dashboard.php?request=users">
                        <i class="fas fa-user"></i>
                        <hr>
                        Manage Users
                    </a>
                    <a class="dash-link p-4" href="./dashboard.php?request=courses">
                        <i class="fas fa-book"></i>
                        <hr>
                        Manage Courses
                    </a>
                    <a class="dash-link p-4" href="./dashboard.php?request=students">
                        <i class="fas fa-user-graduate"></i>
                        <hr>
                        Manage Students
                    </a>
                    <a class="dash-link p-4" href="./dashboard.php?request=payments">
                        <i class="fas fa-credit-card"></i>
                        <hr>
                        Manage Payments
                    </a>

            </div>

        </main>
        
    </section>

<?php 
    }
    else {
        header("Location: ../../auth/login.php");
    }
    require_once("../../includes/footer.php");
?>