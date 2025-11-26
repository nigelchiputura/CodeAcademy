<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php include __DIR__ . '/partials/sidebar.php'; ?>

<h1>Welcome <?= htmlspecialchars($_SESSION['name']); ?></h1>

<hr>

<div class="stats-container mb-5">
    <!-- All your stat cards exactly as before -->
</div>

<div class="dash-link-container">
    <a class="dash-link p-4" href="./users.php">
        <i class="fas fa-user"></i><hr>Manage Users
    </a>
    <a class="dash-link p-4" href="./courses.php">
        <i class="fas fa-book"></i><hr>Manage Courses
    </a>
    <a class="dash-link p-4" href="./students.php">
        <i class="fas fa-user-graduate"></i><hr>Manage Students
    </a>
    <a class="dash-link p-4" href="./payments.php">
        <i class="fas fa-credit-card"></i><hr>Manage Payments
    </a>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>

