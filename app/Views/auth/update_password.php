<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5" style="max-width: 500px;">
    <h3 class="text-center mb-4">Update Password</h3>
    <hr>

    <form method="post" action="/update_password.php">
        
        <?php csrf_field(); ?>
        
        <?php if (!isset($_SESSION['force_password_reset'])): ?>
        <div class="mb-3">
            <label class="form-label">Current Password</label>
            <input type="password" name="old_password" class="form-control" required>
        </div>
        <?php endif; ?>

        <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" name="new_password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm New Password</label>
            <input type="password" name="confirm_new_password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Update Password
        </button>
    </form>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
