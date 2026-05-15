<?php

/**
 * ActivityLog — Model for activity logging
 */
class ActivityLog extends Model
{
    protected string $table = 'activity_logs';

    public function getAllLogs(int $limit = 100, int $offset = 0): array
    {
        return $this->query(
            "SELECT al.id, al.action, al.description, al.ip_address, al.created_at,
                    u.id AS user_id, u.full_name, u.email, u.role
             FROM {$this->table} al
             LEFT JOIN users u ON al.user_id = u.id
             ORDER BY al.created_at DESC
             LIMIT ? OFFSET ?",
            [$limit, $offset]
        );
    }

    public function getTotalCount(): int
    {
        $result = $this->queryOne(
            "SELECT COUNT(*) AS total FROM {$this->table}"
        );
        return (int) ($result['total'] ?? 0);
    }

    public function log(int $userId, string $action, string $description = '', string $ipAddress = ''): int
    {
        return $this->insert([
            'user_id'    => $userId,
            'action'     => $action,
            'description' => $description,
            'ip_address' => $ipAddress,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function deleteOldLogs(int $daysOld = 90): bool
    {
        $date = date('Y-m-d H:i:s', strtotime("-{$daysOld} days"));
        return $this->execute(
            "DELETE FROM {$this->table} WHERE created_at < ?",
            [$date]
        );
    }
}
