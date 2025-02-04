<?php
namespace Models;

use PDO;
use PDOException;
use Config\Database;

class Chat {
    // Code remains the same...

    private $db;
    private $table = 'chats';

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function create($student_id) {
        try {
            $query = "INSERT INTO " . $this->table . " 
                     (student_id, status, is_anonymous) 
                     VALUES (:student_id, 'active', 1)";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":student_id", $student_id);

            return $stmt->execute() ? $this->db->lastInsertId() : false;
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getMessages($chat_id) {
        try {
            $query = "SELECT cm.*, u.username, u.role 
                     FROM chat_messages cm 
                     LEFT JOIN users u ON cm.sender_id = u.id 
                     WHERE cm.chat_id = :chat_id 
                     ORDER BY cm.created_at ASC";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":chat_id", $chat_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function sendMessage($chat_id, $sender_id, $message) {
        try {
            $query = "INSERT INTO chat_messages 
                     (chat_id, sender_id, message) 
                     VALUES (:chat_id, :sender_id, :message)";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":chat_id", $chat_id);
            $stmt->bindParam(":sender_id", $sender_id);
            $stmt->bindParam(":message", $message);

            return $stmt->execute();
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getUserChats($user_id, $role = 'student') {
        try {
            $query = "SELECT c.*, 
                     s.username as student_name, 
                     co.username as counselor_name,
                     (SELECT COUNT(*) FROM chat_messages 
                      WHERE chat_id = c.id AND is_read = 0) as unread_count
                     FROM " . $this->table . " c
                     LEFT JOIN users s ON c.student_id = s.id
                     LEFT JOIN users co ON c.counselor_id = co.id
                     WHERE " . ($role == 'student' ? "c.student_id = :user_id" : "c.counselor_id = :user_id") . "
                     ORDER BY c.updated_at DESC";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}