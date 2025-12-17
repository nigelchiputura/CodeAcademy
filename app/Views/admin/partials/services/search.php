<?php require_once __DIR__ . '/../../../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../sidebar.php'; ?>

<div class="container pt-3">
    
    <?php if (!$services): ?> 
        <h1 class='display-6 fw-bold text-warning'>No Services Match Your Search Parameter!<h1>

    <?php else: ?>

    <h1 class="display-6">Search Results</h1>
    <hr>
    <?php require_once __DIR__ . '/table.php'; ?>
    <?php require_once __DIR__ . '/crud_modals.php'; ?>
    
    <?php endif ?>

</div>

<script src="/portal/assets/static/js/admin.js"></script>

<?php require_once __DIR__ . '/../../../layouts/footer.php'; ?>