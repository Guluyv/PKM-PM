<?php
namespace Controllers\Admin;

use PDO;
use PDOException;
use Config\Database;
use Models\User;
use Models\Content;
use Models\Chat;

class DashboardController {
    private $userModel;
    private $contentModel;
    private $chatModel;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        
        $this->userModel = new User();
        $this->contentModel = new Content();
        $this->chatModel = new Chat();
    }

    public function index() {
        try {
            // Get statistics for dashboard
            $stats = [
                'totalStudents' => $this->getTotalStudents(),
                'totalContent' => $this->getTotalContent(),
                'activeChats' => $this->getActiveChats()
            ];

            $data = [
                'pageTitle' => 'Admin Dashboard',
                'stats' => $stats
            ];

            require_once 'src/Views/admin/dashboard/index.php';
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return ['error' => 'Terjadi kesalahan sistem'];
        }
    }

    private function getTotalStudents() {
        try {
            $query = "SELECT COUNT(*) as total FROM users WHERE role = 'student'";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return 0;
        }
    }

    private function getTotalContent() {
        try {
            $query = "SELECT COUNT(*) as total FROM educational_contents";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return 0;
        }
    }

    private function getActiveChats() {
        try {
            $query = "SELECT COUNT(*) as total FROM chats WHERE status = 'active'";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return 0;
        }
    }
}