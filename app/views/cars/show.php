<div class="container">
    <div class="row gy-4">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <?php if (!empty($car['photos'])): ?>
                    <div id="carGallery" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($car['photos'] as $index => $photo): ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                    <img src="<?= htmlspecialchars($photo['photo_path']) ?>" class="d-block w-100" alt="<?= htmlspecialchars($car['brand'] . ' ' . $car['model']) ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if (count($car['photos']) > 1): ?>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carGallery" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carGallery" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        <?php endif; ?>
                    </div>
                <?php elseif (!empty($car['primary_photo'])): ?>
                    <img src="<?= htmlspecialchars($car['primary_photo']) ?>" class="card-img-top" alt="<?= htmlspecialchars($car['brand'] . ' ' . $car['model']) ?>">
                <?php endif; ?>

                <div class="card-body">
                    <h1 class="h3"><?= htmlspecialchars($car['brand'] . ' ' . $car['model']) ?></h1>
                    <p class="text-muted mb-2">Category: <?= ucfirst(str_replace('_', ' ', $car['category'])) ?></p>
                    <p class="mb-3">Transmission: <?= ucfirst($car['transmission']) ?> | Seats: <?= htmlspecialchars($car['capacity']) ?> | Status: <?= ucfirst($car['status']) ?></p>
                    <h4 class="text-primary">IDR <?= number_format($car['daily_price'], 0, ',', '.') ?> / day</h4>
                    <p class="mt-4"><?= nl2br(htmlspecialchars($car['description'] ?? 'No description available.')) ?></p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">Booking</h5>
                    <p class="text-muted">Reserve this car directly through your account.</p>
                    <a href="<?= Env::get('APP_URL') ?>/customer/bookings/create?car_id=<?= $car['id'] ?>" class="btn btn-primary w-100 mb-2">Book Now</a>
                    <a href="<?= Env::get('APP_URL') ?>/cars" class="btn btn-outline-secondary w-100">Back to cars</a>
                </div>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <h5 class="card-title">Car details</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Plate: <?= htmlspecialchars($car['plate_number']) ?></li>
                        <li class="list-group-item">Year: <?= htmlspecialchars($car['year']) ?></li>
                        <li class="list-group-item">Driver price: IDR <?= number_format($car['driver_price_per_day'] ?? 0, 0, ',', '.') ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
