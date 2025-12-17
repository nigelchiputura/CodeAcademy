<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php include __DIR__ . '/partials/sidebar.php'; ?>

<div class="admin-page activity-logs p-5">

    <div class="header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-6 fw-bold text-primary">
                Activity Logs <i class="fas fa-history"></i>
            </h1>
        </div>
    </div>

    <!-- Filters -->
    <form method="GET" class="filter-bar card shadow-sm p-3 mb-4">
        <div class="row g-3 align-items-end">

            <!-- Search -->
            <div class="col-md-4">
                <label class="form-label fw-semibold">Search</label>
                <input 
                    type="text" 
                    name="q" 
                    value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" 
                    class="form-control" 
                    placeholder="Search logs..."
                >
            </div>

            <!-- Filter by action -->
            <div class="col-md-3">
                <label class="form-label fw-semibold">Action</label>
                <select name="action" class="form-select">
                    <option value="">All</option>
                    <?php foreach ($actionsList as $a): ?>
                        <option 
                            value="<?= $a ?>" 
                            <?= (($_GET['action'] ?? '') === $a) ? 'selected' : '' ?>>
                            <?= $a ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Filter by user -->
            <div class="col-md-3">
                <label class="form-label fw-semibold">User</label>
                <select name="user_id" class="form-select">
                    <option value="">All Users</option>
                    <?php foreach ($usersList as $u): ?>
                        <option 
                            value="<?= $u['id'] ?>" 
                            <?= (($_GET['id'] ?? '') == $u['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($u['username']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary w-100">Apply</button>
            </div>
        </div>
    </form>

    <!-- Logs -->
    <div class="card shadow-sm">
        <?php if (empty($activityLogs)): ?>
            <p class="text-muted text-center py-5 fs-4">No activity found</p>
        <?php else: ?>
            <ul class="list-group list-group-flush">

                <?php foreach ($activityLogs as $log): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-start log-item">

                        <div>
                            <div class="fw-bold text-dark"><?= htmlspecialchars($log['action']) ?></div>
                            <div class="small text-muted"><?= htmlspecialchars($log['details'] ?? '') ?></div>

                            <?php if ($log['username']): ?>
                                <div class="small text-primary mt-1">
                                    <i class="fas fa-user"></i> 
                                    <?= htmlspecialchars($log['username']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="text-muted small">
                            <?= date("d M Y H:i", strtotime($log['created_at'])) ?>
                        </div>

                    </li>
                <?php endforeach; ?>

            </ul>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
        <nav class="mt-4">
            <ul class="pagination justify-content-center">

                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>">Previous</a>
                </li>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>">Next</a>
                </li>

            </ul>
        </nav>
    <?php endif; ?>

</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>