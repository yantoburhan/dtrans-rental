<?php

/**
 * Router — URL parsing and controller dispatching
 * Supports route groups, middleware, and named parameters
 */
class Router
{
    private array $routes = [];
    private string $prefix = '';
    private array $middlewareStack = [];

    public function __construct()
    {
        require_once ROOT_PATH . '/routes/web.php';
    }

    // ----------------------------------------------------------------
    // Route registration helpers
    // ----------------------------------------------------------------

    public function get(string $uri, string|callable $action, array $middleware = []): void
    {
        $this->addRoute('GET', $uri, $action, $middleware);
    }

    public function post(string $uri, string|callable $action, array $middleware = []): void
    {
        $this->addRoute('POST', $uri, $action, $middleware);
    }

    public function group(array $options, callable $callback): void
    {
        $previousPrefix     = $this->prefix;
        $previousMiddleware = $this->middlewareStack;

        $this->prefix           .= $options['prefix'] ?? '';
        $this->middlewareStack   = array_merge($this->middlewareStack, $options['middleware'] ?? []);

        $callback($this);

        $this->prefix          = $previousPrefix;
        $this->middlewareStack = $previousMiddleware;
    }

    private function addRoute(string $method, string $uri, string|callable $action, array $middleware): void
    {
        $uri = $this->prefix . '/' . ltrim($uri, '/');
        $uri = rtrim($uri, '/') ?: '/';

        $this->routes[] = [
            'method'     => $method,
            'uri'        => $uri,
            'action'     => $action,
            'middleware' => array_merge($this->middlewareStack, $middleware),
        ];
    }

    // ----------------------------------------------------------------
    // Dispatch
    // ----------------------------------------------------------------

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri    = '/' . trim($_GET['url'] ?? '', '/');

        foreach ($this->routes as $route) {
            $pattern = $this->buildPattern($route['uri']);

            if ($route['method'] === $method && preg_match($pattern, $uri, $matches)) {
                // Extract named params
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                // Run middleware chain
                foreach ($route['middleware'] as $mw) {
                    $middlewareClass = ucfirst($mw) . 'Middleware';
                    (new $middlewareClass())->handle();
                }

                // Dispatch action
                $this->callAction($route['action'], array_values($params));
                return;
            }
        }

        // 404
        $this->callAction('ErrorController@notFound', []);
    }

    private function buildPattern(string $uri): string
    {
        $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $uri);
        return '#^' . $pattern . '$#';
    }

    private function callAction(string|callable $action, array $params): void
    {
        if (is_callable($action)) {
            call_user_func_array($action, $params);
            return;
        }

        [$controllerName, $method] = explode('@', $action);

        if (!class_exists($controllerName)) {
            throw new \RuntimeException("Controller [$controllerName] not found.");
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $method)) {
            throw new \RuntimeException("Method [$method] not found in [$controllerName].");
        }

        call_user_func_array([$controller, $method], $params);
    }
}
