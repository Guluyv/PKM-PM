<?php
namespace Controllers\Student;

use PDO;
use PDOException;
use Config\Database;

class ChatController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function index() {
        try {
            $userId = $_SESSION['user_id'];
            // Ubah query untuk menggunakan created_at sebagai alternatif
            $query = "SELECT c.*, u.username as counselor_name 
                     FROM chats c 
                     LEFT JOIN users u ON c.counselor_id = u.id 
                     WHERE c.student_id = :user_id 
                     ORDER BY c.created_at DESC";  // Menggunakan created_at
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":user_id", $userId);
            $stmt->execute();
            $chats = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $data = [
                'pageTitle' => 'Chat',
                'currentPage' => 'chat',
                'chats' => $chats
            ];

            require_once __DIR__ . '/../../Views/student/chat/index.php';
        } catch (PDOException $e) {
            error_log($e->getMessage());
            echo "Database Error: " . $e->getMessage();
        }
    }

    public function room($id = null) {
        try {
            if (!$id) {
                // Buat chat baru
                $id = $this->createNewChat();
                header('Location: ' . BASE_URL . '/student/chat/room/' . $id);
                exit;
            }

            // Ambil data chat dan pesan
            $chat = $this->getChat($id);
            $messages = $this->getChatMessages($id);

            $data = [
                'pageTitle' => 'Chat Room',
                'currentPage' => 'chat',
                'chat' => $chat,
                'messages' => $messages
            ];

            require_once __DIR__ . '/../../Views/student/chat/room.php';
        } catch (PDOException $e) {
            error_log($e->getMessage());
            echo "Error: " . $e->getMessage();
        }
    }

    public function sendMessage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $chatId = $_POST['chat_id'];
            $message = trim($_POST['message']);
            $senderId = $_SESSION['user_id'];

            try {
                $query = "INSERT INTO chat_messages (chat_id, sender_id, message) 
                         VALUES (:chat_id, :sender_id, :message)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':chat_id', $chatId);
                $stmt->bindParam(':sender_id', $senderId);
                $stmt->bindParam(':message', $message);

                if ($stmt->execute()) {
                    // Return success response for AJAX
                    echo json_encode([
                        'success' => true,
                        'message' => htmlspecialchars($message),
                        'timestamp' => date('Y-m-d H:i:s')
                    ]);
                } else {
                    echo json_encode(['success' => false]);
                }
            } catch (PDOException $e) {
                error_log($e->getMessage());
                echo json_encode(['success' => false]);
            }
            exit;
        }
    }

    private function getChat($id) {
        $query = "SELECT * FROM chats WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function getChatMessages($chatId) {
        $query = "SELECT cm.*, u.username 
                 FROM chat_messages cm
                 LEFT JOIN users u ON cm.sender_id = u.id
                 WHERE cm.chat_id = :chat_id 
                 ORDER BY cm.created_at ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":chat_id", $chatId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function createNewChat() {
        $query = "INSERT INTO chats (student_id, status) VALUES (:student_id, 'active')";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":student_id", $_SESSION['user_id']);
        $stmt->execute();
        return $this->db->lastInsertId();
    }
}