<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5>Add FAQ</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="/admin/chatbot/add.php" method="post">
                <?php csrf_field(); ?>

                <div class="modal-body">
                    <label>Question</label>
                    <textarea class="form-control" name="question" required></textarea>

                    <label class="mt-3">Answer</label>
                    <textarea class="form-control" name="answer" required></textarea>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success w-100">Add FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Update FAQ</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form action="/admin/chatbot/update.php" method="post" enctype="multipart/form-data">

                    <?php csrf_field(); ?>

                    <input type="hidden" name="id" id="id-update">

                    <div class="mb-3">
                        <label class="form-label">Question</label>
                        <input type="text" class="form-control update-field" id="question-update" name="question" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Answer</label>
                        <textarea class="form-control update-field"
                                  id="answer-update"
                                  name="answer"
                                  rows="5" required>
                        </textarea>
                    </div>

                    <button class="btn btn-primary w-100">Save Changes</button>

                </form>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Delete FAQ</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p id="confirm-delete">Are you sure you want to delete this FAQ? <strong></strong></p>

                <form action="/admin/chatbot/delete.php" method="post">
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
                <h5 class="modal-title">FAQ Details</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <ul class="list-group">
                    <li class="list-group-item" id="id"><strong>FAQ ID:</strong> <span></span></li>
                    <li class="list-group-item" id="question"><strong>Question:</strong> <span></span></li>
                    <li class="list-group-item" id="answer"><strong>Answer:</strong> <span></span></li>
                </ul>

            </div>

        </div>
    </div>
</div>