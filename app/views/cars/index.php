<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Available Cars</h1>
        <a href="<?= Env::get('APP_URL') ?>" class="btn btn-light">Back to Home</a>
    </div>

    <form class="row g-3 mb-4" method="GET" action="<?= Env::get('APP_URL') ?>/cars">
        <div class="col-md-3">
            <label class="form-label">Category</label>
            <select name="category" class="form-select">
                <option value="">All categories</option>
                <option value="city_car" <?= ($filters['category'] ?? '') === 'city_car' ? 'selected' : '' ?>>City Car</option>
                <option value="mpv" <?= ($filters['category'] ?? '') === 'mpv' ? 'selected' : '' ?>>MPV</option>
                <option value="suv" <?= ($filters['category'] ?? '') === 'suv' ? 'selected' : '' ?>>SUV</option>
                <option value="luxury" <?= ($filters['category'] ?? '') === 'luxury' ? 'selected' : '' ?>>Luxury</option>
                <option value="pickup" <?= ($filters['category'] ?? '') === 'pickup' ? 'selected' : '' ?>>Pickup</option>
                <option value="hiace" <?= ($filters['category'] ?? '') === 'hiace' ? 'selected' : '' ?>>Hiace</option>
                <option value="electric" <?= ($filters['category'] ?? '') === 'electric' ? 'selected' : '' ?>>Electric</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Transmission</label>
            <select name="transmission" class="form-select">
                <option value="">Any</option>
                <option value="automatic" <?= ($filters['transmission'] ?? '') === 'automatic' ? 'selected' : '' ?>>Automatic</option>
                <option value="manual" <?= ($filters['transmission'] ?? '') === 'manual' ? 'selected' : '' ?>>Manual</option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Seats</label>
            <input type="number" name="capacity" class="form-control" min="1" value="<?= htmlspecialchars($filters['capacity'] ?? '') ?>">
        </div>
        <div class="col-md-2">
            <label class="form-label">Pickup</label>
            <input type="date" name="pickup_date" class="form-control" value="<?= htmlspecialchars($filters['pickup_date'] ?? '') ?>">
        </div>
        <div class="col-md-2">
            <label class="form-label">Return</label>
            <input type="date" name="return_date" class="form-control" value="<?= htmlspecialchars($filters['return_date'] ?? '') ?>">
        </div>
        <div class="col-12 text-end">
            <button class="btn btn-primary" type="submit">Filter</button>
            <a href="<?= Env::get('APP_URL') ?>/cars" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    <?php if (empty($cars)): ?>
        <div class="alert alert-secondary">No cars available with the selected criteria.</div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php foreach ($cars as $car): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <?php if (!empty($car['primary_photo'])): ?>
                            <img src="<?= htmlspecialchars($car['primary_photo']) ?>" class="card-img-top" alt="<?= htmlspecialchars($car['brand'] . ' ' . $car['model']) ?>">
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($car['brand'] . ' ' . $car['model']) ?></h5>
                            <p class="card-text text-muted mb-2">Category: <?= ucfirst(str_replace('_', ' ', $car['category'])) ?></p>
                            <p class="card-text mb-2">Transmission: <?= ucfirst($car['transmission']) ?> | Seats: <?= htmlspecialchars($car['capacity']) ?></p>
                            <p class="card-text mb-3"><strong>IDR <?= number_format($car['daily_price'], 0, ',', '.') ?>/day</strong></p>
                            <div class="mt-auto">
                                <a href="<?= Env::get('APP_URL') ?>/cars/<?= $car['id'] ?>" class="btn btn-primary w-100">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
