<?php

/**
 * Mailer — Gmail SMTP email sender using PHPMailer
 * Handles all transactional emails for Dtrans Rental
 *
 * Requires: composer require phpmailer/phpmailer
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private static function make(): PHPMailer
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = Env::get('MAIL_HOST', 'smtp.gmail.com');
        $mail->SMTPAuth   = true;
        $mail->Username   = Env::get('MAIL_USERNAME');
        $mail->Password   = Env::get('MAIL_PASSWORD');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = (int) Env::get('MAIL_PORT', 587);
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom(
            Env::get('MAIL_FROM_ADDRESS'),
            Env::get('MAIL_FROM_NAME', 'Dtrans Rental')
        );

        return $mail;
    }

    // ----------------------------------------------------------------
    // Email verification
    // ----------------------------------------------------------------

    public static function sendVerification(string $email, string $name, string $token): void
    {
        try {
            $mail = self::make();
            $mail->addAddress($email, $name);
            $mail->Subject = 'Verify Your Dtrans Rental Account';
            $mail->isHTML(true);

            $link = Env::get('APP_URL') . '/auth/verify/' . $token;

            $mail->Body = self::wrap("
                <h2>Welcome, {$name}!</h2>
                <p>Thank you for registering with Dtrans Rental. Please verify your email address to activate your account.</p>
                <p style='text-align:center'>
                    <a href='{$link}' class='btn'>Verify Email</a>
                </p>
                <p style='color:#888;font-size:13px'>If you did not register, please ignore this email.</p>
            ");

            $mail->send();
        } catch (Exception $e) {
            error_log('Mailer::sendVerification error: ' . $e->getMessage());
        }
    }

    // ----------------------------------------------------------------
    // Password reset
    // ----------------------------------------------------------------

    public static function sendPasswordReset(string $email, string $name, string $token): void
    {
        try {
            $mail = self::make();
            $mail->addAddress($email, $name);
            $mail->Subject = 'Reset Your Dtrans Rental Password';
            $mail->isHTML(true);

            $link = Env::get('APP_URL') . '/auth/reset-password/' . $token;

            $mail->Body = self::wrap("
                <h2>Password Reset Request</h2>
                <p>Hello {$name}, we received a request to reset your password. Click the button below to set a new password. This link expires in 1 hour.</p>
                <p style='text-align:center'>
                    <a href='{$link}' class='btn'>Reset Password</a>
                </p>
                <p style='color:#888;font-size:13px'>If you did not request this, please ignore this email.</p>
            ");

            $mail->send();
        } catch (Exception $e) {
            error_log('Mailer::sendPasswordReset error: ' . $e->getMessage());
        }
    }

    // ----------------------------------------------------------------
    // Booking confirmation
    // ----------------------------------------------------------------

    public static function sendBookingConfirmation(array $booking): void
    {
        try {
            $mail = self::make();
            $mail->addAddress($booking['customer_email'], $booking['customer_name']);
            $mail->Subject = "Booking Confirmation — {$booking['booking_code']}";
            $mail->isHTML(true);

            $mail->Body = self::wrap("
                <h2>Booking Confirmation</h2>
                <p>Hello {$booking['customer_name']}, your booking has been received and is pending admin approval.</p>
                <table class='details'>
                    <tr><th>Booking Code</th><td>{$booking['booking_code']}</td></tr>
                    <tr><th>Vehicle</th><td>{$booking['brand']} {$booking['model']}</td></tr>
                    <tr><th>Pickup Date</th><td>{$booking['pickup_date']}</td></tr>
                    <tr><th>Return Date</th><td>{$booking['return_date']}</td></tr>
                    <tr><th>Total Days</th><td>{$booking['total_days']} days</td></tr>
                    <tr><th>Driver</th><td>" . ($booking['driver_name'] ?? '— Self Drive —') . "</td></tr>
                    <tr><th>Total Price</th><td>IDR " . number_format($booking['total_price'], 0, ',', '.') . "</td></tr>
                    <tr><th>Status</th><td><strong>Pending Approval</strong></td></tr>
                </table>
                <p>You will receive another email once your booking is approved.</p>
            ");

            $mail->send();
        } catch (Exception $e) {
            error_log('Mailer::sendBookingConfirmation error: ' . $e->getMessage());
        }
    }

    // ----------------------------------------------------------------
    // Booking status update
    // ----------------------------------------------------------------

    public static function sendStatusUpdate(array $booking, string $newStatus, string $note = ''): void
    {
        try {
            $statusLabels = [
                'approved'  => 'Approved ✅',
                'rejected'  => 'Rejected ❌',
                'cancelled' => 'Cancelled',
                'completed' => 'Completed ✅',
            ];
            $label = $statusLabels[$newStatus] ?? ucfirst($newStatus);

            $mail = self::make();
            $mail->addAddress($booking['customer_email'], $booking['customer_name']);
            $mail->Subject = "Booking Update — {$booking['booking_code']}: {$label}";
            $mail->isHTML(true);

            $noteHtml = $note ? "<p><strong>Note:</strong> {$note}</p>" : '';

            $mail->Body = self::wrap("
                <h2>Booking Status Updated</h2>
                <p>Hello {$booking['customer_name']}, your booking <strong>{$booking['booking_code']}</strong> status has been updated to: <strong>{$label}</strong></p>
                {$noteHtml}
            ");

            $mail->send();
        } catch (Exception $e) {
            error_log('Mailer::sendStatusUpdate error: ' . $e->getMessage());
        }
    }

    // ----------------------------------------------------------------
    // Email wrapper template
    // ----------------------------------------------------------------

    private static function wrap(string $body): string
    {
        $appName = Env::get('APP_NAME', 'Dtrans Rental');
        $year    = date('Y');

        return <<<HTML
        <!DOCTYPE html>
        <html>
        <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: 'Segoe UI', Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 0; }
            .container { max-width: 600px; margin: 30px auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
            .header { background: #1a3c5e; padding: 24px 32px; }
            .header h1 { color: #fff; margin: 0; font-size: 22px; letter-spacing: 1px; }
            .content { padding: 32px; color: #333; line-height: 1.7; }
            .btn { display: inline-block; padding: 12px 28px; background: #e8a020; color: #fff; border-radius: 6px; text-decoration: none; font-weight: bold; }
            table.details { width: 100%; border-collapse: collapse; margin: 16px 0; }
            table.details th, table.details td { padding: 10px 14px; border: 1px solid #eee; text-align: left; }
            table.details th { background: #f8f8f8; width: 40%; }
            .footer { background: #f8f8f8; padding: 16px 32px; font-size: 12px; color: #999; text-align: center; }
        </style>
        </head>
        <body>
        <div class="container">
            <div class="header"><h1>{$appName}</h1></div>
            <div class="content">{$body}</div>
            <div class="footer">&copy; {$year} {$appName}. All rights reserved.</div>
        </div>
        </body>
        </html>
        HTML;
    }
}
