<form id="usersForm" action="./users/delete_selected.php" method="post">
    <div class="table-container">
        <table class="table table-hover table-bordered table-striped align-middle">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAllUsers"></th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Phone No</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr data-user-id="<?= htmlspecialchars($user->id); ?>">
                        <td>
                            <input type="checkbox" class="user-checkbox" name="user_ids[]" value="<?= htmlspecialchars($user->id); ?>">
                        </td>
                        <td><?= htmlspecialchars($user->username);?></td>
                        <td><?= htmlspecialchars($user->role); ?></td>
                        <td><?= htmlspecialchars($user->phone); ?></td>
                        <?php $userJsonData = json_encode($user); ?>
                        <td class="actions text-center btn-group btn-group-sm" role="group" data-user_info='<?= $userJsonData ?>'>
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

                <button type="submit" class="btn btn-danger" form="usersForm">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const selectAll = document.getElementById("selectAllUsers");
    const checkboxes = document.querySelectorAll(".user-checkbox");
    const deleteBtn = document.getElementById("deleteSelectedBtn");
    const selectedCount = document.getElementById("selectedCount");

    selectAll?.addEventListener("change", () => {
        checkboxes.forEach(cb => cb.checked = selectAll.checked);
        updateDeleteButton();
    });

    checkboxes.forEach(cb => {
        cb.addEventListener("change", updateDeleteButton);
    });

    function updateDeleteButton() {
        const selected = document.querySelectorAll(".user-checkbox:checked").length;
        deleteBtn.disabled = selected === 0;
        selectedCount.textContent = selected;
    }
});
</script>