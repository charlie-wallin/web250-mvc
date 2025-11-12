<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Web250\Mvc\Controllers\HomeController;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

if ($path === '/' || $path === '/home') {
    echo (new HomeController())->index();
} else {
    http_response_code(404);
    echo 'Not Found';
}
