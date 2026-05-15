<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Manage Cars</h1>
        <a href="<?= Env::get('APP_URL') ?>/admin/cars/create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add New Car
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <?php if (!empty($cars)): ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Brand</th>
                                <th>Model</th>
                                <th>Year</th>
                                <th>Plate Number</th>
                                <th>Status</th>
                                <th>Daily Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cars as $car): ?>
                                <tr>
                                    <td><?= $car['id'] ?></td>
                                    <td><?= htmlspecialchars($car['brand']) ?></td>
                                    <td><?= htmlspecialchars($car['model']) ?></td>
                                    <td><?= $car['year'] ?></td>
                                    <td><?= htmlspecialchars($car['plate_number']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $car['status'] === 'available' ? 'success' : 'warning' ?>">
                                            <?= ucfirst($car['status']) ?>
                                        </span>
                                    </td>
                                    <td>IDR <?= number_format($car['daily_price'], 0, ',', '.') ?></td>
                                    <td>
                                        <a href="<?= Env::get('APP_URL') ?>/admin/cars/<?= $car['id'] ?>/edit" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="<?= Env::get('APP_URL') ?>/admin/cars/<?= $car['id'] ?>/delete" method="POST" class="d-inline">
                                            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($this->generateCsrf()) ?>">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this car?')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-car-front fs-1 text-muted mb-3"></i>
                    <h5 class="text-muted">No cars found</h5>
                    <a href="<?= Env::get('APP_URL') ?>/admin/cars/create" class="btn btn-primary">Add First Car</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
