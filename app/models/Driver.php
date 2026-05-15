<?php

/**
 * Driver — Model for drivers table
 */
class Driver extends Model
{
    protected string $table = 'drivers';

    public function getAvailableDrivers(string $pickupDate, string $returnDate): array
    {
        return $this->query(
            "SELECT d.*, COALESCE(AVG(r.rating), 0) AS avg_rating, COUNT(r.id) AS review_count
             FROM {$this->table} d
             LEFT JOIN driver_reviews r ON r.driver_id = d.id
             WHERE d.status = 'available'
             AND d.id NOT IN (
                 SELECT driver_id FROM bookings
                 WHERE driver_id IS NOT NULL
                 AND status NOT IN ('cancelled','rejected')
                 AND pickup_date  < ?
                 AND return_date  > ?
             )
             GROUP BY d.id
             ORDER BY avg_rating DESC",
            [$returnDate, $pickupDate]
        );
    }

    public function getWithReviews(int $id): ?array
    {
        $driver = $this->find($id);
        if (!$driver) return null;

        $driver['reviews'] = $this->query(
            "SELECT r.*, u.full_name AS reviewer_name
             FROM driver_reviews r
             JOIN users u ON u.id = r.user_id
             WHERE r.driver_id = ?
             ORDER BY r.created_at DESC",
            [$id]
        );

        $driver['avg_rating'] = count($driver['reviews'])
            ? round(array_sum(array_column($driver['reviews'], 'rating')) / count($driver['reviews']), 1)
            : 0;

        return $driver;
    }

    public function getBestDrivers(int $limit = 5): array
    {
        return $this->query(
            "SELECT d.id, d.full_name, d.photo, d.experience, COALESCE(AVG(r.rating),0) AS avg_rating, COUNT(r.id) AS review_count
             FROM {$this->table} d
             LEFT JOIN driver_reviews r ON r.driver_id = d.id
             GROUP BY d.id
             ORDER BY avg_rating DESC
             LIMIT ?",
            [$limit]
        );
    }
}
