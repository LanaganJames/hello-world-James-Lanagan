<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Product;
use App\Models\Cart;
final class CartController extends Controller {
    private function ensureProduct(int $id): bool {
        return (new Product($this->config))->exists($id);
    }
    public function add(): void {
        $id = (int)($_POST['id'] ?? 0);
        $qty = max(0, (int)($_POST['qty'] ?? 1));
        if (!$this->ensureProduct($id)) { $_SESSION['flash'] = 'Invalid product.'; $this->redirect('/'); }
        (new Cart())->add($id, $qty);
        $_SESSION['flash'] = 'Item added to cart';
        $this->redirect('/');
    }
    public function remove(): void {
        $id = (int)($_POST['id'] ?? 0);
        (new Cart())->remove($id);
        $_SESSION['flash'] = 'Item removed';
        $this->redirect('/cart');
    }
    public function update(): void {
        $id = (int)($_POST['id'] ?? 0);
        $qty = max(0, (int)($_POST['qty'] ?? 0));
        if (!$this->ensureProduct($id)) { $_SESSION['flash'] = 'Invalid product.'; $this->redirect('/cart'); }
        (new Cart())->set($id, $qty);
        $_SESSION['flash'] = 'Quantity updated';
        $this->redirect('/cart');
    }
    public function view(): void {
        $productModel = new Product($this->config);
        $cart = new Cart();
        $items = $cart->items();
        $lines = [];
        $subtotal = 0;
        foreach ($items as $pid => $qty) {
            if ($qty < 1) continue;
            $p = $productModel->find((int)$pid);
            if (!$p) continue;
            $lineTotal = $p['price_cents'] * $qty;
            $subtotal += $lineTotal;
            $lines[] = [
                'id' => $p['id'],
                'name' => $p['name'],
                'qty' => $qty,
                'price_cents' => $p['price_cents'],
                'total_cents' => $lineTotal,
            ];
        }
        $tax = (int) round($subtotal * $this->config['tax_rate']);
        $ship = (int) round($subtotal * $this->config['ship_rate']);
        $grand = $subtotal + $tax + $ship;
        $this->render('cart', compact('lines', 'subtotal', 'tax', 'ship', 'grand'));

    }
    public function checkout(): void {
        (new Cart())->clear();
        $_SESSION['flash'] = 'Thank you! Your order has been placed.';
        $this->redirect('/');
    }
}