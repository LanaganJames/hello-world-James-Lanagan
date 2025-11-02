<?php
namespace App\Core;

abstract class Controller
{
    protected array $config;
    public function __construct(array $config) { $this->config = $config; }

    // was: view(string $template, array $data = [])
    protected function render(string $template, array $data = []): void
    {
        View::render($template, $data);
    }

    protected function redirect(string $path): never
    {
        $base = rtrim($this->config['base_path'] ?? '', '/');
        $path = '/' . ltrim($path, '/');
        header('Location: ' . $base . $path);
        exit;
    }
}