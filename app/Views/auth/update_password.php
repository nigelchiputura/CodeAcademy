<?php include __DIR__ . '/../layouts/header.php'; ?>

<section class="form-page">

    <h2 class="display-4 fw-medium">Password Change</h2>

    <form action="/update_password.php" method="post">
        
        <?php if ($user->last_login): ?>
        <input class="form-control" type="password" name="old_password" placeholder="Old Password" required>
        <?php endif ?>

        <input class="form-control" type="password" name="new_password" placeholder="New Password" required>
        <input class="form-control" type="password" name="confirm_new_password" placeholder="Confirm New Password" required>
        <button type="submit" name="user_id" value="<?= $_SESSION["user_id"] ?>">Update Password</button>

    </form>

</section>

<script src="/public/assets/static/js/flashMessage.js"></script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>