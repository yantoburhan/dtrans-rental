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

        <?php
        $canReview =
            $booking['status'] === 'completed' &&
            !empty($booking['driver_id']);
        ?>

        <?php if ($canReview): ?>

        <div class="row mt-4">
            <div class="col-lg-12">

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">

                        <h5 class="mb-4 fw-bold">
                            <i class="bi bi-star-fill text-warning me-2"></i>
                            Driver Review
                        </h5>

                        <?php if (!empty($review)): ?>

                            <!-- SHOW REVIEW -->

                            <div class="border rounded-4 p-4 bg-light">

                                <div class="d-flex align-items-center mb-3">

                                    <div class="me-3">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                            style="width:60px;height:60px;font-size:1.2rem;font-weight:700;">
                                            <?= strtoupper(substr($booking['driver_name'], 0, 1)) ?>
                                        </div>
                                    </div>

                                    <div>
                                        <h6 class="mb-1 fw-bold">
                                            <?= htmlspecialchars($booking['driver_name']) ?>
                                        </h6>

                                        <div class="text-warning fs-5">
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <?php if($i <= $review['rating']): ?>
                                                    <i class="bi bi-star-fill"></i>
                                                <?php else: ?>
                                                    <i class="bi bi-star"></i>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </div>
                                    </div>

                                </div>

                                <?php if (!empty($review['comment'])): ?>
                                    <p class="mb-2 text-muted">
                                        <?= nl2br(htmlspecialchars($review['comment'])) ?>
                                    </p>
                                <?php endif; ?>

                                <small class="text-muted">
                                    Reviewed on
                                    <?= date('d M Y H:i', strtotime($review['created_at'])) ?>
                                </small>

                            </div>

                        <?php else: ?>

                            <!-- REVIEW FORM -->

                            <form method="POST"
                                action="<?= Env::get('APP_URL') ?>/customer/bookings/<?= $booking['id'] ?>/review">

                                <input type="hidden"
                                    name="_csrf_token"
                                    value="<?= $csrf ?>">

                                <div class="mb-4">

                                    <label class="form-label fw-semibold">
                                        How was your experience with
                                        <?= htmlspecialchars($booking['driver_name']) ?>?
                                    </label>

                                    <div class="rating-stars d-flex gap-2 fs-2">

                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <i class="bi bi-star star-item"
                                            data-value="<?= $i ?>"></i>
                                        <?php endfor; ?>

                                    </div>

                                    <input type="hidden"
                                        name="rating"
                                        id="ratingInput"
                                        required>

                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        Comment
                                    </label>

                                    <textarea
                                        name="comment"
                                        rows="4"
                                        class="form-control"
                                        placeholder="Share your experience with this driver..."></textarea>
                                </div>

                                <button type="submit"
                                        class="btn btn-primary px-4 rounded-pill">
                                    Submit Review
                                </button>

                            </form>

                        <?php endif; ?>

                    </div>
                </div>

            </div>
        </div>

        <?php endif; ?>

    </div>
</div>

<style>
.rating-stars .star-item{
    cursor:pointer;
    color:#D1D5DB;
    transition:0.2s;
}

.rating-stars .star-item.active{
    color:#F59E0B;
}

.rating-stars .star-item:hover{
    transform:scale(1.1);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function(){

    const stars = document.querySelectorAll('.star-item');
    const ratingInput = document.getElementById('ratingInput');

    stars.forEach((star, index) => {

        star.addEventListener('click', function(){

            const rating = index + 1;

            ratingInput.value = rating;

            stars.forEach((s, i) => {

                if(i < rating){
                    s.classList.remove('bi-star');
                    s.classList.add('bi-star-fill', 'active');
                }else{
                    s.classList.remove('bi-star-fill', 'active');
                    s.classList.add('bi-star');
                }

            });

        });

    });

});
</script>