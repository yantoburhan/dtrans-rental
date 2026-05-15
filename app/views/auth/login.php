<?php $pageTitle = 'Login'; ?>
<form action="<?= Env::get('APP_URL') ?>/auth/login" method="POST">
    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf ?? '') ?>">

    <div class="mb-3">
        <label class="form-label" for="email">Email address</label>
        <input type="email" name="email" id="email" class="form-control" required autofocus>
    </div>

    <div class="mb-3">
        <label class="form-label" for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="<?= Env::get('APP_URL') ?>/auth/forgot-password" class="small">Forgot password?</a>
        <button type="submit" class="btn btn-primary">Login</button>
    </div>

    <p class="text-center text-muted mb-0">Don’t have an account? <a href="<?= Env::get('APP_URL') ?>/auth/register">Register</a></p>
</form>
