<?php $pageTitle = 'Reset Password'; ?>
<form action="<?= Env::get('APP_URL') ?>/auth/reset-password" method="POST">
    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf ?? '') ?>">
    <input type="hidden" name="token" value="<?= htmlspecialchars($token ?? '') ?>">

    <div class="mb-3">
        <label class="form-label" for="password">New password</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label" for="password_confirmation">Confirm password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Reset password</button>
    <p class="text-center text-muted mt-3 mb-0">Back to <a href="<?= Env::get('APP_URL') ?>/auth/login">login</a></p>
</form>
