<?php
namespace Controllers\Admin;

use PDO;
use PDOException;
use Config\Database;
use Models\User;

class UserController {
    private $db;
    private $userModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->userModel = new User();
    }

    public function index() {
        try {
            $query = "SELECT * FROM users ORDER BY created_at DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $data = [
                'pageTitle' => 'User Management',
                'users' => $users
            ];

            require_once 'src/Views/admin/users/index.php';
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return ['error' => 'Terjadi kesalahan sistem'];
        }
    }

    public function edit($id) {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'full_name' => $_POST['full_name'],
                    'email' => $_POST['email'],
                    'role' => $_POST['role']
                ];

                if (!empty($_POST['password'])) {
                    $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                }

                if ($this->userModel->update($id, $data)) {
                    header('Location: ' . BASE_URL . '/admin/users');
                    exit;
                }
            }

            $user = $this->userModel->getById($id);
            
            $data = [
                'pageTitle' => 'Edit User',
                'user' => $user
            ];

            require_once 'src/Views/admin/users/edit.php';
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return ['error' => 'Terjadi kesalahan sistem'];
        }
    }

    public function delete($id) {
        try {
            if ($this->userModel->delete($id)) {
                header('Location: ' . BASE_URL . '/admin/users');
                exit;
            }
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return ['error' => 'Terjadi kesalahan sistem'];
        }
    }
}