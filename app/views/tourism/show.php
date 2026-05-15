<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0"><?= htmlspecialchars($destination['name']) ?></h1>
            <p class="text-muted mb-0"><?= htmlspecialchars($destination['location'] ?? '') ?></p>
        </div>
        <a href="<?= Env::get('APP_URL') ?>/tourism" class="btn btn-light">Back to Tourism</a>
    </div>

    <?php if (!empty($destination['photos'])): ?>
        <div id="destinationGallery" class="carousel slide mb-4" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php foreach ($destination['photos'] as $index => $photo): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <img src="<?= htmlspecialchars($photo['photo_path']) ?>" class="d-block w-100" alt="<?= htmlspecialchars($destination['name']) ?>">
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if (count($destination['photos']) > 1): ?>
                <button class="carousel-control-prev" type="button" data-bs-target="#destinationGallery" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#destinationGallery" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h5">About this destination</h2>
                    <p><?= nl2br(htmlspecialchars($destination['description'] ?? 'No description available.')) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Details</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Location:</strong> <?= htmlspecialchars($destination['location'] ?? 'Unknown') ?></li>
                        <li class="list-group-item"><strong>Price per person:</strong> IDR <?= number_format($destination['price_per_person'] ?? 0, 0, ',', '.') ?></li>
                        <li class="list-group-item"><strong>Recommended vehicle:</strong> <?= htmlspecialchars($destination['recommended_vehicle'] ?? '-') ?></li>
                    </ul>
                    <a href="<?= Env::get('APP_URL') ?>/cars" class="btn btn-primary w-100 mt-3">Book a car for the trip</a>
                </div>
            </div>
        </div>
    </div>
</div>
