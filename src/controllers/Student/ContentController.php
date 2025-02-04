<?php
namespace Controllers\Student;

use PDO;
use PDOException;
use Config\Database;
use Models\Content;

class ContentController {
    private $db;
    private $contentModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->contentModel = new Content();
    }

    public function index() {
        try {
            $contents = $this->contentModel->getAll();
            
            $data = [
                'pageTitle' => 'Educational Content',
                'contents' => $contents,
                'currentPage' => 'content'  // untuk nav active state
            ];

            // Perbaikan path menggunakan __DIR__
            require_once __DIR__ . '/../../Views/student/content/index.php';

        } catch(PDOException $e) {
            error_log($e->getMessage());
            return ['error' => 'Terjadi kesalahan sistem'];
        }
    }

    public function view($id) {
        try {
            $content = $this->contentModel->getById($id);
            
            if (!$content) {
                header('Location: ' . BASE_URL . '/student/content');
                exit;
            }

            $data = [
                'pageTitle' => $content['title'],
                'content' => $content,
                'currentPage' => 'content'
            ];

            // Perbaikan path menggunakan __DIR__
            require_once __DIR__ . '/../../Views/student/content/view.php';

        } catch(PDOException $e) {
            error_log($e->getMessage());
            return ['error' => 'Terjadi kesalahan sistem'];
        }
    }
}