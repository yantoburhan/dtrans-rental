<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="mb-0">Welcome back, <?= htmlspecialchars(Session::get('user')['name']) ?>!</h4>
                </div>
                <div class="card-body">
                    <p>Manage your bookings, profile, and more from your dashboard.</p>
                    <a href="<?= Env::get('APP_URL') ?>/customer/bookings" class="btn btn-primary">View My Bookings</a>
                    <a href="<?= Env::get('APP_URL') ?>/customer/profile" class="btn btn-outline-secondary ms-2">Edit Profile</a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">No recent activity.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <i class="bi bi-car-front-fill fs-1 text-primary mb-3"></i>
                    <h6>Book a Car</h6>
                    <p class="small text-muted">Rent cars with or without driver</p>
                    <a href="<?= Env::get('APP_URL') ?>/cars" class="btn btn-sm btn-primary">Browse Cars</a>
                </div>
            </div>

            <div class="card">
                <div class="card-body text-center">
                    <i class="bi bi-chat-dots fs-1 text-success mb-3"></i>
                    <h6>Live Chat</h6>
                    <p class="small text-muted">Get help from our support</p>
                    <a href="<?= Env::get('APP_URL') ?>/customer/chat" class="btn btn-sm btn-success">Start Chat</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $alert = Session::getFlash('alert'); ?>
<?php if ($alert): ?>
    <div class="floating-alert alert alert-<?= htmlspecialchars($alert['type']) ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($alert['message']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<style>
.floating-alert {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 9999;
    min-width: 320px;
    max-width: 420px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    border-radius: 12px;
    animation: slideDownFade 0.5s ease;
}

@keyframes slideDownFade {
    from {
        opacity: 0;
        transform: translateX(-50%) translateY(-40px);
    }
    to {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const alertBox = document.querySelector('.floating-alert');
    if (alertBox) {
        setTimeout(() => {
            alertBox.style.transition = 'all 0.5s ease';
            alertBox.style.opacity = '0';
            alertBox.style.transform = 'translateX(-50%) translateY(-40px)';

            setTimeout(() => {
                alertBox.remove();
            }, 500);
        }, 3000);
    }
});
</script>
