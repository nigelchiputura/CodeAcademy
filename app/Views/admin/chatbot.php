<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php include __DIR__ . '/partials/navbar.php'; ?>

<section id="admin" class="pt-5 mt-3">

    <?php include __DIR__ . '/partials/sidebar.php'; ?>

    <main>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Chatbot FAQ Manager</h1>
        </div>

        <hr>

        <?php if (!in_array('auditor', $_SESSION['roles'])): ?>

        <button class="btn btn-success btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fas fa-plus"></i> Add FAQ
        </button>

        <?php endif; ?>

        <?php include __DIR__ . '/partials/chatbot/table.php'; ?>
        
        <?php include __DIR__ . '/partials/chatbot/crud_modals.php'; ?>
    </main>
</section>

<script src="/portal/assets/static/js/admin.js"></script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
