<h1>Shopping Cart</h1>
<?php if (empty($lines)): ?>
    <p>Your cart is empty.</p>
    <p><a href="/catalog">Back to catalog</a></p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th class="right">Qty</th>
                <th class="right">Cost</th>
                <th class="right">Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
           <?php foreach ($lines as $ln): ?>
            <tr>
                <td><?= (int)$ln['id']; ?></td>
                <td><?= htmlspecialchars($ln['name']); ?></td>
                <td class="right"><?= (int)$ln['qty']; ?></td>
                <td class="right">$<?= number_format($ln['price_cents'] / 100, 2); ?></td>
                <td class="right">$<?= number_format($ln['total_cents'] / 100, 2); ?></td>
                <td>
                    <form action="/cart/update" method="post" style="display:inline">
                        <input type="hidden" name="id" value="<?= (int)$ln['id']; ?>">
                        <input type="number" name="qty" min="0" value="<?= (int)$ln['qty']; ?>" style="width:50px;">
                        <button type="submit">Set Qty</button>
                    </form>
                    <form action="/cart/remove" method="post" style="display:inline">
                        <input type="hidden" name="id" value="<?= (int)$ln['id']; ?>">
                        <button type="submit">Remove</button>
                    </form>
                </td>
            </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php
function money(int $c): string { return '$' . number_format($c/100, 2); }
?>
<table style="margin-top:1rem; width:auto">
  <tr><th style="text-align:left">Items Total</th><td class="right"><?= money($subtotal); ?></td></tr>
  <tr><th style="text-align:left">Tax (5%)</th><td class="right"><?= money($tax); ?></td></tr>
  <tr><th style="text-align:left">Shipping & Handling (10%)</th><td class="right"><?= money($ship); ?></td></tr>
  <tr><th style="text-align:left">Order Total</th><td class="right"><strong><?= money($grand); ?></strong></td></tr>
</table>
<p><a href="<?= $base ?>/">Continue shopping</a></p>
<form action="<?= $base ?>/checkout" method="post">
  <button type="submit">Check Out</button>
</form>
<?php endif; ?>