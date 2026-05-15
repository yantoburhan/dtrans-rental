<?php

/**
 * Model — Base model with PDO database connection
 * All models extend this class
 */
abstract class Model
{
    protected static ?PDO $pdo = null;
    protected string $table    = '';
    protected string $pk       = 'id';

    // ----------------------------------------------------------------
    // Connection
    // ----------------------------------------------------------------

    protected function db(): PDO
    {
        if (self::$pdo === null) {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                Env::get('DB_HOST', 'localhost'),
                Env::get('DB_PORT', '3306'),
                Env::get('DB_NAME', 'dtrans_rental')
            );

            self::$pdo = new PDO($dsn, Env::get('DB_USER', 'root'), Env::get('DB_PASS', ''), [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        }

        return self::$pdo;
    }

    // ----------------------------------------------------------------
    // Query helpers
    // ----------------------------------------------------------------

    public function find(int $id): ?array
    {
        $stmt = $this->db()->prepare("SELECT * FROM {$this->table} WHERE {$this->pk} = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function all(string $orderBy = 'id', string $dir = 'ASC'): array
    {
        $dir  = strtoupper($dir) === 'DESC' ? 'DESC' : 'ASC';
        $stmt = $this->db()->query("SELECT * FROM {$this->table} ORDER BY {$orderBy} {$dir}");
        return $stmt->fetchAll();
    }

    public function where(string $column, mixed $value, string $operator = '='): array
    {
        $stmt = $this->db()->prepare("SELECT * FROM {$this->table} WHERE {$column} {$operator} ?");
        $stmt->execute([$value]);
        return $stmt->fetchAll();
    }

    public function first(string $column, mixed $value): ?array
    {
        $stmt = $this->db()->prepare("SELECT * FROM {$this->table} WHERE {$column} = ? LIMIT 1");
        $stmt->execute([$value]);
        return $stmt->fetch() ?: null;
    }

    public function insert(array $data): int
    {
        $columns      = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $stmt         = $this->db()->prepare("INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})");
        $stmt->execute(array_values($data));
        return (int) $this->db()->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $set  = implode(', ', array_map(fn($col) => "$col = ?", array_keys($data)));
        $stmt = $this->db()->prepare("UPDATE {$this->table} SET {$set} WHERE {$this->pk} = ?");
        return $stmt->execute([...array_values($data), $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db()->prepare("DELETE FROM {$this->table} WHERE {$this->pk} = ?");
        return $stmt->execute([$id]);
    }

    public function count(): int
    {
        return (int) $this->db()->query("SELECT COUNT(*) FROM {$this->table}")->fetchColumn();
    }

    public function paginate(int $page = 1, int $perPage = 15): array
    {
        $offset = ($page - 1) * $perPage;
        $items  = $this->db()
                       ->query("SELECT * FROM {$this->table} LIMIT {$perPage} OFFSET {$offset}")
                       ->fetchAll();
        $total  = $this->count();

        return [
            'data'         => $items,
            'total'        => $total,
            'per_page'     => $perPage,
            'current_page' => $page,
            'last_page'    => (int) ceil($total / $perPage),
        ];
    }

    /**
     * Run a raw prepared query and return all results
     */
    protected function query(string $sql, array $bindings = []): array
    {
        $stmt = $this->db()->prepare($sql);
        $stmt->execute($bindings);
        return $stmt->fetchAll();
    }

    /**
     * Run a raw prepared query and return one row
     */
    protected function queryOne(string $sql, array $bindings = []): ?array
    {
        $stmt = $this->db()->prepare($sql);
        $stmt->execute($bindings);
        return $stmt->fetch() ?: null;
    }

    /**
     * Run a raw statement (INSERT/UPDATE/DELETE)
     */
    protected function execute(string $sql, array $bindings = []): bool
    {
        $stmt = $this->db()->prepare($sql);
        return $stmt->execute($bindings);
    }
}
