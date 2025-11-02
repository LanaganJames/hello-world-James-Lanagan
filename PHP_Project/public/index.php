<?php
declare(strict_types=1);
session_start();
require __DIR__ . '/../app/Core/Router.php';
require __DIR__ . '/../app/Core/Controller.php';
require __DIR__ . '/../app/Core/View.php';
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/../app/';           // maps App\* to /app/*
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;   // ignore other namespaces
    $relative = substr($class, $len);                   // e.g. Controllers\CatalogController
    $file = $baseDir . str_replace('\\', '/', $relative) . '.php';
    if (is_file($file)) require $file;
});
$config = require __DIR__ . '/../config/config.php';
$GLOBALS['app_config'] = $config; // make config available to views
$router = new App\Core\Router($config);

$router->get('/', [App\Controllers\CatalogController::class, 'index']);
$router->get('/index.php', [App\Controllers\CatalogController::class, 'index']);

$router->post('/cart/add', [App\Controllers\CartController::class, 'add']);

$router->post('/cart/remove', [App\Controllers\CartController::class, 'remove']);

$router->post('/cart/update', [App\Controllers\CartController::class, 'update']);

$router->get('/cart', [App\Controllers\CartController::class, 'view']);

$router->post('/checkout', [App\Controllers\CartController::class, 'checkout']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
