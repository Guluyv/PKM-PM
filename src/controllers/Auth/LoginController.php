<?php
namespace Controllers\Auth;

use PDO;
use PDOException;
use Config\Database;

class LoginController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            // Validasi input
            if (empty($email) || empty($password)) {
                return ['error' => 'Email dan password harus diisi'];
            }

            try {
                $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(":email", $email);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    if (password_verify($password, $user['password'])) {
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['role'] = $user['role'];
                        $_SESSION['username'] = $user['username'];

                        // Redirect based on role
                        header('Location: ' . BASE_URL . ($user['role'] === 'admin' ? '/admin/dashboard' : '/student/home'));
                        exit;
                    }
                }
                return ['error' => 'Email atau password salah'];
            } catch(PDOException $e) {
                error_log($e->getMessage());
                return ['error' => 'Terjadi kesalahan sistem'];
            }
        }

        // Perbaikan path ke view login
        require_once __DIR__ . '/../../Views/auth/login.php';
    }

    public function logout() {
        session_destroy();
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}