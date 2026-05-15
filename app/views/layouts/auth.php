<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Auth') ?> — Dtrans Rental</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= Env::get('APP_URL') ?>/assets/css/app.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
        }
        .auth-card {
            max-width: 420px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="card auth-card shadow-sm">
            <div class="card-body p-4">
                <?php if ($pageTitle): ?>
                    <h1 class="h4 mb-3 text-center"><?= htmlspecialchars($pageTitle) ?></h1>
                <?php endif; ?>

                <!-- Flash alert -->
                <?php $alert = Session::getFlash('alert'); ?>
                <?php if ($alert): ?>
                <div class="alert alert-<?= $alert['type'] ?> alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($alert['message']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?= $content ?? '' ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
