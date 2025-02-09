<?php

namespace App\Models;

use PDO;

class ChatMessage {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }
    
    public function save($chatId, $senderId, $message) {
        $query = "INSERT INTO chat_messages (chat_id, sender_id, message, created_at) 
                 VALUES (:chat_id, :sender_id, :message, NOW())";
                 
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':chat_id', $chatId);
        $stmt->bindParam(':sender_id', $senderId);
        $stmt->bindParam(':message', $message);
        
        return $stmt->execute();
    }
    
    public function markAsRead($messageId, $userId) {
        $query = "UPDATE chat_messages 
                 SET is_read = 1 
                 WHERE id = :id AND sender_id != :user_id";
                 
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $messageId); 
        $stmt->bindParam(':user_id', $userId);
        
        return $stmt->execute();
    }
}