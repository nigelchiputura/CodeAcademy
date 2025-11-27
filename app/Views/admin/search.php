<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container pt-3">
    
    <?php if (!$users): ?> 
        <h1 class='display-6 fw-bold text-danger'>No users match Your Search Parameter!<h1>

    <?php else: ?>

    <h1 class="display-6">Search Results</h1>
    <hr>
    <?php require_once __DIR__ . '/partials/users/table.php'; ?>
    <?php require_once __DIR__ . '/partials/users/crud_modals.php'; ?>
    
    <?php endif ?>

</div>

<script src="/portal/assets/static/js/admin.js"></script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>