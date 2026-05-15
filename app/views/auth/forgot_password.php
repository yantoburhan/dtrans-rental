<?php $pageTitle = 'Forgot Password'; ?>
<form action="<?= Env::get('APP_URL') ?>/auth/forgot-password" method="POST">
    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf ?? '') ?>">

    <div class="mb-3">
        <label class="form-label" for="email">Email address</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Send reset link</button>
    <p class="text-center text-muted mt-3 mb-0">Remembered your password? <a href="<?= Env::get('APP_URL') ?>/auth/login">Login</a></p>
</form>
