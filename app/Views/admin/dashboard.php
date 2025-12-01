<?php include __DIR__ . '/../layouts/header.php'; ?>

<section id="admin">

    <?php include __DIR__ . '/partials/sidebar.php'; ?>

    <main>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="display-6 m-0">Welcome <?= $_SESSION["name"] ?></h1>
        </div>
        <hr>
        
        <div class="stats-container mb-5">
            <div class="row g-4">
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card shadow-sm p-4 rounded fade-in">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h2 class="fw-bold mb-0 text-primary">
                                    <?= count($users); ?>
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
                                    <?= rand(30, 150);?>
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
                                    <?php echo rand(5, 30); ?>
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
                                    <?php echo rand(200, 500); ?>
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

        <div class="dash-link-container mb-5">
            
                <a class="dash-link p-4" href="./users.php">
                    <i class="fas fa-user"></i>
                    <hr>
                    Manage Users
                </a>
                <a class="dash-link p-4" href="./courses.php">
                    <i class="fas fa-book"></i>
                    <hr>
                    Manage Courses
                </a>
                <a class="dash-link p-4" href="./students.php">
                    <i class="fas fa-user-graduate"></i>
                    <hr>
                    Manage Students
                </a>
                <a class="dash-link p-4" href="./payments.php">
                    <i class="fas fa-credit-card"></i>
                    <hr>
                    Manage Payments
                </a>

        </div>

        <hr>

        <div class="mt-5">
            <h4>Recent Activity</h4>
            <div class="card shadow-sm p-3">
                <?php if (empty($recent)): ?>
                    <p class="text-muted mb-0 text-center">No recent actions</p>
                <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($recent as $log): ?>
                            <li class="list-group-item text-secondary">
                                <strong><?= htmlspecialchars($log['action']) ?></strong>
                                — <?= htmlspecialchars($log['details'] ?? '') ?>
                                <span class="text-muted float-end small">
                                    <?= date("d M Y H:i", strtotime($log['created_at'])) ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

    </main>

</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>