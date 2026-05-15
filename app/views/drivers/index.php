<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Our Drivers</h1>
        <a href="<?= Env::get('APP_URL') ?>" class="btn btn-light">Back to Home</a>
    </div>

    <?php if (empty($drivers)): ?>
        <div class="alert alert-secondary">No drivers available at the moment.</div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
            <?php foreach ($drivers as $driver): ?>
                <div class="col">
                    <div class="card shadow-sm h-100">
                        <?php if (!empty($driver['photo'])): ?>
                            <img src="<?= htmlspecialchars($driver['photo']) ?>" class="card-img-top" alt="<?= htmlspecialchars($driver['full_name']) ?>">
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($driver['full_name']) ?></h5>
                            <p class="card-text text-muted mb-2">Experience: <?= htmlspecialchars($driver['experience'] ?? 0) ?> years</p>
                            <p class="card-text mb-2">Languages: <?= htmlspecialchars($driver['languages'] ?? 'Indonesian') ?></p>
                            <p class="mb-3"><strong>Rating:</strong> <?= number_format($driver['avg_rating'] ?? 0, 1) ?> / 5</p>
                            <div class="mt-auto">
                                <a href="<?= Env::get('APP_URL') ?>/cars" class="btn btn-primary w-100">Book a car</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
