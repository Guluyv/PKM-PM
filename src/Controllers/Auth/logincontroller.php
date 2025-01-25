<?php
class LoginController {
    private $auth;

    public function __construct() {
        $this->auth = new Auth();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            // Validasi input
            if (empty($email) || empty($password)) {
                return ['error' => 'Email dan password harus diisi'];
            }

            // Proses login menggunakan Auth helper
            if ($this->auth->login($email, $password)) {
                // Redirect berdasarkan role
                if ($this->auth->isAdmin()) {
                    header('Location: ' . BASE_URL . '/admin/dashboard');
                } else {
                    header('Location: ' . BASE_URL . '/student/home');
                }
                exit;
            }

            return ['error' => 'Email atau password salah'];
        }
        
        // Tampilkan halaman login
        require_once 'src/Views/auth/login.php';
    }

    public function logout() {
        $this->auth->logout();
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}