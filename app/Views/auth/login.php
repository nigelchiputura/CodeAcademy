<?php include __DIR__ . '/../layouts/header.php'; ?>

<section class="login">
    
    <form method="post" action="/login.php" class="login--form">
        <p class="lead text-capitalize text-secondary">Welcome To CodeAcademy</p>
        <!-- <p class="lead text-capitalize text-secondary">login to continue</p> -->
        <?php csrf_field(); ?>

        <input type="text" name="phone" placeholder="Phone Number" class="form-control mb-3" required>
        <input type="password" name="password" placeholder="Password" class="form-control mb-3" required>
        <input type="submit" value="Login" class="submit mb-3 w-100 btn btn-success">
        <p><a href="/forgot_password.php">Forgot Your Password? Click Here To Reset.</a></p>
    </form>

</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>