<?php include __DIR__ . '/../../../layouts/header.php'; ?>

<div class="container mt-4">

    <?php include __DIR__ . '/../sidebar.php'; ?>

    <h1 class="display-6"><i class="fas fa-recycle"></i> Recycle Bin</h1>
    <hr>

    <?php if ($gallery): ?>

    <div class="table-container">

        <table class="table table-hover table-bordered align-middle">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Deleted At</th>

                    <?php if (!in_array('auditor', $_SESSION['roles'])): ?>

                    <th>Actions</th>

                    <?php endif; ?>
                    
                </tr>
            </thead>

            <tbody>
            <?php foreach ($gallery as $g): ?>
                <tr>
                    <td><?= htmlspecialchars($g->title); ?></td>
                    <td><?= htmlspecialchars($g->deleted_at); ?></td>

                    <td role="group" class="btn-group btn-group-sm">
                        <form action="./restore.php" method="post">
                            <?php csrf_field(); ?>
                            <button class="btn btn-sm btn-success" name="id" value="<?= $g->id ?>">
                                <i class="fas fa-undo"></i> Restore
                            </button>
                        </form>
                        <form action="./hard_delete.php" method="post" onsubmit="return confirm('Permanently delete this item?');">
                            <?php csrf_field(); ?>
                            <button class="btn btn-sm btn-danger" name="id" value="<?= $g->id ?>">
                                <i class="fas fa-skull-crossbones"></i> Delete Forever
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>

        </table>

    </div>

    <?php else: ?>

        <h3 class="text-success">Recycle Bin Is Empty</h3>

    <?php endif; ?>

</div>

<?php include __DIR__ . '/../../../layouts/footer.php'; ?>