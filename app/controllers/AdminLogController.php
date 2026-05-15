<?php

/**
 * AdminLogController — Activity logs viewer
 */
class AdminLogController extends Controller
{
    private ActivityLog $logModel;

    public function __construct()
    {
        $this->logModel = new ActivityLog();
    }

    public function index(): void
    {
        $page = max(1, (int) $this->input('page', 1));
        $perPage = 50;
        $offset = ($page - 1) * $perPage;

        $logs = $this->logModel->getAllLogs($perPage, $offset);
        $total = $this->logModel->getTotalCount();
        $totalPages = (int) ceil($total / $perPage);

        $this->view('admin.logs.index', [
            'pageTitle'   => 'Activity Logs',
            'logs'        => $logs,
            'currentPage' => $page,
            'totalPages'  => $totalPages,
            'total'       => $total,
        ], 'admin');
    }
}
