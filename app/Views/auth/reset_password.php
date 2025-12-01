<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <h1 class="mb-3">Reset Password</h1>
    <p class="text-muted">
        Enter the phone number and reset code you received via SMS, then choose a new password.
    </p>

    <hr>

    <form method="POST" action="/reset_password.php" class="mt-4 center" style="max-width: 400px;">

        <?php csrf_field(); ?>
        
        <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Reset Code</label>
            <input type="text" name="reset_code" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" name="new_password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm New Password</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success w-100">Update Password</button>
    </form>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
