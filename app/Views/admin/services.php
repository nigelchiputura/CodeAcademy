<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php include __DIR__ . '/partials/navbar.php'; ?>

<section id="admin" class="pt-5 mt-3">

    <?php include __DIR__ . '/partials/sidebar.php'; ?>

    <main>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="display-6 m-0">Services</h1>
        </div>
        <hr>

        <!-- Search -->
        <div class="rounded-pill">
            <form class="filter-bar card shadow-sm p-3 mb-4" action="./users/search.php" method="get">
                    
                <div class="row g-3 align-items-end">

                    <div class="col-md-1 col-sm-1">
                        <button class="btn btn-outline-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#serviceHowToModal" type="button"><i class="fas fa-question"></i></button>
                    </div>
                    
                    <div class="col-md-9 col-sm-11">
                        <input class="form-control me-2 rounded-pill text-center" 
                        type="search" 
                        name="services" 
                        placeholder="Search Services..."
                        aria-label="Search">
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">Search <i class="fas fa-search"></i></button>
                    </div>
                </div>

            </form>
        </div>

        <!-- Top buttons -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            
        <?php if (!in_array('auditor', $_SESSION['roles'])): ?>

            <button class="btn btn-success btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#addServiceModal">
                <i class="fas fa-plus"></i> Add New Service
            </button>

        <?php endif; ?>

            <a class="btn btn-outline-secondary btn-sm" href="./services/recycle_bin.php">
                <i class="fas fa-recycle"></i> Recycle Bin
            </a>
        </div>

        <?php include __DIR__ . '/partials/services/table.php'; ?>

    </main>

</section>

<div class="modal fade" id="serviceHowToModal" tabindex="-1" aria-labelledby="serviceHowToModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-info" id="serviceHowToModalLabel"><i class="fas fa-question"></i> Using Search Feature (Services Module)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-secondary">How To Use The Search Function For The Services Module?</p>
                You can search for services in your database/system using the following criteria:
                    <ul>
                        <li>Title</li>
                        <li>Slug</li>
                        <li>Short Description</li>
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

<?php include __DIR__ . '/partials/services/crud_modals.php'; ?>

<script src="/portal/assets/static/js/admin.js"></script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
