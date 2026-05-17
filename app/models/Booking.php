<?php

/**
 * Booking — Model for bookings table
 */
class Booking extends Model
{
    protected string $table = 'bookings';

    const STATUS_PENDING         = 'pending';
    const STATUS_WAITING_PAYMENT = 'waiting_payment';
    const STATUS_APPROVED        = 'approved';
    const STATUS_ONGOING         = 'ongoing';
    const STATUS_COMPLETED       = 'completed';
    const STATUS_CANCELLED       = 'cancelled';

    // ----------------------------------------------------------------
    // Create booking
    // ----------------------------------------------------------------

    public function createBooking(array $data): int
    {
        $bookingCode = $this->generateCode();

        return $this->insert([
            'booking_code'   => $bookingCode,
            'user_id'        => $data['user_id'],
            'car_id'         => $data['car_id'],
            'driver_id'      => $data['driver_id'] ?? null,
            'pickup_date'    => $data['pickup_date'],
            'return_date'    => $data['return_date'],
            'total_days'     => $data['total_days'],
            'car_price'      => $data['car_price'],
            'driver_price'   => $data['driver_price'] ?? 0,
            'total_price'    => $data['total_price'],
            'payment_method' => $data['payment_method'],
            'notes'          => $data['notes'] ?? null,
            'status'         => self::STATUS_PENDING,
            'created_at'     => date('Y-m-d H:i:s'),
        ]);
    }

    private function generateCode(): string
    {
        return 'DTR-' . strtoupper(uniqid());
    }

    // ----------------------------------------------------------------
    // Get customer bookings
    // ----------------------------------------------------------------

    public function getByUser(int $userId): array
    {
        return $this->query(
            "SELECT
                b.id AS booking_id,
                b.booking_code,
                b.user_id,
                b.car_id,
                b.driver_id,
                b.pickup_date,
                b.return_date,
                b.total_days,
                b.total_price,
                b.payment_method,
                b.status,
                b.created_at,

                c.brand,
                c.model,
                c.category,

                d.full_name AS driver_name

            FROM {$this->table} b

            JOIN cars c
                ON c.id = b.car_id

            LEFT JOIN drivers d
                ON d.id = b.driver_id

            WHERE b.user_id = ?

            ORDER BY b.created_at DESC",
            [$userId]
        );
    }

    public function getRecentActivities(int $userId, int $limit = 5): array
    {
        return $this->query(
            "SELECT
                b.booking_code,
                b.pickup_date,
                b.return_date,
                b.status,
                b.total_price,
                b.created_at,

                c.brand,
                c.model,
                c.category,

                d.full_name AS driver_name

            FROM {$this->table} b

            JOIN cars c
                ON c.id = b.car_id

            LEFT JOIN drivers d
                ON d.id = b.driver_id

            WHERE b.user_id = ?

            ORDER BY b.created_at DESC

            LIMIT {$limit}",
            [$userId]
        );
    }

    // ----------------------------------------------------------------
    // Get full booking detail
    // ----------------------------------------------------------------

    public function getFullDetail(int $id): ?array
    {
        return $this->queryOne(
            "SELECT
                b.id AS booking_id,
                b.*,

                u.full_name AS customer_name,
                u.email     AS customer_email,
                u.phone     AS customer_phone,

                c.brand,
                c.model,
                c.category,
                c.plate_number,

                d.full_name AS driver_name,
                d.phone     AS driver_phone,

                p.status    AS payment_status,
                p.paid_at   AS payment_date,
                p.method    AS payment_method_used

            FROM {$this->table} b

            JOIN users u
                ON u.id = b.user_id

            JOIN cars c
                ON c.id = b.car_id

            LEFT JOIN drivers d
                ON d.id = b.driver_id

            LEFT JOIN payments p
                ON p.booking_id = b.id

            WHERE b.id = ?",
            [$id]
        );
    }

    // ----------------------------------------------------------------
    // Admin booking list
    // ----------------------------------------------------------------

    public function getAllAdminBookings(): array
    {
        return $this->query(
            "SELECT
                b.id AS booking_id,
                b.*,

                u.full_name AS customer_name,

                c.brand,
                c.model,

                d.full_name AS driver_name

            FROM {$this->table} b

            JOIN users u
                ON u.id = b.user_id

            JOIN cars c
                ON c.id = b.car_id

            LEFT JOIN drivers d
                ON d.id = b.driver_id

            ORDER BY b.created_at DESC"
        );
    }

