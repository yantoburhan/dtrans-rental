<?php $pageTitle = 'Register'; ?>
<form action="<?= Env::get('APP_URL') ?>/auth/register" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf ?? '') ?>">

    <div class="mb-3">
        <label class="form-label" for="full_name">Full name</label>
        <input type="text" name="full_name" id="full_name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label" for="username">Username</label>
        <input type="text" name="username" id="username" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label" for="email">Email address</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label" for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label" for="phone">Phone</label>
        <input type="text" name="phone" id="phone" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label" for="address">Address</label>
        <textarea name="address" id="address" class="form-control" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label" for="identity_type">Identity type</label>
        <select name="identity_type" id="identity_type" class="form-select" required>
            <option value="KTP">KTP</option>
            <option value="SIM">SIM</option>
            <option value="Passport">Passport</option>
        </select>
    </div>
    <div class="mb-4">
        <label class="form-label" for="identity_file">Identity file</label>
        <input type="file" name="identity_file" id="identity_file" class="form-control" accept="image/jpeg,image/png,application/pdf" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Register</button>
    <p class="text-center text-muted mt-3 mb-0">Already registered? <a href="<?= Env::get('APP_URL') ?>/auth/login">Login</a></p>
</form>
