<?php include __DIR__ . '/../layouts/header.php'; ?>

<?php include __DIR__ . '/../admin/partials/navbar.php'; ?>

    <section class="pt-5 mt-3">

        <?php include __DIR__ . '/partials/sidebar.php'; ?>

        <main>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1>Users</h1>
            </div>
            <hr>

            <div class="filter-bar card shadow-sm p-3 mb-4">

                <div class="row g-3" method="get">

                    <form method="get" class="col-md-7">
                        
                        <div class="row g-3 align-items-end">

                            <div class="col-md-1 col-sm-1">
                                <button class="btn btn-outline-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#userHowToModal" type="button"><i class="fas fa-question"></i></button>
                            </div>
                            
                            <div class="col-md-8 col-sm-8">
                                <label class="form-label fw-semibold">Search Users Based On Criteria</label>
                                <input class="form-control me-2 text-center" type="search" name="users" placeholder="Search Users..." aria-label="Search">
                            </div>

                            <div class="col-md-3 col-sm-3 d-flex align-items-end">
                                <button class="btn btn-primary w-100">
                                    Search <i class="fas fa-search"></i>
                                </button>
                            </div>

                        </div>

                    </form>

                    <form method="get" id="filter" class="col-md-3" class="row g-3">

                        <label class="form-label fw-semibold">Filter Users By Role</label>
                        <select name="role" class="form-select">
                            <option value="">All Roles</option>
                            <?php foreach ($rolesList as $role): ?>
                                <option 
                                    value="<?= $role ?>" 
                                    <?= (($_GET['role'] ?? '') === $role) ? 'selected' : '' ?>>
                                        <?= ucfirst($role) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                    </form method="get">
                    
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100" form="filter">
                            Apply <i class="fas fa-filter"></i>
                        </button>
                    </div>

                </div>

            </div>
        
            <div class="filter-bar card shadow-sm p-3 mb-4">
                <p class="lead fw-medium text-secondary">Security Management <i class="fas fa-shield-alt"></i></p>
                <hr>
                <div class="row g-3 align-items-end">
                
                    <div class="col-md-6">
                        <label class="d-block form-label fw-semibold">See Who Tried To Access The Admin Panel</label>
                        <a href="/admin/reports/login_attempts.php?format=csv&reason=wrong_password" class="btn      btn-outline-primary  btn-sm">
                            Download Failed Login Attempts (CSV)
                        </a>
                    </div>

                    <div class="col-md-5" role="group" aria-label="Export users">
                        <label class="d-block form-label fw-semibold">Export All Users</label>
                        <div class="btn-group btn-group-sm"> 
                            <a href="./users/export.php?format=csv" class="btn btn-outline-secondary">
                                <i class="fas fa-file-csv"></i> Export CSV
                            </a>
                            <a href="./users/export.php?format=txt" class="btn btn-outline-secondary">
                                <i class="fas fa-file-alt"></i> Export TXT
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <?php if (!in_array('auditor', $_SESSION['roles'])): ?>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fas fa-user-plus"></i> Add New User
                </button>
            </div>

            <?php endif; ?>

            <div class="d-flex justify-content-between mb-3">
                
                <!-- <h4 class="text-capitalize">Users</h4> -->

                <button class="btn btn-sm btn-danger" id="deleteSelectedBtn" disabled>
                    <i class="fas fa-trash-alt me-2"></i> Delete Selected
                </button>
                
                <a class="btn btn-outline-secondary btn-sm" href="./users/recycle_bin.php">
                    <i class="fas fa-recycle"></i> Recycle Bin
                </a>
            </div>

            <?php include __DIR__ . '/../admin/partials/users/table.php'; ?>

        </main>

    </section>

    <div class="modal fade" id="userHowToModal" tabindex="-1" aria-labelledby="userHowToModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-info" id="userHowToModalLabel"><i class="fas fa-question"></i> Using Search Feature (Users Module)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-secondary">How To Use The Search Function For The Users Module?</p>
                    You can search for users in your database/system using the following criteria:
                        <ul>
                            <li>First Name</li>
                            <li>Last Name</li>
                            <li>UserName</li>
                            <li>Phone Number</li>
                            <li>Email</li>
                        </ul>
                    <br>
                    Thank you for trusting CodeWithNigey. <br> Your Support Is Truly Appreciated!  
                    <br><br>
                    — <strong>Nigel Chiputura</strong> (Software Developer)
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<?php include __DIR__ . '/../admin/partials/users/crud_modals.php'; ?>

<script src="/portal/assets/static/js/admin.js"></script>
<script src="/portal/assets/static/js/users.js"></script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>