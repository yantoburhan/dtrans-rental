<?php

class TourismDestination extends Model
{
    protected string $table = 'tourism_destinations';

    public function getFeatured(int $limit = 6): array
    {
        return $this->query(
            "SELECT d.*, 
                    (SELECT photo_path FROM tourism_photos WHERE destination_id = d.id ORDER BY sort_order LIMIT 1) AS primary_photo
             FROM {$this->table} d
             ORDER BY d.id DESC
             LIMIT ?",
            [$limit]
        );
    }

    public function getWithPhotos(int $id): ?array
    {
        $dest = $this->find($id);
        if (!$dest) return null;

        $dest['photos'] = $this->query(
            "SELECT * FROM tourism_photos WHERE destination_id = ? ORDER BY sort_order",
            [$id]
        );

        return $dest;
    }

    public function addPhoto(
        int $destinationId,
        string $photoPath,
        int $sortOrder = 0
    ): bool {
        return $this->db()->prepare(
            "INSERT INTO tourism_photos
            (destination_id, photo_path, sort_order)
            VALUES (?, ?, ?)"
        )->execute([
            $destinationId,
            $photoPath,
            $sortOrder
        ]);
    }
}
