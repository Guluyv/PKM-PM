<?php
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../src/Helpers/Auth.php';
require_once '../src/Controllers/Auth/LoginController.php';
require_once '../src/Controllers/Auth/RegisterController.php';

// Initialize controllers
$auth = new Auth();
$loginController = new LoginController();
$registerController = new RegisterController();

// Parse URL
$request = $_SERVER['REQUEST_URI'];
$basePath = '/ceritayuk';
$request = str_replace($basePath, '', $request);

// Basic routing
switch ($request) {
    case '':
    case '/':
        if ($auth->isLoggedIn()) {
            header('Location: ' . BASE_URL . ($auth->isAdmin() ? '/admin/dashboard' : '/student/home'));
            exit;
        }
        header('Location: ' . BASE_URL . '/login');
        break;

    case '/login':
        if ($auth->isLoggedIn()) {
            header('Location: ' . BASE_URL . ($auth->isAdmin() ? '/admin/dashboard' : '/student/home'));
            exit;
        }
        $loginController->login();
        break;

    case '/register':
        if ($auth->isLoggedIn()) {
            header('Location: ' . BASE_URL . ($auth->isAdmin() ? '/admin/dashboard' : '/student/home'));
            exit;
        }
        $registerController->register();
        break;

    case '/logout':
        $loginController->logout();
        break;

    // ... rest of your routes
}