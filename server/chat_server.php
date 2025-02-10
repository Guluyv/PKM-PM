<?php
require __DIR__ . '/../vendor/autoload.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Factory;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Config\Database;


class ChatServer implements MessageComponentInterface {
    protected $clients;
    protected $chatSessions;
    protected $db;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->chatSessions = [];
        
        // Inisialisasi koneksi database
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function onOpen(ConnectionInterface $conn) {
        // Dapatkan query parameters dari request
        $query = $conn->httpRequest->getUri()->getQuery();
        parse_str($query, $params);
        
        // Validasi token dan chat_id
        if (!isset($params['token']) || !isset($params['chat_id'])) {
            $conn->close();
            return;
        }

        // Simpan informasi user pada koneksi
        $conn->chat_id = $params['chat_id'];
        $conn->user_id = $this->getUserFromToken($params['token']);
        
        // Tambahkan ke daftar klien
        $this->clients->attach($conn);
        
        // Update status user menjadi online
        $this->updateUserStatus($conn->user_id, true);
        
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);
        
        // Validasi format pesan
        if (!$this->validateMessage($data)) {
            return;
        }

        // Simpan pesan ke database
        $this->saveMessage($data);
        
        // Broadcast pesan ke semua client dalam chat yang sama
        foreach ($this->clients as $client) {
            if ($data['chat_id'] === $client->chat_id) {
                $client->send(json_encode([
                    'type' => 'message',
                    'message' => htmlspecialchars($data['message']),
                    'sender_id' => $data['sender_id'],
                    'timestamp' => date('Y-m-d H:i:s')
                ]));
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // Update status user menjadi offline
        if (isset($conn->user_id)) {
            $this->updateUserStatus($conn->user_id, false);
        }
        
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    private function getUserFromToken($token) {
        // Implementasi validasi token dan mendapatkan user_id
        try {
            $stmt = $this->db->prepare("SELECT user_id FROM sessions WHERE token = ?");
            $stmt->execute([$token]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['user_id'] : null;
        } catch (\Exception $e) {
            echo "Error validating token: {$e->getMessage()}\n";
            return null;
        }
    }

    private function validateMessage($data) {
        return isset($data['type']) && 
               isset($data['chat_id']) && 
               isset($data['sender_id']) && 
               isset($data['message']) &&
               !empty(trim($data['message']));
    }

    private function saveMessage($data) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO chat_messages (chat_id, sender_id, message) 
                VALUES (?, ?, ?)
            ");
            $stmt->execute([
                $data['chat_id'],
                $data['sender_id'],
                $data['message']
            ]);
        } catch (\Exception $e) {
            echo "Error saving message: {$e->getMessage()}\n";
        }
    }

    private function updateUserStatus($userId, $isOnline) {
        try {
            $stmt = $this->db->prepare("
                UPDATE users 
                SET is_online = ?, last_active = CURRENT_TIMESTAMP 
                WHERE id = ?
            ");
            $stmt->execute([$isOnline ? 1 : 0, $userId]);
        } catch (\Exception $e) {
            echo "Error updating user status: {$e->getMessage()}\n";
        }
    }
}

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new ChatServer()
        )
    ),
    8080
);

$server->run();