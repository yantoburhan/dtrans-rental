<?php

/**
 * Car — Model for cars table
 */
class Car extends Model
{
    protected string $table = 'cars';

    // ----------------------------------------------------------------
    // Public listing
    // ----------------------------------------------------------------

    public function getAvailableCars(array $filters = []): array
    {
        $where  = ["c.status = 'available'"];
        $params = [];

        if (!empty($filters['category'])) {
            $where[]  = 'c.category = ?';
            $params[] = $filters['category'];
        }

        if (!empty($filters['transmission'])) {
            $where[]  = 'c.transmission = ?';
            $params[] = $filters['transmission'];
        }

        if (!empty($filters['capacity'])) {
            $where[]  = 'c.capacity >= ?';
            $params[] = (int) $filters['capacity'];
        }

        if (!empty($filters['pickup_date']) && !empty($filters['return_date'])) {
            $where[] = "c.id NOT IN (
                SELECT car_id FROM bookings
                WHERE status NOT IN ('cancelled','rejected')
                AND pickup_date  < ?
                AND return_date  > ?
            )";
            $params[] = $filters['return_date'];
            $params[] = $filters['pickup_date'];
        }

        $sql = "SELECT c.*, 
                       (SELECT photo_path FROM car_photos WHERE car_id = c.id ORDER BY sort_order LIMIT 1) AS primary_photo
                FROM {$this->table} c
                WHERE " . implode(' AND ', $where) . "
                ORDER BY c.daily_price ASC";

        return $this->query($sql, $params);
    }

    public function getWithPhotos(int $id): ?array
    {
        $car = $this->find($id);
        if (!$car) {
            return null;
        }

        $car['photos'] = $this->query(
            "SELECT * FROM car_photos WHERE car_id = ? ORDER BY sort_order",
            [$id]
        );

        return $car;
    }

    // ----------------------------------------------------------------
    // Availability check
    // ----------------------------------------------------------------

    public function isAvailable(int $carId, string $pickupDate, string $returnDate, ?int $excludeBookingId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM bookings
                WHERE car_id = ?
                AND status NOT IN ('cancelled','rejected')
                AND pickup_date  < ?
                AND return_date  > ?";

        $params = [$carId, $returnDate, $pickupDate];

        if ($excludeBookingId) {
            $sql     .= " AND id != ?";
            $params[] = $excludeBookingId;
        }

        return (int) $this->db()->prepare($sql) && (function () use ($sql, $params) {
            $stmt = $this->db()->prepare($sql);
            $stmt->execute($params);
            return (int) $stmt->fetchColumn() === 0;
        })();
    }

    // ----------------------------------------------------------------
    // Admin helpers
    // ----------------------------------------------------------------

    public function getMostRented(int $limit = 5): array
    {
        return $this->query(
            "SELECT
                c.id,
                c.brand,
                c.model,
                COUNT(b.id) AS rentals

            FROM {$this->table} c

            LEFT JOIN bookings b
                ON b.car_id = c.id
                AND b.status IN ('approved','ongoing','completed')

            GROUP BY c.id

            ORDER BY rentals DESC

            LIMIT {$limit}"
        );
    }

    public function getTotalCars(): int
    {
        return $this->count();
    }

    public function getAll(): array
    {
        return $this->all();
    }

    public function create(array $data): int
    {
        return $this->insert($data);
    }

    public function edit(int $id): bool
    {
        // For update, but update is in base
        return true; // placeholder
    }

    public function remove(int $id): bool
    {
        return $this->delete($id);
    }
}
