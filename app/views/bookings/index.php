<?php $pageTitle = 'My Bookings'; ?>

<div class="container py-5">

    <h1 class="h3 mb-4">My Bookings</h1>

    <?php if (empty($bookings)): ?>
        <div class="alert alert-info">
            You don’t have any bookings yet.
        </div>
    <?php else: ?>

        <div class="row g-3">

            <?php foreach ($bookings as $booking): ?>

                <div class="col-md-6">

                    <div class="card shadow-sm">

                        <div class="card-body">

                            <h5>
                                <?= htmlspecialchars($booking['brand'] . ' ' . $booking['model']) ?>
                            </h5>

                            <p class="text-muted mb-1">
                                Code: <?= htmlspecialchars($booking['booking_code']) ?>
                            </p>

                            <p class="mb-1">
                                Status: <?= htmlspecialchars($booking['status']) ?>
                            </p>

                            <p class="mb-3">
                                Total: Rp <?= number_format($booking['total_price'], 0, ',', '.') ?>
                            </p>

                            <a href="<?= Env::get('APP_URL') ?>/customer/bookings/<?= $booking['booking_id'] ?>"
                               class="btn btn-primary w-100">
                                View Detail
                            </a>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>