<?php
namespace App\Models;
final class Cart {
    public function items(): array { return $_SESSION['cart'] ?? []; }
    public function qty(int $productId): int { 
        $items = $this->items(); 
        return (int) ($items[$productId] ?? 0); 
    }
    public function add(int $productId, int $qty = 1): void {
        $qty = max(0, $qty);
        $_SESSION['cart'][$productId] = $this->qty($productId) + $qty;
    }
    public function set(int $productId, int $qty): void {
        $qty = max(0, $qty);
        if ($qty === 0) { 
            unset($_SESSION['cart'][$productId]); 
            return; 
        }
        $_SESSION['cart'][$productId] = $qty;
    }
    public function remove(int $productId): void { 
        unset($_SESSION['cart'][$productId]); 
    }
    public function clear(): void { 
        unset($_SESSION['cart']); 
    }
}