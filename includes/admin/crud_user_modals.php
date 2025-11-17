<!-- ADD USER MODAL -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../../controllers/users/create_user.php" method="post">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" placeholder="Enter username" name="username-create" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select" name="role-create">
                            <option>Admin</option>
                            <option>Teacher</option>
                            <option>Parent</option>
                            <option selected>Student</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" placeholder="Enter phone number" name="phone-create" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" placeholder="Enter full name" name="full_name-create" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" placeholder="Enter email" name="email-create" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" name="user-create" value="create">Save User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- EDIT USER MODAL -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../../controllers/users/update_user.php" method="post">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control update-field" value="" id="username-update" name="username-update" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select update-field" id="role-update" name="role-update">
                            <option id="admin">Admin</option>
                            <option id="teacher">Teacher</option>
                            <option id="parent">Parent</option>
                            <option id="student">Student</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control update-field" value="" id="full_name-update" name="full_name-update" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control update-field" value="" id="email-update" name="email-update" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control update-field" value="" id="phone-update" name="phone-update" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" name="user-update" value="" id="user-update-btn">Update User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- DELETE USER MODAL -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel"
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
                <form action="../../controllers/users/delete_user.php" method="post">
                    <div class="d-flex justify-content-end gap-2">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-danger" id="user-delete-btn" type="submit" name="user-delete" value="">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- VIEW USER MODAL -->
<div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="viewUserModalLabel">User Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <li class="list-group-item" id="user_id"><strong>Id:</strong> <span class="user-detail"></span></li>
                    <li class="list-group-item" id="username"><strong>Username:</strong> <span class="user-detail"></span></li>
                    <li class="list-group-item" id="role"><strong>Role:</strong> <span class="user-detail"></span></li>
                    <li class="list-group-item" id="email"><strong>Email:</strong> <span class="user-detail"></span></li>
                    <li class="list-group-item" id="phone"><strong>Phone Number:</strong> <span class="user-detail"></span></li>
                    <li class="list-group-item" id="full_name"><strong>Full Name:</strong> <span class="user-detail"></span></li>
                    <li class="list-group-item" id="created_at"><strong>Date Added:</strong> <span class="user-detail"></span></li>
                </ul>
            </div>
        </div>
    </div>
</div>