<?php

/**
 * User — Model for users table (customers, admins)
 */
class User extends Model
{
    protected string $table = 'users';

    // ----------------------------------------------------------------
    // Authentication
    // ----------------------------------------------------------------

    public function findByEmail(string $email): ?array
    {
        return $this->first('email', $email);
    }

    public function findByUsername(string $username): ?array
    {
        return $this->first('username', $username);
    }

    public function findByGoogleId(string $googleId): ?array
    {
        return $this->first('google_id', $googleId);
    }

    public function findByVerificationToken(string $token): ?array
    {
        return $this->first('email_verification_token', $token);
    }

    public function findByResetToken(string $token): ?array
    {
        return $this->queryOne(
            "SELECT * FROM {$this->table} 
             WHERE password_reset_token = ? AND password_reset_expires > NOW() 
             LIMIT 1",
            [$token]
        );
    }

    public function verifyEmail(int $userId): bool
    {
        return $this->update($userId, [
            'email_verified_at'         => date('Y-m-d H:i:s'),
            'email_verification_token'  => null,
        ]);
    }

    // ----------------------------------------------------------------
    // Registration
    // ----------------------------------------------------------------

    public function createCustomer(array $data): int
    {
        return $this->insert([
            'full_name'                  => $data['full_name'],
            'username'                   => $data['username'],
            'email'                      => $data['email'],
            'password'                   => password_hash($data['password'], PASSWORD_BCRYPT),
            'phone'                      => $data['phone'],
            'address'                    => $data['address'],
            'identity_type'              => $data['identity_type'],
            'identity_file'              => $data['identity_file'],
            'role'                       => 'customer',
            'email_verification_token'   => $data['verification_token'],
            'created_at'                 => date('Y-m-d H:i:s'),
        ]);
    }

    public function createFromGoogle(array $data): int
    {
        return $this->insert([
            'full_name'        => $data['name'],
            'email'            => $data['email'],
            'google_id'        => $data['google_id'],
            'avatar'           => $data['avatar'] ?? null,
            'role'             => 'customer',
            'email_verified_at'=> date('Y-m-d H:i:s'),
            'created_at'       => date('Y-m-d H:i:s'),
        ]);
    }

    public function createAdmin(array $data): int
    {
        return $this->insert([
            'full_name'        => $data['full_name'],
            'username'         => $data['username'],
            'email'            => $data['email'],
            'password'         => password_hash($data['password'], PASSWORD_BCRYPT),
            'phone'            => $data['phone'] ?? null,
            'address'          => $data['address'] ?? null,
            'role'             => 'admin',
            'email_verified_at'=> date('Y-m-d H:i:s'),
            'created_at'       => date('Y-m-d H:i:s'),
        ]);
    }

    // ----------------------------------------------------------------
    // Queries
    // ----------------------------------------------------------------

    public function getCustomers(int $page = 1, int $perPage = 20): array
    {
        $offset = ($page - 1) * $perPage;

        $stmt = $this->db()->prepare(
            "SELECT * FROM {$this->table} WHERE role = 'customer' ORDER BY created_at DESC LIMIT ? OFFSET ?"
        );
        $stmt->execute([$perPage, $offset]);

        $items = $stmt->fetchAll();
        $total = $this->getTotalCustomers();

        return [
            'data'         => $items,
            'total'        => $total,
            'per_page'     => $perPage,
            'current_page' => $page,
            'last_page'    => (int) ceil($total / $perPage),
        ];
    }

    public function findCustomer(int $id): ?array
    {
        $stmt = $this->db()->prepare("SELECT * FROM {$this->table} WHERE id = ? AND role = 'customer' LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function getTotalCustomers(): int
    {
        return (int) $this->db()->query(
            "SELECT COUNT(*) FROM {$this->table} WHERE role = 'customer'"
        )->fetchColumn();
    }
}
