<?php
header('Content-Type: application/json');
require_once '../../config/config.php';
require_once '../../config/database.php';

use Models\Chat;
use Helpers\Auth;

$auth = new Auth();
$chatModel = new Chat();

// Rest of the code remains the same...

// Check if user is authenticated
if (!$auth->isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Get request method
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Get chat messages
        if (isset($_GET['chat_id'])) {
            $chat_id = filter_var($_GET['chat_id'], FILTER_SANITIZE_NUMBER_INT);
            $messages = $chatModel->getMessages($chat_id);
            echo json_encode([
                'success' => true,
                'data' => $messages
            ]);
        } else {
            // Get user's chat list
            $chats = $chatModel->getUserChats($_SESSION['user_id'], $_SESSION['role']);
            echo json_encode([
                'success' => true,
                'data' => $chats
            ]);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (isset($data['action'])) {
            switch ($data['action']) {
                case 'send':
                    if (!isset($data['chat_id']) || !isset($data['message'])) {
                        http_response_code(400);
                        echo json_encode(['error' => 'Missing required fields']);
                        exit;
                    }

                    $result = $chatModel->sendMessage(
                        $data['chat_id'],
                        $_SESSION['user_id'],
                        $data['message']
                    );

                    echo json_encode([
                        'success' => $result,
                        'data' => [
                            'chat_id' => $data['chat_id'],
                            'sender_id' => $_SESSION['user_id'],
                            'message' => $data['message'],
                            'created_at' => date('Y-m-d H:i:s')
                        ]
                    ]);
                    break;

                case 'create':
                    $chat_id = $chatModel->create($_SESSION['user_id']);
                    echo json_encode([
                        'success' => true,
                        'data' => ['chat_id' => $chat_id]
                    ]);
                    break;

                default:
                    http_response_code(400);
                    echo json_encode(['error' => 'Invalid action']);
                    break;
            }
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
}