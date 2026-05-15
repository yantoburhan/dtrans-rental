<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Bookings</h1>
            <p class="text-muted mb-0">Manage all bookings and update their status.</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Booking Code</th>
                            <th>Customer</th>
                            <th>Car</th>
                            <th>Driver</th>
                            <th>Pickup</th>
                            <th>Return</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($bookings)): ?>
                            <tr>
                                <td colspan="10" class="text-center text-muted">No bookings found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($bookings as $booking): ?>
                                <tr>
                                    <td><?= htmlspecialchars($booking['id']) ?></td>
                                    <td><?= htmlspecialchars($booking['booking_code']) ?></td>
                                    <td><?= htmlspecialchars($booking['customer_name']) ?></td>
                                    <td><?= htmlspecialchars($booking['brand'] . ' ' . $booking['model']) ?></td>
                                    <td><?= htmlspecialchars($booking['driver_name'] ?? 'Self Drive') ?></td>
                                    <td><?= htmlspecialchars($booking['pickup_date']) ?></td>
                                    <td><?= htmlspecialchars($booking['return_date']) ?></td>
                                    <td>IDR <?= number_format($booking['total_price'], 0, ',', '.') ?></td>
                                    <td><span class="badge bg-<?= $booking['status'] === 'completed' ? 'success' : ($booking['status'] === 'approved' ? 'primary' : ($booking['status'] === 'ongoing' ? 'info' : ($booking['status'] === 'cancelled' ? 'secondary' : 'warning'))) ?>"><?= ucfirst($booking['status']) ?></span></td>
                                    <td>
                                        <a href="<?= Env::get('APP_URL') ?>/admin/bookings/<?= $booking['id'] ?>" class="btn btn-sm btn-outline-primary">View</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
