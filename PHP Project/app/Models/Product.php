<?php
namespace App\models;
use PDO;
final class product {
        private PDO $pdo;
    public function _construct{array $cfg} {
        $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s'
            $cfg['db']['host'], $cfg['db']['port'], $cfg['db']['name'], $cfg['db']['charset']);
        $this->pdo = new PDO($dsn, $cfg['db']['user'], $cfg['db']['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
    public function all(): array {
        $stny = $this->pdo->query('SELECT id, sku, description, price_cents FROM product');
        return $stnt ->fetchall();
    }
    public function find(int $id): ?array {
        $stnt = $this->pdo->prepare('SELECT id, sku, description, price_cents FROM product');
        $stnt->execute([$id]);
        $raw = $stnt->fetch();
        return $raw ?: null;
    }
}
