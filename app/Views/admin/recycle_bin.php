<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">

    <?php include __DIR__ . '/../admin/partials/sidebar.php'; ?>

    <h1 class="display-6"><i class="fas fa-recycle"></i> Recycle Bin</h1>
    <hr>

    <?php if ($users): ?>

        <form id="restoreForm" action="./users/restore_selected.php" method="post">
            <div class="d-flex justify-content-between mb-3">
                <button class="btn btn-sm btn-primary" id="restoreSelectedBtn" disabled>
                    <i class="fas fa-undo"></i> Restore Selected
                </button>
            </div>
            <table class="table table-hover table-bordered align-middle">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAllRestore"></th>
                        <th>Username</th>
                        <th>Roles</th>
                        <th>Deleted At</th>

                        <?php if (!in_array('auditor', $_SESSION['roles'])): ?>
                        <th>Actions</th>
                        <?php endif; ?>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td>
                                <input type="checkbox"
                                    class="restore-checkbox"
                                    name="user_ids[]"
                                    value="<?= $user->id ?>">
                            </td>
                            <td><?= htmlspecialchars($user->username) ?></td>
                            <td><?= implode(', ', $user->roles) ?></td>
                            <td><?= htmlspecialchars($user->deleted_at) ?></td>

                            <?php if (!in_array('auditor', $_SESSION['roles'])): ?>

                            <td>
                                <form action="./users/restore.php" method="post">
                                    <button class="btn btn-sm btn-success"
                                            name="user_id"
                                            value="<?= $user->id ?>">
                                        <i class="fas fa-undo"></i> Restore
                                    </button>
                                </form>
                            </td>

                            <?php endif; ?>

                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </form>
    <?php else: ?>
        <h1 class="display-6 fw-medium text-success">Recycle Bin Is Empty</h1>
    <?php endif ?>
</div>

<script src="/portal/assets/static/js/restore_deleted.js"></script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>