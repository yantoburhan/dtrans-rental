<?php

class DriverReview extends Model
{
    protected string $table = 'driver_reviews';

    // =========================================================
    // Create Review
    // =========================================================
    public function createReview(array $data): bool
    {
        $sql = "INSERT INTO {$this->table}
                (
                    driver_id,
                    user_id,
                    booking_id,
                    rating,
                    comment,
                    created_at
                )
                VALUES (?, ?, ?, ?, ?, NOW())";

        return $this->execute($sql, [
            $data['driver_id'],
            $data['user_id'],
            $data['booking_id'],
            $data['rating'],
            $data['comment'],
        ]);
    }

    // =========================================================
    // Check if review already exists
    // =========================================================
    public function hasReview(int $bookingId): bool
    {
        $result = $this->query(
            "SELECT id
             FROM {$this->table}
             WHERE booking_id = ?
             LIMIT 1",
            [$bookingId]
        );

        return !empty($result);
    }

    // =========================================================
    // Get review by booking
    // =========================================================
    public function getByBooking(int $bookingId): ?array
    {
        $result = $this->query(
            "SELECT r.*, u.full_name AS reviewer_name
             FROM {$this->table} r
             JOIN users u ON u.id = r.user_id
             WHERE r.booking_id = ?
             LIMIT 1",
            [$bookingId]
        );

        return $result[0] ?? null;
    }

    // =========================================================
    // Get reviews by driver
    // =========================================================
    public function getByDriver(int $driverId): array
    {
        return $this->query(
            "SELECT r.*, u.full_name AS reviewer_name
             FROM {$this->table} r
             JOIN users u ON u.id = r.user_id
             WHERE r.driver_id = ?
             ORDER BY r.created_at DESC",
            [$driverId]
        );
    }
}