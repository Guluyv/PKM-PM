<?php
namespace Controllers\Student;

use PDO;
use PDOException;
use Config\Database;
use Models\Content;

class HomeController {
    private $db;
    private $contentModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->contentModel = new Content();
    }

    public function index() {
        try {
            // Get latest content
            $latestContent = $this->getLatestContent();
            
            $data = [
                'pageTitle' => 'Home',
                'latestContent' => $latestContent
            ];

            // Ubah path ini
            require_once __DIR__ . '/../../Views/student/home.php';
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return ['error' => 'Terjadi kesalahan sistem'];
        }
    }

    private function getLatestContent() {
        try {
            $query = "SELECT * FROM educational_contents 
                     WHERE status = 'published' 
                     ORDER BY created_at DESC LIMIT 5";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }
}