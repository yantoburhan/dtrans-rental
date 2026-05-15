<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Manage Drivers</h1>
        <a href="<?= Env::get('APP_URL') ?>/admin/drivers/create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add New Driver
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <?php if (empty($drivers)): ?>
                <div class="alert alert-secondary">No drivers found.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Experience</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($drivers as $driver): ?>
                                <tr>
                                    <td><?= $driver['id'] ?></td>
                                    <td><?= htmlspecialchars($driver['full_name']) ?></td>
                                    <td><?= htmlspecialchars($driver['email']) ?></td>
                                    <td><?= htmlspecialchars($driver['phone']) ?></td>
                                    <td><?= htmlspecialchars($driver['experience']) ?> years</td>
                                    <td>
                                        <span class="badge bg-<?= $driver['status'] === 'available' ? 'success' : 'secondary' ?>">
                                            <?= ucfirst($driver['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= Env::get('APP_URL') ?>/admin/drivers/<?= $driver['id'] ?>/edit" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="<?= Env::get('APP_URL') ?>/admin/drivers/<?= $driver['id'] ?>/delete" method="POST" class="d-inline">
                                            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($this->generateCsrf()) ?>">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this driver?')">
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
