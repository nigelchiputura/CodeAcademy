<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <h1 class="mb-3">Forgot Password</h1>
    <p class="text-muted">Enter your phone number and we’ll send you a reset code via SMS.</p>
    
    <hr>

    <form method="POST" action="/forgot_password.php" class="mt-4 center" style="max-width: 400px;">

        <?php csrf_field(); ?>
        
        <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="text" name="phone" class="form-control" placeholder="Enter your registered phone" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Send Reset Code</button>
    </form>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
