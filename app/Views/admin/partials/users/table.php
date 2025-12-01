<form id="usersForm" action="users/delete_selected.php" method="post">

    <?php csrf_field(); ?>

    <div class="table-container">
        <table class="table table-hover table-bordered table-striped align-middle">
            <thead>
                <tr>

                    <?php if (!in_array('auditor', $_SESSION['roles'])): ?>
                    <th><input type="checkbox" id="selectAllUsers"></th>
                    <?php endif; ?>

                    <th>Username</th>
                    <th>Roles</th>
                    <th>Phone No</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr data-user-id="<?= htmlspecialchars($user['id']); ?>">
                        
                        <?php if (!in_array('auditor', $_SESSION['roles'])): ?>
                        <td>
                            <input type="checkbox" class="user-checkbox"
                                   name="user_ids[]" value="<?= htmlspecialchars($user['id']); ?>">
                        </td>
                        <?php endif; ?>

                        <td><?= htmlspecialchars($user['username'] ?? $user['phone']); ?></td>
                        <td>
                            <?php if (!empty($user['roles'])): ?>
                                <?php foreach ($user['roles'] as $role): ?>
                                    <span class="badge bg-primary me-1">
                                        <?= htmlspecialchars(ucfirst($role)); ?>
                                    </span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="text-muted">No role</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($user['phone']); ?></td>
                        <td>
                            <span class="badge bg-<?php echo $user['status'] === 'active' ? 'success' : ($user['status'] === 'disabled' ? 'secondary' : ($user['status'] === 'locked' ? 'danger' : 'warning')); ?>">
                                <?= htmlspecialchars($user['status']) ?>
                            </span>
                        </td>

                        <?php $userJsonData = json_encode($user); ?>
                        
                        <td class="actions text-center btn-group btn-group-sm"
                            role="group"
                            data-user_info='<?= $userJsonData ?>'>

                            <?php if (!in_array('auditor', $_SESSION['roles'])): ?>

                            <button type="button"
                                    class="btn btn-sm btn-primary edit-user-detail-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editUserModal"
                                    id="update">
                                <i class="fas fa-edit"></i> Edit
                            </button>

                            <button type="button"
                                    class="btn btn-sm btn-danger delete-user-detail-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteUserModal"
                                    id="delete">
                                <i class="fas fa-trash"></i> Delete
                            </button>

                            <?php endif; ?>

                            <button type="button"
                                    class="btn btn-sm btn-info text-white view-user-detail-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewUserModal"
                                    id="read">
                                <i class="fas fa-eye"></i> View
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</form>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmDeleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i> Confirm Deletion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete the selected
                <span id="selectedCount" class="fw-bold text-danger">0</span> user(s)?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                <!-- Submits usersForm with selected user_ids -->
                <button type="submit" class="btn btn-danger" form="usersForm">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>
