<?php

// public/index.php
//
// This is the FRONT CONTROLLER.
// Every request from the browser comes to this file first.
// It will:
//  1. Turn on error reporting (for development).
//  2. Load the Router and the Controller class.
//  3. Register routes (which URL → which action).
//  4. Ask the router to dispatch the current request.

declare(strict_types=1);

use Dotenv\Dotenv;
use Web250\Mvc\Router;
use Web250\Mvc\Controllers\HomeController;

// Show errors while we are learning (in production, this should be turned off)
ini_set('display_errors', '1');
error_reporting(E_ALL);

// Load the SalamanderController class (not namespaced yet)
require_once __DIR__ . '/../src/Controllers/SalamanderController.php';
require __DIR__ . '/../vendor/autoload.php';


// --- NEW: load .env variables ---
$dotenv = Dotenv::createImmutable(dirname(__DIR__)); // project root
$dotenv->load();
// Now DB_HOST, DB_NAME, etc. are available in $_ENV / $_SERVER

// Create a Router instance
$router = new Router();

// Register a route for the home page ("/")
$router->get('/', function () {
    // This callback is called when the browser requests "/"
    $controller = new HomeController();
    echo $controller->index();
});

// Register a route for "/salamanders"
$router->get('/salamanders', function () {
    $controller = new SalamanderController();
    $controller->index();
});

// HomeController routes
$router->get('/home', function () {
    $controller = new HomeController();
    echo $controller->index();
});
$router->get('/about', function () {
    $controller = new HomeController();
    echo $controller->about();
});

// Figure out which path the user requested, ignoring the query string
// Example: "/salamanders?page=2" becomes "/salamanders"
$uriPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Ask the router to handle (dispatch) this request
$router->dispatch($uriPath, $_SERVER['REQUEST_METHOD']);
