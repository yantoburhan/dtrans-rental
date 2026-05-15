<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Booking Detail</h1>
            <p class="text-muted mb-0">Booking #<?= htmlspecialchars($booking['booking_code']) ?></p>
        </div>
        <a href="<?= Env::get('APP_URL') ?>/admin/bookings" class="btn btn-light">Back to Bookings</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Customer & Booking</h5>
                    <dl class="row">
                        <dt class="col-sm-4">Customer</dt>
                        <dd class="col-sm-8"><?= htmlspecialchars($booking['customer_name']) ?></dd>

                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8"><?= htmlspecialchars($booking['customer_email']) ?></dd>

                        <dt class="col-sm-4">Phone</dt>
                        <dd class="col-sm-8"><?= htmlspecialchars($booking['customer_phone']) ?></dd>

                        <dt class="col-sm-4">Car</dt>
                        <dd class="col-sm-8"><?= htmlspecialchars($booking['brand'] . ' ' . $booking['model']) ?></dd>

                        <dt class="col-sm-4">Driver</dt>
                        <dd class="col-sm-8"><?= htmlspecialchars($booking['driver_name'] ?? 'Self Drive') ?></dd>

                        <dt class="col-sm-4">Pickup Date</dt>
                        <dd class="col-sm-8"><?= htmlspecialchars($booking['pickup_date']) ?></dd>

                        <dt class="col-sm-4">Return Date</dt>
                        <dd class="col-sm-8"><?= htmlspecialchars($booking['return_date']) ?></dd>

                        <dt class="col-sm-4">Total Days</dt>
                        <dd class="col-sm-8"><?= htmlspecialchars($booking['total_days']) ?> days</dd>

                        <dt class="col-sm-4">Total Price</dt>
                        <dd class="col-sm-8">IDR <?= number_format($booking['total_price'], 0, ',', '.') ?></dd>

                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8"><span class="badge bg-<?= $booking['status'] === 'completed' ? 'success' : ($booking['status'] === 'approved' ? 'primary' : ($booking['status'] === 'ongoing' ? 'info' : ($booking['status'] === 'cancelled' ? 'secondary' : 'warning'))) ?>"><?= ucfirst($booking['status']) ?></span></dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Actions</h5>
                    <form method="POST" action="<?= Env::get('APP_URL') ?>/admin/bookings/<?= $booking['id'] ?>/approve">
                        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                        <button type="submit" class="btn btn-success w-100 mb-2"<?= $booking['status'] === 'approved' || $booking['status'] === 'ongoing' || $booking['status'] === 'completed' ? ' disabled' : '' ?>>Approve</button>
                    </form>
                    <form method="POST" action="<?= Env::get('APP_URL') ?>/admin/bookings/<?= $booking['id'] ?>/reject">
                        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                        <button type="submit" class="btn btn-danger w-100 mb-2"<?= $booking['status'] === 'rejected' || $booking['status'] === 'cancelled' || $booking['status'] === 'completed' ? ' disabled' : '' ?>>Reject</button>
                    </form>
                    <form method="POST" action="<?= Env::get('APP_URL') ?>/admin/bookings/<?= $booking['id'] ?>/complete">
                        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                        <button type="submit" class="btn btn-primary w-100"<?= $booking['status'] !== 'approved' && $booking['status'] !== 'ongoing' ? ' disabled' : '' ?>>Mark as Completed</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
