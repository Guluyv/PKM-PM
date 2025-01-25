<?php
require_once '../config/config.php';
require_once '../config/database.php';

// Simple routing
$request = $_SERVER['REQUEST_URI'];
$basePath = '/ceritayuk';
$request = str_replace($basePath, '', $request);

switch ($request) {
    case '':
    case '/':
        require __DIR__ . '/../src/Views/auth/login.php';
        break;
    case '/login':
        require __DIR__ . '/../src/Views/auth/login.php';
        break;
    case '/register':
        require __DIR__ . '/../src/Views/auth/register.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/../src/Views/404.php';
        break;
}