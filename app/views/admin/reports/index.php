<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Reports</h1>
            <p class="text-muted mb-0">Sales and booking statistics for the year <?= htmlspecialchars($year) ?>.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= htmlspecialchars($exportUrl) ?>" class="btn btn-outline-success">Export CSV</a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted">Total Bookings</h6>
                    <h2 class="mb-0"><?= number_format($summary['total_bookings'] ?? 0) ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted">Completed Bookings</h6>
                    <h2 class="mb-0"><?= number_format($summary['completed_bookings'] ?? 0) ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted">Completed Revenue</h6>
                    <h2 class="mb-0">IDR <?= number_format($summary['completed_revenue'] ?? 0, 0, ',', '.') ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="card-title mb-0">Revenue by Month</h5>
                    <p class="text-muted small mb-0">Year <?= htmlspecialchars($year) ?></p>
                </div>
                <form method="GET" class="d-flex align-items-center gap-2">
                    <label class="mb-0 small text-muted">Year</label>
                    <select name="year" class="form-select form-select-sm" onchange="this.form.submit()">
                        <?php for ($y = date('Y'); $y >= date('Y') - 4; $y--): ?>
                            <option value="<?= $y ?>" <?= $y === (int) $year ? 'selected' : '' ?>><?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                </form>
            </div>

            <canvas id="revenueChart" height="120"></canvas>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Monthly Revenue Table</h5>
            <div class="table-responsive">
                <table class="table table-striped table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th class="text-end">Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($months as $monthNumber => $monthName): ?>
                            <tr>
                                <td><?= htmlspecialchars($monthName) ?></td>
                                <td class="text-end">IDR <?= number_format($revenueByMonth[$monthNumber] ?? 0, 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: <?= json_encode(array_values($months)) ?>,
                datasets: [{
                    label: 'Revenue',
                    data: <?= json_encode(array_values($revenueByMonth)) ?>,
                    backgroundColor: 'rgba(13, 110, 253, 0.15)',
                    borderColor: 'rgba(13, 110, 253, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: (value) => 'IDR ' + value.toLocaleString('id-ID')
                        }
                    }
                }
            }
        });
    }
</script>
