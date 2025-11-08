<?php
namespace App\Core;
final class Router {
    private array $routes = ['GET' => [], 'POST' => []];
    public function __construct(private array $config) {}
    public function get(string $path, callable|array $handler): void { $this->routes['GET'][$path] = $handler; }
    public function post(string $path, callable|array $handler): void { $this->routes['POST'][$path] = $handler; }
public function dispatch(string $method, string $uri): void
{
    // 1) get the raw path from the URL
    $path = parse_url($uri, PHP_URL_PATH) ?? '/';

    // 2) strip your subdirectory base (/ecpi/public) if present
    $base = rtrim($this->config['base_path'] ?? '', '/');
    if ($base !== '' && strpos($path, $base) === 0) {
        $path = substr($path, strlen($base));
    } else {
        // fallback: strip script directory if app runs in a subfolder
        $scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
        if ($scriptDir !== '' && strpos($path, $scriptDir) === 0) {
            $path = substr($path, strlen($scriptDir));
        }
    }

    // 3) tidy slashes and handle direct /index.php hits
    $path = '/' . ltrim($path, '/');
    if ($path === '/index.php') { $path = '/'; }
    if ($path !== '/' && substr($path, -1) === '/') { $path = rtrim($path, '/'); }

    // 4) route it
    $handler = $this->routes[$method][$path] ?? null;
    if (!$handler) { http_response_code(404); echo 'Not Found'; return; }

    if (is_array($handler)) {
        [$class, $methodName] = $handler;
        $controller = new $class($this->config);
        $controller->$methodName();
    } else {
        $handler();
    }
}

}
