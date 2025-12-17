<div class="table-container">
    <table class="table table-hover table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th>Title</th>
                <th>Image</th>
                <th>Status</th>
                <th>Related Service</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($gallery as $g): ?>
                <tr data-service-id="<?= $g['id']; ?>">

                    <td><?= htmlspecialchars($g['title']); ?></td>
                    <td>
                        <img src="/uploads/<?= htmlspecialchars($g['image']); ?>"
                                 width="60"
                                 class="rounded border">
                    </td>
                    <td>
                        <span class="badge bg-<?= $g['is_active'] ? 'success' : 'secondary'; ?>">
                            <?= $g['is_active'] ? 'Active' : 'Disabled'; ?>
                        </span>
                    </td>

                    <td>
                        <?php if ($g['service_id']): ?>
                            <?= htmlspecialchars($g['service_id']); ?>
                        <?php else: ?>
                            <span class="text-muted">Not Related To A Service</span>
                        <?php endif; ?>
                    </td>

                    <td class="actions text-center btn-group btn-group-sm" data-info='<?= base64_encode(json_encode($g)) ?>'>

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
