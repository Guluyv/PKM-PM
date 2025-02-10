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
            // Get all contents and group them by type
            $query = "SELECT * FROM educational_contents WHERE status = 'published' ORDER BY created_at DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $contents = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Group contents by type
            $groupedContents = [
                'video' => [],
                'article' => [],
                'infographic' => []
            ];

            foreach ($contents as $content) {
                $groupedContents[$content['content_type']][] = $content;
            }
            
            $data = [
                'pageTitle' => 'Materi Edukasi',
                'contents' => $contents,
                'groupedContents' => $groupedContents,
                'currentPage' => 'content'
            ];

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

            // Get read time for articles (assume 200 words per minute)
            if ($content['content_type'] === 'article') {
                $wordCount = str_word_count(strip_tags($content['content']));
                $readTime = ceil($wordCount / 200);
                $content['read_time'] = $readTime;
            }

            $data = [
                'pageTitle' => $content['title'],
                'content' => $content,
                'currentPage' => 'content'
            ];

            require_once __DIR__ . '/../../Views/student/content/view.php';

        } catch(PDOException $e) {
            error_log($e->getMessage());
            return ['error' => 'Terjadi kesalahan sistem'];
        }
    }
}