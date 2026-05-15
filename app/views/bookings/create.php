<?php $pageTitle = 'Create Booking'; ?>
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="card-title mb-3">Book <?= htmlspecialchars($car['brand']) ?> <?= htmlspecialchars($car['model']) ?></h3>

                    <div class="mb-4">
                        <?php if (!empty($car['photos'])): ?>
                            <img src="<?= Env::get('APP_URL') ?>/uploads/cars/<?= htmlspecialchars($car['photos'][0]['photo_path']) ?>" class="img-fluid rounded mb-3" alt="<?= htmlspecialchars($car['brand']) ?> <?= htmlspecialchars($car['model']) ?>">
                        <?php elseif (!empty($car['primary_photo'])): ?>
                            <img src="<?= Env::get('APP_URL') ?>/uploads/cars/<?= htmlspecialchars($car['primary_photo']) ?>" class="img-fluid rounded mb-3" alt="<?= htmlspecialchars($car['brand']) ?> <?= htmlspecialchars($car['model']) ?>">
                        <?php endif; ?>
                        <p class="mb-1"><strong>Category:</strong> <?= htmlspecialchars($car['category']) ?></p>
                        <p class="mb-1"><strong>Transmission:</strong> <?= htmlspecialchars($car['transmission']) ?></p>
                        <p class="mb-1"><strong>Capacity:</strong> <?= htmlspecialchars($car['capacity']) ?> seats</p>
                        <p class="mb-0"><strong>Daily price:</strong> Rp <?= number_format($car['daily_price'], 0, ',', '.') ?></p>
                    </div>

                    <form action="<?= Env::get('APP_URL') ?>/customer/bookings/store" method="POST">
                        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf ?? '') ?>">
                        <input type="hidden" name="car_id" value="<?= (int) $car['id'] ?>">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pickup_date" class="form-label">Pickup Date</label>
                                <input type="date" name="pickup_date" id="pickup_date" class="form-control" value="<?= htmlspecialchars($pickupDate) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="return_date" class="form-label">Return Date</label>
                                <input type="date" name="return_date" id="return_date" class="form-control" value="<?= htmlspecialchars($returnDate) ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="driver_id" class="form-label">Driver (optional)</label>
                            <select name="driver_id" id="driver_id" class="form-select">
                                <option value="">No driver</option>
                                <?php foreach ($availableDrivers as $driver): ?>
                                    <option value="<?= (int) $driver['id'] ?>">
                                        <?= htmlspecialchars($driver['full_name']) ?> - <?= htmlspecialchars($driver['phone']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (empty($availableDrivers)): ?>
                                <div class="form-text">No drivers are available for the selected dates.</div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select name="payment_method" id="payment_method" class="form-select" required>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="e_wallet">E-Wallet</option>
                                <option value="cod">Cash on Delivery</option>
                                <option value="midtrans">Midtrans</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea name="notes" id="notes" class="form-control" rows="4" placeholder="Any special requests?"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Confirm Booking</button>
                        <a href="<?= Env::get('APP_URL') ?>/cars" class="btn btn-secondary ms-2">Back to Cars</a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Booking summary</h5>
                    <p><strong>Car:</strong> <?= htmlspecialchars($car['brand']) ?> <?= htmlspecialchars($car['model']) ?></p>
                    <p><strong>Pickup:</strong> <?= htmlspecialchars($pickupDate) ?></p>
                    <p><strong>Return:</strong> <?= htmlspecialchars($returnDate) ?></p>
                    <p><strong>Daily price:</strong> Rp <?= number_format($car['daily_price'], 0, ',', '.') ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
