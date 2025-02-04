<?php
namespace Controllers\Admin;

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
                'pageTitle' => 'Content Management',
                'contents' => $contents
            ];

            require_once 'src/Views/admin/content/index.php';
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return ['error' => 'Terjadi kesalahan sistem'];
        }
    }

    public function edit($id) {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'title' => $_POST['title'],
                    'description' => $_POST['description'],
                    'content_type' => $_POST['content_type'],
                    'content' => $_POST['content'],
                    'status' => $_POST['status']
                ];

                // Handle thumbnail upload
                if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === 0) {
                    $thumbnail = $this->handleFileUpload($_FILES['thumbnail']);
                    if ($thumbnail) {
                        $data['thumbnail'] = $thumbnail;
                    }
                }

                if ($this->contentModel->update($id, $data)) {
                    header('Location: ' . BASE_URL . '/admin/content');
                    exit;
                }
            }

            $content = $this->contentModel->getById($id);
            
            $data = [
                'pageTitle' => 'Edit Content',
                'content' => $content
            ];

            require_once 'src/Views/admin/content/edit.php';
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return ['error' => 'Terjadi kesalahan sistem'];
        }
    }

    public function create() {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'title' => $_POST['title'],
                    'description' => $_POST['description'],
                    'content_type' => $_POST['content_type'],
                    'content' => $_POST['content'],
                    'status' => $_POST['status'],
                    'created_by' => $_SESSION['user_id']
                ];

                // Handle thumbnail upload
                if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === 0) {
                    $thumbnail = $this->handleFileUpload($_FILES['thumbnail']);
                    if ($thumbnail) {
                        $data['thumbnail'] = $thumbnail;
                    }
                }

                if ($this->contentModel->create($data)) {
                    header('Location: ' . BASE_URL . '/admin/content');
                    exit;
                }
            }

            $data = [
                'pageTitle' => 'Create Content'
            ];

            require_once 'src/Views/admin/content/create.php';
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return ['error' => 'Terjadi kesalahan sistem'];
        }
    }

    private function handleFileUpload($file) {
        $uploadDir = 'public/assets/images/content/';
        $uploadPath = $uploadDir . basename($file['name']);
        
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return basename($file['name']);
        }
        return false;
    }

    public function delete($id) {
        try {
            if ($this->contentModel->delete($id)) {
                header('Location: ' . BASE_URL . '/admin/content');
                exit;
            }
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return ['error' => 'Terjadi kesalahan sistem'];
        }
    }
}