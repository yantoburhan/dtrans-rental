<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Tourism Packages</h1>
        <a href="<?= Env::get('APP_URL') ?>/admin/tourism/create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Destination
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <?php if (empty($destinations)): ?>
                <div class="alert alert-secondary">No tourism destinations found.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Price</th>
                                <th>Recommended Vehicle</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($destinations as $destination): ?>
                                <tr>
                                    <td><?= $destination['id'] ?></td>
                                    <td><?= htmlspecialchars($destination['name']) ?></td>
                                    <td><?= htmlspecialchars($destination['location']) ?></td>
                                    <td>IDR <?= number_format($destination['ticket_price'], 0, ',', '.') ?></td>
                                    <td><?= htmlspecialchars($destination['recommended_vehicle'] ?? '-') ?></td>
                                    <td>
                                        <a href="<?= Env::get('APP_URL') ?>/admin/tourism/<?= $destination['id'] ?>/edit" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="<?= Env::get('APP_URL') ?>/admin/tourism/<?= $destination['id'] ?>/delete" method="POST" class="d-inline">
                                            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($this->generateCsrf()) ?>">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this destination?')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
