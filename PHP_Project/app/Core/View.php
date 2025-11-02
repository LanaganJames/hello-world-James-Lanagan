<?php
namespace App\Core;
final class View {
public static function render(string $template, array $data = []): void
{
    extract($data);
    $cfg  = $GLOBALS['app_config'] ?? [];
    $base = rtrim($cfg['base_path'] ?? '', '/'); // <- available in views
    $templatePath = __DIR__ . '/../Views/' . $template . '.php';
    require __DIR__ . '/../Views/layout.php';
}
}
