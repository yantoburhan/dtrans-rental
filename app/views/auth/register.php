<?php $pageTitle = 'Register'; ?>

<style>
    .register-card {
        width: 100%;
        max-width: 760px; /* diperlebar */
        background: rgba(255,255,255,0.96);
        border-radius: 24px;
        padding: 32px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        animation: fadeUp 0.8s ease;
    }

    .logo-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #0D6EFD, #3BA8FF);
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto 20px;
        box-shadow: 0 10px 20px rgba(13,110,253,.3);
    }

    .logo-icon i {
        color: white;
        font-size: 30px;
    }

    .register-title {
        text-align: center;
        font-weight: 700;
        color: #1E293B;
        margin-bottom: 6px;
    }

    .register-subtitle {
        text-align: center;
        color: #64748B;
        font-size: 14px;
        margin-bottom: 24px;
    }

    .form-control,
    .form-select {
        border-radius: 12px;
        padding: 10px 14px;
    }

    .btn-register {
        width: 100%;
        background: #0D6EFD;
        color: white;
        border: none;
        border-radius: 12px;
        padding: 12px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-register:hover {
        background: #0B5ED7;
        transform: translateY(-2px);
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="register-card">

    <div class="logo-icon">
        <i class="bi bi-car-front-fill"></i>
    </div>

    <h2 class="register-title">Create Account</h2>
    <p class="register-subtitle">Register to start your journey with Dtrans Rental</p>

    <form action="<?= Env::get('APP_URL') ?>/auth/register" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf ?? '') ?>">

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Full name</label>
                <input type="text" name="full_name" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Identity type</label>
                <select name="identity_type" class="form-select" required>
                    <option value="KTP">KTP</option>
                    <option value="SIM">SIM</option>
                    <option value="Passport">Passport</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Identity file</label>
                <input type="file" name="identity_file" class="form-control" accept="image/jpeg,image/png,application/pdf" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="2"></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-register mt-2">Register</button>

        <p class="text-center text-muted mt-3 mb-0">
            Already registered?
            <a href="<?= Env::get('APP_URL') ?>/auth/login" class="text-primary fw-semibold text-decoration-none">
                Login
            </a>
        </p>
    </form>
</div>