<?php
namespace App\Models;
use PDO;
final class Product {
    private PDO $pdo;
    public function __construct(array $cfg) {
        $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $cfg['db']['host'], $cfg['db']['port'], $cfg['db']['name'], $cfg['db']['charset']);
        $this->pdo = new PDO($dsn, $cfg['db']['user'], $cfg['db']['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
    public function all(): array {
        $stmt = $this->pdo->query('SELECT id, sku, name, description, price_cents FROM products ORDER BY id');
        return $stmt->fetchAll();
    }
    public function find(int $id): ?array {
        $stmt = $this->pdo->prepare('SELECT id, sku, name, description, price_cents FROM products WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
    public function exists(int $id): bool {
        $stmt = $this->pdo->prepare('SELECT 1 FROM products WHERE id = ?');
        $stmt->execute([$id]);
        return (bool) $stmt->fetchColumn();
    }
}

