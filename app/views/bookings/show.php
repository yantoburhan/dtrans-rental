<?php $pageTitle = 'Booking Detail'; ?>

<?php if (empty($booking)): ?>
    <div class="container py-5">
        <div class="alert alert-danger">
            Booking data not found.
        </div>

        <a href="<?= Env::get('APP_URL') ?>/customer/bookings" class="btn btn-primary">
            Back to My Bookings
        </a>
    </div>
    <?php return; ?>
<?php endif; ?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Booking Detail</h1>
            <p class="text-muted mb-0">
                Booking #<?= htmlspecialchars($booking['booking_code'] ?? '-') ?>
            </p>
        </div>

        <a href="<?= Env::get('APP_URL') ?>/customer/bookings"
           class="btn btn-light">
            Back to My Bookings
        </a>
    </div>

    <div class="row g-4">

        <!-- Booking Detail -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">

                    <h5 class="card-title mb-4">
                        Rental Information
                    </h5>

                    <dl class="row">

                        <dt class="col-sm-4">Car</dt>
                        <dd class="col-sm-8">
                            <?= htmlspecialchars(
                                ($booking['brand'] ?? '-') . ' ' .
                                ($booking['model'] ?? '-')
                            ) ?>
                            (
                            <?= htmlspecialchars($booking['category'] ?? '-') ?>
                            )
                        </dd>

                        <dt class="col-sm-4">Plate Number</dt>
                        <dd class="col-sm-8">
                            <?= htmlspecialchars($booking['plate_number'] ?? '-') ?>
                        </dd>

                        <dt class="col-sm-4">Pickup Date</dt>
                        <dd class="col-sm-8">
                            <?= htmlspecialchars($booking['pickup_date'] ?? '-') ?>
                        </dd>

                        <dt class="col-sm-4">Return Date</dt>
                        <dd class="col-sm-8">
                            <?= htmlspecialchars($booking['return_date'] ?? '-') ?>
                        </dd>

                        <dt class="col-sm-4">Total Days</dt>
                        <dd class="col-sm-8">
                            <?= htmlspecialchars($booking['total_days'] ?? 0) ?> days
                        </dd>

                        <dt class="col-sm-4">Driver</dt>
                        <dd class="col-sm-8">
                            <?= htmlspecialchars($booking['driver_name'] ?? 'Self Drive') ?>
                        </dd>

                        <dt class="col-sm-4">Driver Phone</dt>
                        <dd class="col-sm-8">
                            <?= htmlspecialchars($booking['driver_phone'] ?? '-') ?>
                        </dd>

                        <dt class="col-sm-4">Payment Method</dt>
                        <dd class="col-sm-8">
                            <?= htmlspecialchars(
                                ucfirst(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $booking['payment_method'] ?? '-'
                                    )
                                )
                            ) ?>
                        </dd>

                        <dt class="col-sm-4">Payment Status</dt>
                        <dd class="col-sm-8">
                            <?= htmlspecialchars($booking['payment_status'] ?? 'Pending') ?>
                        </dd>

                        <dt class="col-sm-4">Total Price</dt>
                        <dd class="col-sm-8 text-success">
                            Rp
                            <?= number_format($booking['total_price'] ?? 0, 0, ',', '.') ?>
                        </dd>

                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">

                            <?php
                            $status = $booking['status'] ?? 'pending';

                            $badgeClass = match ($status) {
                                'completed' => 'success',
                                'approved'  => 'primary',
                                'ongoing'   => 'info',
                                'cancelled' => 'secondary',
                                default     => 'warning',
                            };
                            ?>

                            <span class="badge bg-<?= $badgeClass ?>">
                                <?= htmlspecialchars(ucfirst($status)) ?>
                            </span>
                        </dd>

                    </dl>

                    <?php if (!empty($booking['notes'])): ?>
                        <div class="mt-4">
                            <h6>Notes</h6>

                            <p class="mb-0">
                                <?= nl2br(htmlspecialchars($booking['notes'])) ?>
                            </p>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">

                    <h5 class="card-title">
                        Customer Info
                    </h5>

                    <p class="mb-1">
                        <strong>Name:</strong>
                        <?= htmlspecialchars($booking['customer_name'] ?? '-') ?>
                    </p>

                    <p class="mb-1">
                        <strong>Email:</strong>
                        <?= htmlspecialchars($booking['customer_email'] ?? '-') ?>
                    </p>

                    <p class="mb-0">
                        <strong>Phone:</strong>
                        <?= htmlspecialchars($booking['customer_phone'] ?? '-') ?>
                    </p>

                </div>
            </div>
        </div>

    </div>
</div>