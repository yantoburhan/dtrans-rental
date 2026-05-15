<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Edit Car</h1>
        <a href="<?= Env::get('APP_URL') ?>/admin/cars" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Cars
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-body">
                    <form action="<?= Env::get('APP_URL') ?>/admin/cars/<?= $car['id'] ?>/update" method="POST">
                        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($this->generateCsrf()) ?>">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Brand *</label>
                                <input type="text" name="brand" class="form-control" value="<?= htmlspecialchars($car['brand']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Model *</label>
                                <input type="text" name="model" class="form-control" value="<?= htmlspecialchars($car['model']) ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Year *</label>
                                <input type="number" name="year" class="form-control" value="<?= $car['year'] ?>" min="2000" max="2025" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Plate Number *</label>
                                <input type="text" name="plate_number" class="form-control" value="<?= htmlspecialchars($car['plate_number']) ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Transmission *</label>
                                <select name="transmission" class="form-select" required>
                                    <option value="automatic" <?= $car['transmission'] === 'automatic' ? 'selected' : '' ?>>Automatic</option>
                                    <option value="manual" <?= $car['transmission'] === 'manual' ? 'selected' : '' ?>>Manual</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Capacity (seats) *</label>
                                <input type="number" name="capacity" class="form-control" value="<?= $car['capacity'] ?>" min="1" max="20" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Category *</label>
                                <select name="category" class="form-select" required>
                                    <option value="city_car" <?= $car['category'] === 'city_car' ? 'selected' : '' ?>>City Car</option>
                                    <option value="mpv" <?= $car['category'] === 'mpv' ? 'selected' : '' ?>>MPV</option>
                                    <option value="suv" <?= $car['category'] === 'suv' ? 'selected' : '' ?>>SUV</option>
                                    <option value="luxury" <?= $car['category'] === 'luxury' ? 'selected' : '' ?>>Luxury</option>
                                    <option value="pickup" <?= $car['category'] === 'pickup' ? 'selected' : '' ?>>Pickup</option>
                                    <option value="hiace" <?= $car['category'] === 'hiace' ? 'selected' : '' ?>>Hiace</option>
                                    <option value="electric" <?= $car['category'] === 'electric' ? 'selected' : '' ?>>Electric</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="available" <?= $car['status'] === 'available' ? 'selected' : '' ?>>Available</option>
                                    <option value="unavailable" <?= $car['status'] === 'unavailable' ? 'selected' : '' ?>>Unavailable</option>
                                    <option value="maintenance" <?= $car['status'] === 'maintenance' ? 'selected' : '' ?>>Maintenance</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Daily Price (IDR) *</label>
                                <input type="number" name="daily_price" class="form-control" value="<?= $car['daily_price'] ?>" min="0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Driver Price Per Day (IDR)</label>
                                <input type="number" name="driver_price_per_day" class="form-control" value="<?= $car['driver_price_per_day'] ?>" min="0">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($car['description'] ?? '') ?></textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Update Car
                            </button>
                            <a href="<?= Env::get('APP_URL') ?>/admin/cars" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
