<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Activity Logs</h1>
            <p class="text-muted mb-0">System activity and user actions audit trail.</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover table-sm mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 10%">ID</th>
                        <th style="width: 15%">User</th>
                        <th style="width: 15%">Action</th>
                        <th style="width: 35%">Description</th>
                        <th style="width: 15%">IP Address</th>
                        <th style="width: 10%">Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logs)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No activity logs yet.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td><?= htmlspecialchars($log['id']) ?></td>
                                <td>
                                    <?php if ($log['user_id']): ?>
                                        <div class="font-weight-bold"><?= htmlspecialchars($log['full_name']) ?></div>
                                        <div class="text-muted small"><?= htmlspecialchars($log['email']) ?></div>
                                        <span class="badge bg-secondary"><?= htmlspecialchars($log['role']) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">System</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?= htmlspecialchars($log['action']) ?></span>
                                </td>
                                <td>
                                    <small><?= htmlspecialchars(substr($log['description'], 0, 100)) ?>
                                    <?php if (strlen($log['description']) > 100): ?>...<?php endif; ?></small>
                                </td>
                                <td><code class="text-monospace"><?= htmlspecialchars($log['ip_address'] ?? '—') ?></code></td>
                                <td>
                                    <small class="text-muted"><?= date('M d, Y H:i', strtotime($log['created_at'])) ?></small>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($totalPages > 1): ?>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <small class="text-muted">Showing 1 of <?= (int) $total ?> logs</small>
                <nav aria-label="Pagination">
                    <ul class="pagination pagination-sm mb-0">
                        <?php if ($currentPage > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=1">First</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $currentPage - 1 ?>">Previous</a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                            <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($currentPage < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $currentPage + 1 ?>">Next</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $totalPages ?>">Last</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        <?php endif; ?>
    </div>
</div>
