<?php

/**
 * InvoiceController — Booking invoice PDF export
 * Requires: composer require dompdf/dompdf
 */
class InvoiceController extends Controller
{
    public function download(string $id): void
    {
        $user    = Session::get('user');
        $booking = (new Booking())->getFullDetail((int) $id);

        if (!$booking || $booking['user_id'] != $user['id']) {
            $this->flash('danger', 'Invoice not found.');
            $this->redirect('customer/bookings');
            return;
        }

        // Generate QR code data (booking code as text fallback)
        $qrData = $booking['booking_code'];

        // Build HTML invoice
        $html = $this->buildInvoiceHtml($booking, $qrData);

        // Render with DomPDF
        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'invoice-' . $booking['booking_code'] . '.pdf';
        $dompdf->stream($filename, ['Attachment' => true]);
        exit;
    }

    private function buildInvoiceHtml(array $booking, string $qrData): string
    {
        $appName    = Env::get('APP_NAME', 'Dtrans Rental');
        $totalFmt   = 'IDR ' . number_format($booking['total_price'], 0, ',', '.');
        $driverName = $booking['driver_name'] ?? '— Self Drive —';
        $paid       = ucfirst($booking['payment_status'] ?? 'pending');

        return <<<HTML
        <!DOCTYPE html>
        <html>
        <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 13px; color: #333; }
            .header { background: #1a3c5e; color: white; padding: 20px; text-align: center; }
            .header h1 { margin: 0; font-size: 22px; }
            .section { padding: 20px; }
            table { width: 100%; border-collapse: collapse; margin-top: 10px; }
            th, td { padding: 9px 12px; border: 1px solid #ddd; text-align: left; }
            th { background: #f4f4f4; }
            .total-row td { font-weight: bold; font-size: 15px; background: #eaf4fb; }
            .footer { text-align: center; font-size: 11px; color: #888; padding: 16px; border-top: 1px solid #eee; }
            .status { display: inline-block; padding: 4px 10px; border-radius: 4px; font-size: 11px; }
            .badge-approved { background: #d4edda; color: #155724; }
        </style>
        </head>
        <body>
        <div class="header">
            <h1>{$appName}</h1>
            <p>Rental Invoice</p>
        </div>
        <div class="section">
            <p><strong>Booking Code:</strong> {$booking['booking_code']}</p>
            <p><strong>Issued:</strong> {$booking['created_at']}</p>
            <h3>Customer Information</h3>
            <table>
                <tr><th>Name</th><td>{$booking['customer_name']}</td></tr>
                <tr><th>Email</th><td>{$booking['customer_email']}</td></tr>
                <tr><th>Phone</th><td>{$booking['customer_phone']}</td></tr>
            </table>
            <h3>Rental Details</h3>
            <table>
                <tr><th>Vehicle</th><td>{$booking['brand']} {$booking['model']}</td></tr>
                <tr><th>Plate Number</th><td>{$booking['plate_number']}</td></tr>
                <tr><th>Driver</th><td>{$driverName}</td></tr>
                <tr><th>Pickup Date</th><td>{$booking['pickup_date']}</td></tr>
                <tr><th>Return Date</th><td>{$booking['return_date']}</td></tr>
                <tr><th>Total Days</th><td>{$booking['total_days']} days</td></tr>
            </table>
            <h3>Payment Summary</h3>
            <table>
                <tr><th>Car Rental</th><td>IDR {$booking['car_price']}</td></tr>
                <tr><th>Driver Fee</th><td>IDR {$booking['driver_price']}</td></tr>
                <tr><th>Late Penalty</th><td>IDR {$booking['late_penalty']}</td></tr>
                <tr class="total-row"><th>Total</th><td>{$totalFmt}</td></tr>
                <tr><th>Payment Status</th><td>{$paid}</td></tr>
            </table>
            <p style="margin-top:20px;font-size:11px;color:#888">
                This invoice was generated automatically by {$appName}. 
                Booking Code: <strong>{$booking['booking_code']}</strong>
            </p>
        </div>
        <div class="footer">
            {$appName} &mdash; Sumatera Utara &mdash; Thank you for choosing us!
        </div>
        </body>
        </html>
        HTML;
    }
}
