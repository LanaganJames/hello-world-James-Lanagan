<?php /* Basic layout wrapper */ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mini Shop</title>

    <style>
        body { font-family: system-ui, sans-serif; margin: 2rem; }
        header a { margin-right: 1rem; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: .5rem; text-align: left; }
        .right { text-align: right; }
        .flash { background: #e6ffed; border:1px solid #b7f5c4; padding:.75rem; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <header>
        <a href="/">Catalog</a>
        <a href="/cart">Cart</a>
    </header>
    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="flash"><?= htmlspecialchars($_SESSION['flash']); unset($_SESSION['flash']); ?></div>
    <?php endif; ?>
    <main>
        <?php require $templatePath; ?>
    </main>
</body>
</html>