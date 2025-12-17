<!-- ADD USER MODAL -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- hits public/admin/add_user.php -> AdminController::addUser -->
                <form action="/admin/users/add.php" method="post">

                    <?php csrf_field(); ?>

                    <div class="mb-3">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control" placeholder="Enter first name" name="first_name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control" placeholder="Enter last name" name="last_name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username (optional)</label>
                        <input type="text" class="form-control" placeholder="Enter username" name="username">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" placeholder="Enter phone number" name="phone" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" placeholder="Enter email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Roles</label>
                        <div class="d-flex flex-column">
                            <label>
                                <input type="checkbox" name="roles[]" value="admin">
                                Admin
                            </label>
                            <label>
                                <input type="checkbox" name="roles[]" value="auditor">
                                Auditor
                            </label>
                            <label>
                                <input type="checkbox" name="roles[]" value="client">
                                Client
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Save User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- EDIT USER MODAL -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- hits public/admin/update_user.php -> AdminController::updateUser -->
                <form action="/admin/users/update.php" method="post">

                    <?php csrf_field(); ?>

                    <!-- hidden id field updated by JS -->
                    <input type="hidden" name="user_id" id="id-update">

                    <div class="mb-3">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control update-field" id="first_name-update"
                               name="first_name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control update-field" id="last_name-update"
                               name="last_name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control update-field" id="username-update"
                               name="username">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control update-field" id="email-update"
                               name="email">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control update-field" id="phone-update"
                               name="phone" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Roles</label>
                        <div class="d-flex flex-column">
                            <label>
                                <input type="checkbox" class="role-checkbox" value="admin" name="roles[]">
                                Admin
                            </label>
                            <label>
                                <input type="checkbox" class="role-checkbox" value="auditor" name="roles[]">
                                Auditor
                            </label>
                            <label>
                                <input type="checkbox" class="role-checkbox" value="client" name="roles[]">
                                Client
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select update-field" id="status-update" name="status">
                            <option value="active">Active</option>
                            <option value="disabled">Disabled</option>
                            <option value="locked">Locked</option>
                            <option value="pending_verification">Pending Verification</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Update User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- DELETE USER MODAL -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteUserModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="confirm-delete">Are you sure you want to delete <strong></strong>?</p>
                <!-- hits public/admin/delete_user.php -> AdminController::deleteUser -->
                <form action="/admin/users/delete.php" method="post">

                    <?php csrf_field(); ?>

                    <div class="d-flex justify-content-end gap-2">
                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                        <button class="btn btn-danger" id="delete-detail-btn"
                                type="submit" name="user_id" value="">
                            Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- VIEW USER MODAL -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="viewUserModalLabel">User Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <li class="list-group-item" id="id"><strong>User ID:</strong> <span class="user-detail"></span></li>
                    <li class="list-group-item" id="username"><strong>Username:</strong> <span class="user-detail"></span></li>
                    <li class="list-group-item" id="roles"><strong>Roles:</strong> <span class="user-detail"></span></li>
                    <li class="list-group-item" id="email"><strong>Email:</strong> <span class="user-detail"></span></li>
                    <li class="list-group-item" id="phone"><strong>Phone Number:</strong> <span class="user-detail"></span></li>
                    <li class="list-group-item" id="first_name"><strong>First Name:</strong> <span class="user-detail"></span></li>
                    <li class="list-group-item" id="last_name"><strong>Last Name:</strong> <span class="user-detail"></span></li>
                    <li class="list-group-item" id="status"><strong>Status:</strong> <span class="user-detail"></span></li>
                    <li class="list-group-item" id="phone_verified"><strong>Phone Verified:</strong> <span class="user-detail"></span></li>
                    <li class="list-group-item" id="created_at"><strong>Date Added:</strong> <span class="user-detail"></span></li>
                </ul>
            </div>
        </div>
    </div>
</div>
