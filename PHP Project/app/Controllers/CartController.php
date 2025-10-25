<?php

final class CartController extends Controller {

    public function update() : void {
        $id = (int)($_POST['id'] ?? 0);
        $qty = max(0, (int)($_POST['qty'] ?? 0));
        (new Cart())->set($id, $qty);
        $this->redirect('/cart');
    }

    public function show() : void {
        $productModel = new Product($this->config);
        $cart = new Cart();
        $items = $cart->items;
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
                'total' => $lineTotal
            ];
        }

        $tax = (int) round($subtotal * $this->config['tax_rate']);
        $ship = (int) round($subtotal * $this->config['ship_rate']);
        $grand = $subtotal + $tax + $ship;

        $this->view('cart', compact('lines', 'subtotal', 'tax', 'ship', 'grand'));
    }

    public function checkout() : void {
        (new Cart())->clear();
        $_SESSION['flash'] = 'Thank you! Your order has been placed.';
        $this->redirect('/');
    }
}
