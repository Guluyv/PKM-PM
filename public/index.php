<?php
// Error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../config/config.php';

// Debug: Print current path
echo "Current Path: " . $_SERVER['REQUEST_URI'] . "<br>";
// echo "Current Path: " . $_SERVER['REQUEST_URI'];

use Config\Database;
use Helpers\Auth;
use Controllers\Auth\LoginController;
use Controllers\Auth\RegisterController;
use Controllers\Student\HomeController;
use Controllers\Student\ChatController;
use Controllers\Student\ContentController as StudentContentController;
use Controllers\Admin\DashboardController;
use Controllers\Admin\UserController;
use Controllers\Admin\ContentController as AdminContentController;

try {
    // Initialize controllers
    $auth = new Auth();
    $loginController = new LoginController();
    $registerController = new RegisterController();
    $studentHomeController = new HomeController();
    $studentChatController = new ChatController();
    $studentContentController = new StudentContentController();
    $adminDashboardController = new DashboardController();
    $adminUserController = new UserController();
    $adminContentController = new AdminContentController();

    // Parse URL
    $request = $_SERVER['REQUEST_URI'];
    
    // Debug
    // echo "Original Request: " . $request . "<br>";

    // Remove base folder from the request
    $basePath = '/ceritainaja';
    $request = str_replace($basePath, '', $request);

    // Debug
    // echo "After base removal: " . $request . "<br>";

    // Handle empty request (root URL)
    if (empty($request) || $request == '/') {
        if ($auth->isLoggedIn()) {
            header('Location: ' . BASE_URL . ($auth->isAdmin() ? '/admin/dashboard' : '/student/home'));
            exit;
        }
        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    // Handle query strings
    $requestParts = explode('?', $request);
    $path = $requestParts[0];

    // Normalize path
    $path = rtrim($path, '/');

    // Basic routing
    switch ($path) {
        // Public Routes
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

        // Student Routes
        case '/student/home':
            if (!$auth->isLoggedIn()) {
                header('Location: ' . BASE_URL . '/login');
                exit;
            }
            $studentHomeController->index();
            break;

    case '/student/chat':
        if (!$auth->isLoggedIn()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        $studentChatController->index();
        break;

    case '/student/chat/room':
        if (!$auth->isLoggedIn()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        $studentChatController->room();
        break;

    case strpos($path, '/student/chat/room/') === 0:
        if (!$auth->isLoggedIn()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        $id = substr($path, strrpos($path, '/') + 1);
        $studentChatController->room($id);
        break;

    case '/student/content':
        if (!$auth->isLoggedIn()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        $studentContentController->index();
        break;

    case strpos($path, '/student/content/view/') === 0:
        if (!$auth->isLoggedIn()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        $id = substr($path, strrpos($path, '/') + 1);
        $studentContentController->view($id);
        break;

        // ... di dalam switch case ...
case '/api/chat/send':
    if (!$auth->isLoggedIn()) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }
    $chatController->sendMessage();
    break;

    // Admin Routes
    case '/admin/dashboard':
        if (!$auth->isLoggedIn() || !$auth->isAdmin()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        $adminDashboardController->index();
        break;

    case '/admin/users':
        if (!$auth->isLoggedIn() || !$auth->isAdmin()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        $adminUserController->index();
        break;

    case strpos($path, '/admin/users/edit/') === 0:
        if (!$auth->isLoggedIn() || !$auth->isAdmin()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        $id = substr($path, strrpos($path, '/') + 1);
        $adminUserController->edit($id);
        break;

    case '/admin/content':
        if (!$auth->isLoggedIn() || !$auth->isAdmin()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        $adminContentController->index();
        break;

    case strpos($path, '/admin/content/edit/') === 0:
        if (!$auth->isLoggedIn() || !$auth->isAdmin()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        $id = substr($path, strrpos($path, '/') + 1);
        $adminContentController->edit($id);
        break;

    // API Routes for Chat
    case '/api/chat/send':
        if (!$auth->isLoggedIn()) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        $studentChatController->sendMessage();
        break;

    
    // 404 Route
    default:
    http_response_code(404);
    require_once '../src/Views/404.php';
    break;
}
} catch (Exception $e) {
// Log error
error_log($e->getMessage());

// Show error page in development
if (true) {  // Change to environment check later
echo "<h1>Error</h1>";
echo "<pre>";
echo $e->getMessage();
echo "\n\nStack Trace:\n";
echo $e->getTraceAsString();
echo "</pre>";
} else {
// Show friendly error in production
http_response_code(500);
require_once '../src/Views/500.php';
}
}