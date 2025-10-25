<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Product;
use App\Models\Cart;
final class CatalogController extends Controller {
    public function index(): void {
        $productModel = new Product($this->config);
        $cart = new Cart();
        $products = $productModel->a; 
        $quantities = [];
        foreach ($products as $p) {
            $quantities[$p['id']] = $cart->qty((int)$p['id']);
        }
        $this->view('catalog', compact('products', 'quantities'));
    }
}