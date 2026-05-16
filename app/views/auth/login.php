<?php $pageTitle = 'Login'; ?>

<div class="login-card">

    <div class="logo-icon">
        <i class="bi bi-car-front-fill"></i>
    </div>

    <h2 class="login-title">Welcome</h2>
    <p class="login-subtitle">Login to continue your journey with Dtrans Rental</p>

    <?php $alert = Session::getFlash('alert'); ?>
    <?php if ($alert): ?>
        <div class="alert alert-<?= htmlspecialchars($alert['type']) ?> alert-dismissible fade show mb-3" role="alert">
            <?= htmlspecialchars($alert['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <form action="<?= Env::get('APP_URL') ?>/auth/login" method="POST">
        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf ?? '') ?>">

        <div class="mb-3">
            <label class="form-label fw-semibold">Email address</label>
            <input type="email" name="email" class="form-control" required autofocus placeholder="Enter your email">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Password</label>
            <input type="password" name="password" class="form-control" required placeholder="Enter your password">
        </div>

        <div class="d-flex justify-content-end mb-4">
            <a href="<?= Env::get('APP_URL') ?>/auth/forgot-password" class="small text-decoration-none">
                Forgot password?
            </a>
        </div>

        <button type="submit" class="btn btn-login">
            Login
        </button>

        <p class="text-center text-muted mt-4 mb-0">
            Don’t have an account?
            <a href="<?= Env::get('APP_URL') ?>/auth/register" class="text-primary fw-semibold text-decoration-none">
                Register
            </a>
        </p>
    </form>
</div>

<style>
    :root {
        --primary: #0D6EFD;
        --primary-dark: #0B5ED7;
    }

    .login-card {
        width: 100%;
        max-width: 430px;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(12px);
        border-radius: 24px;
        padding: 30px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        animation: fadeUp 0.8s ease;
    }

    .login-title {
        text-align: center;
        margin-bottom: 10px;
        font-weight: 700;
        color: #1E293B;
    }

    .login-subtitle {
        text-align: center;
        color: #64748B;
        margin-bottom: 25px;
        font-size: 14px;
    }

    .form-control {
        border-radius: 12px;
        padding: 12px 15px;
        border: 1px solid #D1D5DB;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(13,110,253,.15);
    }

    .btn-login {
        background: var(--primary);
        border: none;
        color: white;
        border-radius: 12px;
        padding: 12px;
        font-weight: 600;
        width: 100%;
        transition: 0.3s;
    }

    .btn-login:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
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

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(35px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>