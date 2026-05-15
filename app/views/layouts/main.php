<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Dtrans Rental') ?> — Dtrans Rental</title>

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= Env::get('APP_URL') ?>/assets/css/app.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= Env::get('APP_URL') ?>">
            <i class="bi bi-car-front-fill me-2"></i>Dtrans Rental
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="<?= Env::get('APP_URL') ?>/cars">Cars</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= Env::get('APP_URL') ?>/drivers">Drivers</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= Env::get('APP_URL') ?>/tourism">Tourism</a></li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php if (Session::has('user')): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i><?= htmlspecialchars(Session::get('user')['name']) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= Env::get('APP_URL') ?>/customer/dashboard">Dashboard</a></li>
                            <li><a class="dropdown-item" href="<?= Env::get('APP_URL') ?>/customer/bookings">My Bookings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?= Env::get('APP_URL') ?>/auth/logout">Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= Env::get('APP_URL') ?>/auth/login">Login</a></li>
                    <li class="nav-item"><a class="btn btn-warning btn-sm ms-2 mt-1" href="<?= Env::get('APP_URL') ?>/auth/register">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Flash alert -->
<?php $alert = Session::getFlash('alert'); ?>
<?php if ($alert): ?>
<div class="alert alert-<?= $alert['type'] ?> alert-dismissible fade show m-0 rounded-0" role="alert">
    <div class="container"><?= htmlspecialchars($alert['message']) ?></div>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- Page Content -->
<main class="py-4">
    <?= $content ?? '' ?>
</main>

<!-- Footer -->
<footer class="bg-dark text-white py-4 mt-5">
    <div class="container text-center">
        <p class="mb-1"><strong>Dtrans Rental</strong> — North Sumatra's Premier Car Rental &amp; Tourism Platform</p>
        <p class="mb-0 text-muted small">&copy; <?= date('Y') ?> Dtrans Rental. All rights reserved.</p>
    </div>
</footer>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- Custom JS -->
<script src="<?= Env::get('APP_URL') ?>/assets/js/app.js"></script>
</body>
</html>
