<?php include __DIR__ . '/../layouts/header.php'; ?>

<?php include __DIR__ . '/../admin/partials/navbar.php'; ?>

    <section id="admin">

        <?php include __DIR__ . '/partials/sidebar.php'; ?>

        <main>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="display-6 m-0">Welcome <?= $_SESSION["name"] ?></h1>
            </div>
            <hr>

            <div class="rounded-pill">

                <form class="d-flex mb-5" action="./search.php" method="get">

                    <input class="form-control me-2 rounded-pill text-center" type="search" name="users" placeholder="Search Users" aria-\ label="Search">

                    <button class="btn btn-outline-secondary rounded-pill" type="submit">
                            <i class="fas fa-search"></i>
                    </button>

                </form>

            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="text-capitalize">Users</h4>
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fas fa-user-plus"></i> Add New User
                </button>
            </div>

            <div class="d-flex justify-content-between mb-3">
                <button class="btn btn-sm btn-danger" id="deleteSelectedBtn" disabled>
                    <i class="fas fa-trash-alt me-2"></i> Delete Selected
                </button>
            </div>

            <?php include __DIR__ . '/../admin/partials/users/table.php'; ?>

        </main>

<?php include __DIR__ . '/../admin/partials/users/crud_modals.php'; ?>

<script src="/portal/assets/static/js/admin.js"></script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
