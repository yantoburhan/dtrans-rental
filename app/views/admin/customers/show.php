<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Customer Details</h1>
            <p class="text-muted mb-0"><?= htmlspecialchars($customer['full_name']) ?></p>
        </div>
        <a href="<?= Env::get('APP_URL') ?>/admin/customers" class="btn btn-light">Back to Customers</a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="row g-4">
                <div class="col-lg-6">
                    <h5 class="mb-3">Profile</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Name:</strong> <?= htmlspecialchars($customer['full_name']) ?></li>
                        <li class="list-group-item"><strong>Username:</strong> <?= htmlspecialchars($customer['username'] ?? '-') ?></li>
                        <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($customer['email']) ?></li>
                        <li class="list-group-item"><strong>Phone:</strong> <?= htmlspecialchars($customer['phone'] ?? '-') ?></li>
                        <li class="list-group-item"><strong>Role:</strong> <?= htmlspecialchars($customer['role']) ?></li>
                        <li class="list-group-item"><strong>Joined:</strong> <?= date('d/m/Y H:i', strtotime($customer['created_at'])) ?></li>
                    </ul>
                </div>

                <div class="col-lg-6">
                    <h5 class="mb-3">Additional Information</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Address:</strong> <?= htmlspecialchars($customer['address'] ?? '-') ?></li>
                        <li class="list-group-item"><strong>Verified:</strong> <?= !empty($customer['email_verified_at']) ? 'Yes' : 'No' ?></li>
                        <li class="list-group-item"><strong>Identity Type:</strong> <?= htmlspecialchars($customer['identity_type'] ?? '-') ?></li>
                        <li class="list-group-item"><strong>Identity File:</strong> <?= htmlspecialchars($customer['identity_file'] ?? '-') ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
