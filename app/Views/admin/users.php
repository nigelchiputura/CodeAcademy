<?php include __DIR__ . '/../layouts/header.php'; ?>

<?php include __DIR__ . '/../admin/partials/navbar.php'; ?>

    <section id="admin" class="pt-5 mt-3">

        <?php include __DIR__ . '/partials/sidebar.php'; ?>

        <main>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="display-6 m-0">Welcome <?= $_SESSION["name"] ?></h1>
            </div>
            <hr>

            <div class="rounded-pill">

                <form class="d-flex mb-5" action="./search.php" method="get">

                    <input class="form-control me-2 rounded-pill text-center" type="search" name="users" placeholder="Search Users" aria-label="Search">

                    <button class="btn btn-outline-secondary rounded-pill" type="submit">
                            <i class="fas fa-search"></i>
                    </button>

                </form>

            </div>

            <!-- <div class="btn-group">
                <button class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fas fa-download"></i> Export
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="./users/export.php?format=csv">Export CSV</a></li>
                    <li><a class="dropdown-item" href="./users/export.php?format=excel">Export Excel</a></li>
                    <li><a class="dropdown-item" href="./users/export.php?format=pdf">Export PDF</a></li>
                </ul>
            </div> -->
            <div class="d-flex justify-content-between mb-3">

                <a href="/admin/reports/login_attempts.php?format=csv&reason=wrong_password" class="btn btn-outline-primary  btn-sm">
                    Download Failed Login Attempts (CSV)
                </a>

            </div>

            <div class="d-flex justify-content-between mb-3">

                <div class="btn-group btn-group-sm" role="group" aria-label="Export users">
                    <a href="./users/export.php?format=csv" class="btn btn-outline-secondary">
                        <i class="fas fa-file-csv"></i> Export CSV
                    </a>
                    <a href="./users/export.php?format=txt" class="btn btn-outline-secondary">
                        <i class="fas fa-file-alt"></i> Export TXT
                    </a>
                </div>
            </div>

            <?php if (!in_array('auditor', $_SESSION['roles'])): ?>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <button class="btn btn-sm btn-danger" id="deleteSelectedBtn" disabled>
                    <i class="fas fa-trash-alt me-2"></i> Delete Selected
                </button>

                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fas fa-user-plus"></i> Add New User
                </button>
            </div>

            <?php endif; ?>

            <div class="d-flex justify-content-between mb-3">
                
                <h4 class="text-capitalize">Users</h4>

                <a class="btn btn-outline-secondary btn-sm" href="./recycle_bin.php">
                    <i class="fas fa-recycle"></i> Recycle Bin
                </a>
            </div>

            <?php include __DIR__ . '/../admin/partials/users/table.php'; ?>

        </main>

    </section>

<?php include __DIR__ . '/../admin/partials/users/crud_modals.php'; ?>

<script src="/portal/assets/static/js/admin.js"></script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
