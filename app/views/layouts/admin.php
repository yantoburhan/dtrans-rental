<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Admin') ?> — Dtrans Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= Env::get('APP_URL') ?>/assets/css/admin.css">
</head>
<body class="admin-layout">

<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <nav class="sidebar bg-dark text-white" id="sidebar">
        <div class="sidebar-header p-3 border-bottom border-secondary">
            <a href="<?= Env::get('APP_URL') ?>/admin/dashboard" class="text-white text-decoration-none">
                <i class="bi bi-car-front-fill me-2 text-warning"></i>
                <strong>Dtrans Admin</strong>
            </a>
        </div>
        <ul class="nav flex-column py-2">
            <li class="nav-item">
                <a class="nav-link text-white-50" href="<?= Env::get('APP_URL') ?>/admin/dashboard">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white-50" href="<?= Env::get('APP_URL') ?>/admin/bookings">
                    <i class="bi bi-calendar-check me-2"></i>Bookings
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white-50" href="<?= Env::get('APP_URL') ?>/admin/cars">
                    <i class="bi bi-car-front me-2"></i>Cars
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white-50" href="<?= Env::get('APP_URL') ?>/admin/drivers">
                    <i class="bi bi-person-badge me-2"></i>Drivers
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white-50" href="<?= Env::get('APP_URL') ?>/admin/customers">
                    <i class="bi bi-people me-2"></i>Customers
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white-50" href="<?= Env::get('APP_URL') ?>/admin/tourism">
                    <i class="bi bi-map me-2"></i>Tourism
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white-50" href="<?= Env::get('APP_URL') ?>/admin/reports">
                    <i class="bi bi-bar-chart me-2"></i>Reports
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white-50" href="<?= Env::get('APP_URL') ?>/admin/chat">
                    <i class="bi bi-chat-dots me-2"></i>Live Chat
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white-50" href="<?= Env::get('APP_URL') ?>/admin/logs">
                    <i class="bi bi-clock-history me-2"></i>Activity Logs
                </a>
            </li>
            <li class="nav-item mt-3 border-top border-secondary pt-3">
                <a class="nav-link text-danger" href="<?= Env::get('APP_URL') ?>/auth/logout">
                    <i class="bi bi-box-arrow-left me-2"></i>Logout
                </a>
            </li>
        </ul>
    </nav>

    <!-- Page Content -->
    <div class="flex-grow-1" id="page-content">
        <!-- Top bar -->
        <div class="topbar bg-white border-bottom px-4 py-2 d-flex align-items-center justify-content-between">
            <button class="btn btn-sm btn-outline-secondary" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted small"><?= date('l, d F Y') ?></span>
                <span class="fw-semibold"><?= htmlspecialchars(Session::get('user')['name']) ?></span>
            </div>
        </div>

        <!-- Flash alert -->
        <?php $alert = Session::getFlash('alert'); ?>
        <?php if ($alert): ?>
        <div class="alert alert-<?= $alert['type'] ?> alert-dismissible fade show m-3" role="alert">
            <?= htmlspecialchars($alert['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <!-- Content -->
        <div class="p-4">
            <?= $content ?? '' ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="<?= Env::get('APP_URL') ?>/assets/js/admin.js"></script>
<script>
    document.getElementById('sidebarToggle').addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('collapsed');
    });
</script>
</body>
</html>
