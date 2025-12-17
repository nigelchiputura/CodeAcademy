<div class="table-container">
        <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Question</th>
                <th>Answer</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($faqs as $faq): ?>
                <tr>
                    <td><?= htmlspecialchars($faq['question']) ?></td>
                    <td><?= htmlspecialchars($faq['answer']) ?></td>
                    <td><?= htmlspecialchars($faq['created_at']) ?></td>

                    <td class="actions text-center btn-group btn-group-sm" data-info='<?= base64_encode(json_encode($faq)) ?>'>

                    <?php if (!in_array('auditor', $_SESSION['roles'])): ?>

                        <!-- EDIT -->
                        <button type="button"
                                class="btn btn-sm btn-primary edit-detail-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal"
                                id="update"
                                >
                            <i class="fas fa-edit"></i> Edit
                        </button>

                        <!-- DELETE -->
                        <button type="button"
                                class="btn btn-sm btn-danger delete-detail-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal"
                                id="delete"
                                >
                            <i class="fas fa-trash"></i> Delete
                        </button>

                    <?php endif; ?>
                        
                        <!-- VIEW -->
                        <button type="button"
                                class="btn btn-sm btn-info text-white view-detail-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#viewModal"
                                id="read"
                                >
                            <i class="fas fa-eye"></i> View
                        </button>

                    </td>

                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
</div>
