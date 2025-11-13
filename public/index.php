<?php

/**
 * -------------------------------------------------------------------------
 *  WEB250 MVC — Front Controller (with router and subfolder support)
 * -------------------------------------------------------------------------
 *  This is the single entry point for every web request.
 *  It:
 *   • Turns on error reporting for development.
 *   • Loads Composer’s autoloader (so all our classes work automatically).
 *   • Creates a Router and registers routes (URLs → handlers).
 *   • Figures out which route the browser requested.
 *   • Asks the Router to "dispatch" the request (find and run the handler).
 *
 *  NOTE:
 *   - This version works even if your project lives in a subfolder
 *     like /web250-mvc or /projects/mvc-app.
 *   - The goal is to handle routes like "/", "/home", "/about"
 *     cleanly no matter where the app is hosted.
 */

declare(strict_types=1); // Enforce strict typing for cleaner, safer code.

// -------------------------------------------------------------------------
// 1. DEVELOPMENT ERROR SETTINGS
// -------------------------------------------------------------------------
// Show *all* errors in the browser while developing.
// NEVER leave these lines on in production! They expose sensitive info.
ini_set('display_errors', '1');          // Display runtime errors.
ini_set('display_startup_errors', '1');  // Display startup/config errors.
error_reporting(E_ALL);                  // Report every possible error level.

// -------------------------------------------------------------------------
// 2. LOAD COMPOSER AUTOLOADER
// -------------------------------------------------------------------------
// Composer creates "vendor/autoload.php" automatically after `composer install`.
// This file knows how to load all our PHP classes using the PSR-4 mapping
// defined in composer.json (for example, Web250\Mvc\ → src/).
require __DIR__ . '/../vendor/autoload.php';

// -------------------------------------------------------------------------
// 3. IMPORT CLASSES WE'LL USE
// -------------------------------------------------------------------------
// The "use" statements import classes into this file’s namespace
// so we don’t have to write long fully-qualified names every time.
use Web250\Mvc\Router;
use Web250\Mvc\Controllers\HomeController;

// -------------------------------------------------------------------------
// 4. CREATE AND CONFIGURE THE ROUTER
// -------------------------------------------------------------------------
// The Router holds a list of all valid URLs (routes) and their handlers.
// Each handler is a callable (function) that returns HTML to send to the browser.
$router = new Router();

/**
 * Route: GET /
 * Handler: HomeController::index()
 * --------------------------------
 * When the visitor goes to the site root ("/"),
 * create a HomeController object and call its index() method.
 * The method returns an HTML string, which the router will echo.
 */
$router->get('/', fn() => (new HomeController())->index());

/**
 * Route: GET /home
 * Handler: same as "/"
 * --------------------------------
 * Some users type "/home" out of habit. This makes both URLs work.
 */
$router->get('/home', fn() => (new HomeController())->index());

/**
 * Route: GET /about
 * Handler: simple anonymous function (no controller)
 * --------------------------------
 * This shows that not every route needs a controller.
 * The router will echo this HTML directly.
 */
$router->get(
    '/about',
    fn() =>
    '<h1>About</h1><p>This route is handled by a closure.</p>'
);

// -------------------------------------------------------------------------
// 5. DETERMINE THE CURRENT REQUEST METHOD AND PATH
// -------------------------------------------------------------------------

// The HTTP method (GET, POST, etc.)
// If missing, assume GET (typical for browser requests).
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// The full request URI (example: "/web250-mvc/about?foo=bar")
// We only want the path part before any "?" query string.
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';

// Determine where our public folder sits relative to the domain.
// Example: if SCRIPT_NAME = "/web250-mvc/public/index.php",
// then dirname(...) gives "/web250-mvc/public".
$base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');

// Remove that base prefix from the URI so that:
//    "/web250-mvc/about" → "/about"
//    "/web250-mvc/"      → "/"
//
// This keeps our route definitions simple — we only register "/about", not
// "/web250-mvc/about".
$path = '/' . ltrim(
    preg_replace('#^' . preg_quote($base, '#') . '#', '', $uri),
    '/'
);

// Occasionally this creates a double slash ("//") when the path was exactly "/"
// so we normalize it back to a single slash.
if ($path === '//') {
    $path = '/';
}

// -------------------------------------------------------------------------
// 6. ASK THE ROUTER TO HANDLE THE REQUEST
// -------------------------------------------------------------------------
// The router looks up a registered route for the given method/path
// and calls its handler. If no route matches, it returns a 404 page.
$router->dispatch($method, $path);

// -------------------------------------------------------------------------
// END OF FILE
// -------------------------------------------------------------------------
