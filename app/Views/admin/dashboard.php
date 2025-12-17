<?php include __DIR__ . '/../layouts/header.php'; ?>

<section id="admin">

    <?php include __DIR__ . '/partials/sidebar.php'; ?>

    <main>

        <!-- HEADER -->
        <div class="dashboard-header">
            <div>
                <h1 class="display-6">Welcome <?= htmlspecialchars($_SESSION["name"]) ?></h1>
                <small class="text-muted">Admin Dashboard</small>
            </div>

            <button
                class="btn btn-outline-danger"
                data-bs-toggle="modal"
                data-bs-target="#logoutModal"
            >
                <i class="fas fa-power-off me-2"></i> Logout
            </button>
        </div>

        <!-- QUICK ACTIONS -->
        <div class="quick-actions">
            <a href="./users.php" class="btn btn-primary btn-sm">
                <i class="fas fa-user-plus"></i> Add User
            </a>

            <a href="./activity_log.php" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-history"></i> View Logs
            </a>
        </div>

        <!-- STATS -->
        <div class="stats-container">
            <div class="row g-4">

                <?php
                $primaryStats = [
                    ['label'=>'Users','count'=>count($users),'icon'=>'users','color'=>'primary'],
                    ['label'=>'Students','count'=>78,'icon'=>'user-graduate','color'=>'success'],
                    ['label'=>'Teachers','count'=>98,'icon'=>'chalkboard-teacher','color'=>'info'],
                    ['label'=>'Payments','count'=>238,'icon'=>'credit-card','color'=>'warning'],
                ];
                ?>

                <?php foreach ($primaryStats as $stat): ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="stat-card">
                            <div class="stat-content">
                                <div>
                                    <h2 class="text-<?= $stat['color'] ?>">
                                        <?= $stat['count'] ?>
                                    </h2>
                                    <span><?= $stat['label'] ?></span>
                                </div>
                                <i class="fas fa-<?= $stat['icon'] ?> text-<?= $stat['color'] ?>"></i>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

        <!-- MODULES -->
        <h4 class="section-title">Modules</h4>

        <div class="modules-grid">

            <a href="./users.php" class="module-tile">
                <i class="fas fa-user-shield"></i>
                <span>Users</span>
            </a>

            <a href="#" data-bs-toggle="modal" data-bs-target="#wipModal" class="module-tile">
                <i class="fas fa-user-graduate"></i>
                <span>Students</span>
            </a>

            <a href="#" data-bs-toggle="modal" data-bs-target="#wipModal" class="module-tile">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Teachers</span>
            </a>

            <a href="#" data-bs-toggle="modal" data-bs-target="#wipModal" class="module-tile">
                <i class="fas fa-book"></i>
                <span>Courses</span>
            </a>

            <a href="#" data-bs-toggle="modal" data-bs-target="#wipModal" class="module-tile">
                <i class="fas fa-credit-card"></i>
                <span>Payments</span>
            </a>

            <a href="./chatbot.php" class="module-tile">
                <i class="fas fa-question"></i>
                <span>Chatbot FAQ</span>
            </a>

        </div>

        <!-- RECENT ACTIVITY -->
        <div class="recent-activity">
            <h4 class="section-title">Recent Activity</h4>

            <div class="card activity-card">
                <?php if (empty($recent)): ?>
                    <p class="text-muted text-center mb-0">No recent actions</p>
                <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($recent as $log): ?>
                            <li class="list-group-item">
                                <strong><?= htmlspecialchars($log['action']) ?></strong>
                                — <?= htmlspecialchars($log['details'] ?? '') ?>
                                <span class="timestamp">
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
