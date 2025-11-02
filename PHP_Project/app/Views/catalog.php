<h1>Catalog</h1>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>description</th>
            <th class="right">cost</th>
            <th class="right">in cart</th>
            <th>action</th>
        </tr>
    </thead>
<tbody>
    <?php foreach ($products as $p): ?>
    <tr>
        <td><?= (int)$p['id']; ?></td>
        <td><?= htmlspecialchars($p['name']); ?></td>
        <td><?= htmlspecialchars($p['description']); ?></td>
        <td class="right">$<?= number_format($p['price_cents'] / 100, 2); ?></td>
        <td class="right"><?= (int)$quantities[$p['id']] ?? 0; ?></td>
        <td>
            <form action="/cart/add" method="post" style="display:inline">
                <input type="hidden" name="id" value="<?= (int)$p['id']; ?>">
                <input type="hidden" name="qty" value="1">
                <button type="submit">Add</button>
            </form>

            <form action="/cart/update" method="post" style="display:inline">
                <input type="hidden" name="id" value="<?= (int)$p['id']; ?>">
                <input type="number" name="qty" min="0" value="<?= (int)$quantities[$p['id']] ?? 0; ?>">
                <button type="submit">Set Qty</button>
            </form>

            <form action="/cart/remove" method="post" style="display:inline">
                <input type="hidden" name="id" value="<?= (int)$p['id']; ?>">
                <button type="submit">Remove</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>
<p><a href="/cart">Go to Cart</a></p>
