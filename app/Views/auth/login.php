<?php include __DIR__ . '/../layouts/header.php'; ?>

<form method="post" action="/public/login.php">
    <input type="text" name="phone" placeholder="Phone">
    <input type="password" name="password" placeholder="Password">
    <button type="submit">Login</button>
</form>

<?php include __DIR__ . '/../layouts/footer.php'; ?>