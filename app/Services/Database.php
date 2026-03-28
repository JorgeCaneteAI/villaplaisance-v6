<?php
declare(strict_types=1);

class Database
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=utf8mb4',
                $_ENV['DB_HOST'] ?? 'localhost',
                $_ENV['DB_NAME'] ?? ''
            );
            self::$instance = new PDO($dsn, $_ENV['DB_USER'] ?? '', $_ENV['DB_PASS'] ?? '', [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        }
        return self::$instance;
    }

    public static function query(string $sql, array $params = []): \PDOStatement
    {
        $stmt = self::getInstance()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public static function fetchAll(string $sql, array $params = []): array
    {
        return self::query($sql, $params)->fetchAll();
    }

    public static function fetchOne(string $sql, array $params = []): array|false
    {
        return self::query($sql, $params)->fetch();
    }

    public static function insert(string $table, array $data): int
    {
        $cols = implode(', ', array_keys($data));
        $vals = implode(', ', array_fill(0, count($data), '?'));
        self::query("INSERT INTO {$table} ({$cols}) VALUES ({$vals})", array_values($data));
        return (int)self::getInstance()->lastInsertId();
    }

    public static function update(string $table, array $data, string $where, array $whereParams = []): void
    {
        $set = implode(', ', array_map(fn($k) => "{$k} = ?", array_keys($data)));
        self::query("UPDATE {$table} SET {$set} WHERE {$where}", [...array_values($data), ...$whereParams]);
    }

    public static function delete(string $table, string $where, array $params = []): void
    {
        self::query("DELETE FROM {$table} WHERE {$where}", $params);
    }
}
