<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Edit Driver</h1>
        <a href="<?= Env::get('APP_URL') ?>/admin/drivers" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Drivers
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-body">
                    <form action="<?= Env::get('APP_URL') ?>/admin/drivers/<?= $driver['id'] ?>/update" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($this->generateCsrf()) ?>">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($driver['full_name']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email *</label>
                                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($driver['email']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone *</label>
                                <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($driver['phone']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Experience (years)</label>
                                <input type="number" name="experience" class="form-control" min="0" value="<?= htmlspecialchars($driver['experience']) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Age</label>
                                <input type="number" name="age" class="form-control" min="18" value="<?= htmlspecialchars($driver['age']) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="available" <?= $driver['status'] === 'available' ? 'selected' : '' ?>>Available</option>
                                    <option value="unavailable" <?= $driver['status'] === 'unavailable' ? 'selected' : '' ?>>Unavailable</option>
                                    <option value="inactive" <?= $driver['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Languages</label>
                                <input type="text" name="languages" class="form-control" value="<?= htmlspecialchars($driver['languages']) ?>">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Photo</label>
                                <input type="file" name="photo" class="form-control">
                                <?php if (!empty($driver['photo'])): ?>
                                    <div class="mt-2">
                                        <img src="<?= htmlspecialchars($driver['photo']) ?>" alt="Driver photo" class="img-thumbnail" style="max-width: 180px;">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update Driver</button>
                            <a href="<?= Env::get('APP_URL') ?>/admin/drivers" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