    // ----------------------------------------------------------------
    // Dashboard statistics
    // ----------------------------------------------------------------

    public function getActiveRentals(): int
    {
        $stmt = $this->db()->query(
            "SELECT COUNT(*)
             FROM {$this->table}
             WHERE status IN ('approved','ongoing')"
        );

        return (int) $stmt->fetchColumn();
    }

    public function getTotalRevenue(): float
    {
        $stmt = $this->db()->query(
            "SELECT COALESCE(SUM(total_price),0)
             FROM {$this->table}
             WHERE status = 'completed'"
        );

        return (float) $stmt->fetchColumn();
    }

    public function getSummary(): array
    {
        $result = $this->query(
            "SELECT
                COUNT(*) AS total_bookings,

                SUM(
                    CASE
                        WHEN status = 'completed'
                        THEN 1
                        ELSE 0
                    END
                ) AS completed_bookings,

                COALESCE(
                    SUM(
                        CASE
                            WHEN status = 'completed'
                            THEN total_price
                            ELSE 0
                        END
                    ),
                    0
                ) AS completed_revenue

             FROM {$this->table}"
        );

        return $result[0] ?? [
            'total_bookings'     => 0,
            'completed_bookings' => 0,
            'completed_revenue'  => 0,
        ];
    }

    public function getMonthlyRevenue(int $year): array
    {
        return $this->query(
            "SELECT
                MONTH(created_at) AS month,
                SUM(total_price) AS revenue

            FROM {$this->table}

            WHERE status = 'completed'
            AND YEAR(created_at) = ?

            GROUP BY MONTH(created_at)",
            [$year]
        );
    }

    public function getRecentBookings(int $limit = 10): array
    {
        return $this->query(
            "SELECT
                b.booking_code,
                b.total_price,
                b.status,
                b.created_at,

                u.full_name AS customer_name,

                c.brand AS car_brand,
                c.model AS car_model

            FROM {$this->table} b

            JOIN users u
                ON u.id = b.user_id

            JOIN cars c
                ON c.id = b.car_id

            ORDER BY b.created_at DESC

            LIMIT {$limit}"
        );
    }

    public function getReportData(int $year): array
    {
        return $this->query(
            "SELECT
                b.id AS booking_id,
                b.booking_code,

                u.full_name AS customer_name,

                c.brand,
                c.model,

                b.pickup_date,
                b.return_date,
                b.total_days,
                b.total_price,
                b.status,
                b.created_at

            FROM {$this->table} b

            JOIN users u
                ON u.id = b.user_id

            JOIN cars c
                ON c.id = b.car_id

            WHERE YEAR(b.created_at) = ?

            ORDER BY b.created_at DESC",
            [$year]
        );
    }

    // ----------------------------------------------------------------
    // Status update
    // ----------------------------------------------------------------

    public function updateStatus(
        int $id,
        string $status,
        array $extra = []
    ): bool {
        return $this->update(
            $id,
            array_merge(['status' => $status], $extra)
        );
    }

    // ----------------------------------------------------------------
    // Overlap check
    // ----------------------------------------------------------------

    public function hasOverlap(
        int $carId,
        string $pickupDate,
        string $returnDate,
        ?int $driverId = null,
        ?int $excludeId = null
    ): bool {

        // Car overlap
        $sql = "SELECT COUNT(*)
                FROM {$this->table}

                WHERE car_id = ?
                AND status NOT IN ('cancelled')

                AND pickup_date < ?
                AND return_date > ?";

        $params = [$carId, $returnDate, $pickupDate];

        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $stmt = $this->db()->prepare($sql);
        $stmt->execute($params);

        if ((int) $stmt->fetchColumn() > 0) {
            return true;
        }

        // Driver overlap
        if ($driverId) {

            $sql = "SELECT COUNT(*)
                    FROM {$this->table}

                    WHERE driver_id = ?
                    AND status NOT IN ('cancelled')

                    AND pickup_date < ?
                    AND return_date > ?";

            $params = [$driverId, $returnDate, $pickupDate];

            if ($excludeId) {
                $sql .= " AND id != ?";
                $params[] = $excludeId;
            }

            $stmt = $this->db()->prepare($sql);
            $stmt->execute($params);

            if ((int) $stmt->fetchColumn() > 0) {
                return true;
            }
        }

        return false;
    }
}