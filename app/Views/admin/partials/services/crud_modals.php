<div class="modal fade" id="addServiceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Add New Service</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form action="/admin/services/add.php" method="post" enctype="multipart/form-data">

                    <?php csrf_field(); ?>

                    <div class="mb-3">
                        <label class="form-label">Service Title</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Short Description</label>
                        <textarea class="form-control" name="short_description" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Full Description</label>
                        <textarea class="form-control" name="description" rows="5" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Service Image</label>
                        <input type="file" class="form-control" name="image">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="is_active">
                            <option value="1">Active</option>
                            <option value="0">Disabled</option>
                        </select>
                    </div>

                    <button class="btn btn-success w-100">Add Service</button>

                </form>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Edit Service</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form action="/admin/services/update.php" method="post" enctype="multipart/form-data">

                    <?php csrf_field(); ?>

                    <input type="hidden" name="id" id="id-update">

                    <div class="mb-3">
                        <label class="form-label">Service Title</label>
                        <input type="text" class="form-control update-field" id="title-update" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Short Description</label>
                        <textarea class="form-control update-field"
                                  id="short_description-update"
                                  name="short_description" 
                                  required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Full Description</label>
                        <textarea class="form-control update-field"
                                  id="description-update"
                                  name="description"
                                  rows="5" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Change Image (optional)</label>
                        <p class="update-field text-secondary" id="image-update"><em>Current Image:</em> <a href=""></a></p>
                        <input type="file" class="form-control" value="Hello" name="image">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select update-field" id="status-update" name="is_active">
                                <option value="1">Active</option>
                                <option value="0">Disabled</option>
                        </select>
                    </div>

                    <button class="btn btn-primary w-100">Update Service</button>

                </form>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Delete Service</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p id="confirm-delete">Are you sure you want to delete <strong></strong>?</p>

                <form action="/admin/services/delete.php" method="post">
                    <?php csrf_field(); ?>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" name="id" value="" id="delete-detail-btn">Delete</button>
                </form>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Service Details</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <ul class="list-group">
                    <li class="list-group-item" id="id"><strong>Service ID:</strong> <span></span></li>
                    <li class="list-group-item" id="title"><strong>Title:</strong> <span></span></li>
                    <li class="list-group-item" id="slug"><strong>Slug:</strong> <span></span></li>
                    <li class="list-group-item" id="short_description"><strong>Overview: </strong>
                        <span></span>
                    </li>
                    <li class="list-group-item" id="description"><strong>Description: </strong>
                        <span></span>
                    </li>
                    <li class="list-group-item" id="image">
                        <strong>Image:</strong>
                        <span class="mt-2 d-block w-75" style="margin: auto;">
                            <img class="img-fluid rounded border">
                        </span>
                    </li>
                </ul>

            </div>

        </div>
    </div>
</div>