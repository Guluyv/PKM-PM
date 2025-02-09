<?php
namespace Controllers\API;

use PDO;
use PDOException;
use Models\Chat;

class ChatController {
    private $chatModel;

    public function __construct() {
        $this->chatModel = new Chat();
    }

    public function send() {
        try {
            $chatId = $_POST['chat_id'];
            $message = trim($_POST['message']);
            $senderId = $_SESSION['user_id'];

            if (empty($message)) {
                return $this->jsonResponse(['error' => 'Message cannot be empty'], 400);
            }

            $result = $this->chatModel->sendMessage($chatId, $senderId, $message);
            
            if ($result) {
                return $this->jsonResponse([
                    'success' => true,
                    'message' => htmlspecialchars($message),
                    'timestamp' => date('Y-m-d H:i:s')
                ]);
            }

            return $this->jsonResponse(['error' => 'Failed to send message'], 500);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return $this->jsonResponse(['error' => 'Server error'], 500);
        }
    }

    public function getMessages($chatId) {
        try {
            $lastId = $_GET['last_id'] ?? 0;
            $messages = $this->chatModel->getNewMessages($chatId, $lastId);
            
            return $this->jsonResponse([
                'success' => true,
                'messages' => $messages
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return $this->jsonResponse(['error' => 'Server error'], 500);
        }
    }

    private function jsonResponse($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}