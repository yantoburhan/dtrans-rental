<?php

/**
 * ChatMessage — Model for customer/admin live chat messages
 */
class ChatMessage extends Model
{
    protected string $table = 'chat_messages';

    public function getByUser(int $userId): array
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY created_at ASC",
            [$userId]
        );
    }

    public function createMessage(int $userId, string $sender, string $message): int
    {
        return $this->insert([
            'user_id'    => $userId,
            'sender'     => $sender,
            'message'    => $message,
            'is_read'    => $sender === 'admin' ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function getCustomerThreads(): array
    {
        return $this->query(
            "SELECT u.id,
                    u.full_name,
                    u.email,
                    u.avatar,
                    m.message AS last_message,
                    m.sender AS last_sender,
                    m.created_at AS last_message_at,
                    SUM(CASE WHEN cm.is_read = 0 AND cm.sender = 'customer' THEN 1 ELSE 0 END) AS unread_count
             FROM users u
             JOIN {$this->table} cm ON cm.user_id = u.id
             JOIN {$this->table} m ON m.user_id = u.id
                AND m.created_at = (
                    SELECT MAX(created_at)
                    FROM {$this->table}
                    WHERE user_id = u.id
                )
             WHERE u.role = 'customer'
             GROUP BY u.id
             ORDER BY last_message_at DESC"
        );
    }

    public function markCustomerMessagesRead(int $userId): bool
    {
        return $this->execute(
            "UPDATE {$this->table} SET is_read = 1 WHERE user_id = ? AND sender = 'customer'",
            [$userId]
        );
    }
}
