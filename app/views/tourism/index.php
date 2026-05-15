<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Tourism Destinations</h1>
        <a href="<?= Env::get('APP_URL') ?>" class="btn btn-light">Back to Home</a>
    </div>

    <?php if (empty($destinations)): ?>
        <div class="alert alert-secondary">No tourism destinations available right now.</div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
            <?php foreach ($destinations as $destination): ?>
                <div class="col">
                    <div class="card shadow-sm h-100">
                        <?php if (!empty($destination['primary_photo'])): ?>
                            <img src="<?= htmlspecialchars($destination['primary_photo']) ?>" class="card-img-top" alt="<?= htmlspecialchars($destination['name']) ?>">
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($destination['name']) ?></h5>
                            <p class="card-text text-muted mb-3"><?= htmlspecialchars($destination['location'] ?? '') ?></p>
                            <p class="card-text mb-3 text-truncate"><?= htmlspecialchars($destination['description'] ?? '') ?></p>
                            <div class="mt-auto">
                                <a href="<?= Env::get('APP_URL') ?>/tourism/<?= $destination['id'] ?>" class="btn btn-primary w-100">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
