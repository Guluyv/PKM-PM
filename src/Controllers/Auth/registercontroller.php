<?php
class RegisterController {
    private $auth;

    public function __construct() {
        $this->auth = new Auth();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];

            // Validasi input
            if (empty($fullname) || empty($email) || empty($password)) {
                return ['error' => 'Semua field harus diisi'];
            }

            if ($password !== $password_confirm) {
                return ['error' => 'Password tidak cocok'];
            }

            // Generate username dari email
            $username = explode('@', $email)[0];

            // Proses register menggunakan Auth helper
            if ($this->auth->register($username, $email, $password, $fullname)) {
                $_SESSION['success'] = 'Registrasi berhasil! Silakan login.';
                header('Location: ' . BASE_URL . '/login');
                exit;
            }

            return ['error' => 'Gagal melakukan registrasi'];
        }
        
        // Tampilkan halaman register
        require_once 'src/Views/auth/register.php';
    }
}