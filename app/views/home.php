<div class="container">
    <div class="py-5 text-center">
        <h1 class="display-5">Welcome to Dtrans Rental</h1>
        <p class="lead text-muted">Book cars, drivers, and tourism packages across North Sumatra with ease.</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <section class="mb-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h4">Featured Cars</h2>
                    <a href="<?= Env::get('APP_URL') ?>/cars" class="btn btn-sm btn-outline-primary">View all cars</a>
                </div>

                <?php if (empty($featuredCars)): ?>
                    <div class="alert alert-secondary">No featured cars available right now.</div>
                <?php else: ?>
                    <div class="row row-cols-1 row-cols-md-2 g-3">
                        <?php foreach ($featuredCars as $car): ?>
                            <div class="col">
                                <div class="card h-100 shadow-sm">
                                    <?php if (!empty($car['primary_photo'])): ?>
                                        <img src="<?= htmlspecialchars($car['primary_photo']) ?>" class="card-img-top" alt="<?= htmlspecialchars($car['brand'] . ' ' . $car['model']) ?>">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($car['brand'] . ' ' . $car['model']) ?></h5>
                                        <p class="card-text text-muted mb-2"><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $car['category'] ?? 'Car'))) ?></p>
                                        <p class="card-text mb-1"><strong>Price:</strong> IDR <?= number_format($car['daily_price'] ?? 0, 0, ',', '.') ?></p>
                                        <a href="<?= Env::get('APP_URL') ?>/cars/<?= htmlspecialchars($car['id']) ?>" class="stretched-link"></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>

            <section class="mb-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h4">Tourism Destinations</h2>
                    <a href="<?= Env::get('APP_URL') ?>/tourism" class="btn btn-sm btn-outline-primary">Browse all</a>
                </div>

                <?php if (empty($destinations)): ?>
                    <div class="alert alert-secondary">No tourism destinations available.</div>
                <?php else: ?>
                    <div class="row row-cols-1 row-cols-md-2 g-3">
                        <?php foreach ($destinations as $destination): ?>
                            <div class="col">
                                <div class="card h-100 shadow-sm">
                                    <?php if (!empty($destination['image'])): ?>
                                        <img src="<?= htmlspecialchars($destination['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($destination['name']) ?>">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($destination['name']) ?></h5>
                                        <p class="card-text text-truncate"><?= htmlspecialchars($destination['description'] ?? '') ?></p>
                                        <a href="<?= Env::get('APP_URL') ?>/tourism/<?= htmlspecialchars($destination['id']) ?>" class="stretched-link"></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h3 class="card-title h5">Top Drivers</h3>
                    <?php if (empty($bestDrivers)): ?>
                        <p class="text-muted mb-0">No drivers available at the moment.</p>
                    <?php else: ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($bestDrivers as $driver): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong><?= htmlspecialchars($driver['full_name']) ?></strong>
                                        <div class="small text-muted"><?= htmlspecialchars($driver['experience'] ?? 'Experienced driver') ?></div>
                                    </div>
                                    <span class="badge bg-primary rounded-pill"><?= htmlspecialchars($driver['rating'] ?? 'N/A') ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title h5">Book your ride</h3>
                    <p class="text-muted">Reserve a car and driver for your next trip with confidence.</p>
                    <a href="<?= Env::get('APP_URL') ?>/cars" class="btn btn-primary w-100">Browse Cars</a>
                </div>
            </div>
        </div>
    </div>
</div>
