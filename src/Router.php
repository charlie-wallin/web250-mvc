<?php

declare(strict_types=1);

namespace Web250\Mvc;

/**
 * ------------------------------------------------------------
 *  Tiny Router (Exact-Match Version)
 * ------------------------------------------------------------
 *  WHAT THIS DOES:
 *    • Let us register GET routes like $router->get('/', handler)
 *    • Match the current request path to a handler
 *    • Call the handler and echo its return value
 *
 *  WHAT THIS IS *NOT*:
 *    • A full framework router (no middleware, no named routes, etc.)
 *    • It only supports exact path matches for now (no /posts/{id} yet)
 */
final class Router
{
    /**
     * $routes will be an associative array that looks like:
     * [
     *   'GET' => [
     *       '/'      => callable,
     *       '/about' => callable,
     *   ]
     * ]
     */
    private array $routes = [];

    /**
     * Register a GET route.
     *
     * @param string   $path    Exact path (e.g., '/', '/about')
     * @param callable $handler Function that returns a string (HTML)
     */
    public function get(string $path, callable $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    /**
     * Dispatch the current request to the right handler.
     *
     * @param string $method HTTP method (e.g., 'GET')
     * @param string $path   URL path (e.g., '/about')
     */
    public function dispatch(string $method, string $path): void
    {
        // Look up a registered handler for this method/path.
        $handler = $this->routes[$method][$path] ?? null;

        if (!$handler) {
            // No match → 404
            http_response_code(404);
            echo '<h1>404 Not Found</h1>';
            echo '<p>No route registered for: ' . htmlspecialchars($path, ENT_QUOTES, 'UTF-8') . '</p>';
            return;
        }

        // Call the handler and echo the output. Handlers can be:
        // • an anonymous function (closure)
        // • [ControllerClassName::class, 'methodName']
        echo $handler();
    }
}
