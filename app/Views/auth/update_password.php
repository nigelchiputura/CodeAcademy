<?php include __DIR__ . '/../layouts/header.php'; ?>

<h2 class="display-4 text-center fw-bold">Password Change</h2>

<form action="/public/update_password.php" method="post">
    
    <?php if ($user->last_login): ?>
    <input class="form-control" type="password" name="old_password" placeholder="Old Password">
    <?php endif ?>

    <input class="form-control" type="password" name="new_password" placeholder="New Password">
    <input class="form-control" type="password" name="confirm_new_password" placeholder="Confirm New Password">
    <button type="submit" name="user_id" value="<?= $_SESSION["user_id"] ?>">Update Password</button>

</form>

<script src="/public/assets/static/js/flashMessage.js"></script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>