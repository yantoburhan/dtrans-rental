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
