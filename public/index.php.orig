<?php

/**
 * ------------------------------------------------------------
 *  Web250 MVC - Public Front Controller (with Router)
 * ------------------------------------------------------------
 */

declare(strict_types=1);

// DEV-ONLY error display (remove in production)
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Composer autoloader (knows Web250\Mvc\ → src/)
require __DIR__ . '/../vendor/autoload.php';

// Import the classes we’ll use
use Web250\Mvc\Router;
use Web250\Mvc\Controllers\HomeController;

// ------------------------------------------------------------
// 1) Create the Router and register routes
// ------------------------------------------------------------
$router = new Router();

/**
 * Route: GET /
 * Handler: HomeController::index
 *
 * We pass a callable that, when invoked, will instantiate the controller
 * and return the HTML string produced by its index() method.
 */
$router->get('/', function () {
    return (new HomeController())->index();
});

/**
 * Optional: map '/home' to the same handler so both URLs work.
 */
$router->get('/home', function () {
    return (new HomeController())->index();
});

/**
 * Example of a very simple static route. This shows you can route to a closure
 * directly (no controller needed) for quick demos.
 */
$router->get('/about', function () {
    return '<h1>About</h1><p>This route is handled by a closure.</p>';
});

// ------------------------------------------------------------
// 2) Extract the HTTP method and path from the request
// ------------------------------------------------------------
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// parse_url() strips off any query string (?page=2)
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

// ------------------------------------------------------------
// 3) Ask the Router to dispatch the request
// ------------------------------------------------------------
$router->dispatch($method, $path);
