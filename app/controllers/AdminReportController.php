<?php

/**
 * AdminReportController — Admin reports overview and export
 */
class AdminReportController extends Controller
{
    private Booking $bookingModel;

    public function __construct()
    {
        $this->bookingModel = new Booking();
    }

    public function index(): void
    {
        $year = (int) $this->input('year', date('Y'));
        $monthlyRevenue = $this->bookingModel->getMonthlyRevenue($year);

        $months = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug',
            9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec',
        ];

        $revenueByMonth = array_fill(1, 12, 0.0);
        foreach ($monthlyRevenue as $row) {
            $month = (int) $row['month'];
            if ($month >= 1 && $month <= 12) {
                $revenueByMonth[$month] = (float) $row['revenue'];
            }
        }

        $summary = $this->bookingModel->getSummary();

        $this->view('admin.reports.index', [
            'pageTitle'      => 'Reports',
            'year'           => $year,
            'months'         => $months,
            'revenueByMonth' => $revenueByMonth,
            'summary'        => $summary,
            'exportUrl'      => Env::get('APP_URL') . '/admin/reports/export?year=' . $year,
        ], 'admin');
    }

    public function export(): void
    {
        $year = (int) $this->input('year', date('Y'));
        $reportRows = $this->bookingModel->getReportData($year);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="admin-reports-' . $year . '.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Booking Code', 'Customer', 'Car', 'Pickup Date', 'Return Date', 'Total Days', 'Total Price', 'Status', 'Created At']);

        foreach ($reportRows as $row) {
            fputcsv($output, [
                $row['id'],
                $row['booking_code'],
                $row['customer_name'],
                $row['brand'] . ' ' . $row['model'],
                $row['pickup_date'],
                $row['return_date'],
                $row['total_days'],
                $row['total_price'],
                ucfirst($row['status']),
                $row['created_at'],
            ]);
        }

        fclose($output);
        exit;
    }
}
