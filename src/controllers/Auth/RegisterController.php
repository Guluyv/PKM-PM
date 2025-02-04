<?php
namespace Controllers\Auth;

use PDO;          // Perbaikan use statement
use PDOException;
use Models\User;
use Helpers\Auth;
use Config\Database;

class RegisterController {
    // Code remains the same...

    private $db;
    private $auth;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->auth = new Auth();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Get and sanitize input
                $fullname = filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_STRING);
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                $password = $_POST['password'];
                $password_confirm = $_POST['password_confirm'];

                // Validate input
                $errors = $this->validateInput($fullname, $email, $password, $password_confirm);
                if (!empty($errors)) {
                    return ['error' => $errors];
                }

                // Check if email already exists
                if ($this->emailExists($email)) {
                    return ['error' => 'Email sudah terdaftar'];
                }

                // Generate username from email
                $username = explode('@', $email)[0];
                
                // Process registration using Auth helper
                if ($this->auth->register($username, $email, $password, $fullname)) {
                    $_SESSION['success'] = 'Registrasi berhasil! Silakan login.';
                    header('Location: ' . BASE_URL . '/login');
                    exit;
                }

                return ['error' => 'Gagal melakukan registrasi'];
            } catch (PDOException $e) {
                error_log($e->getMessage());
                return ['error' => 'Terjadi kesalahan sistem'];
            }
        }

        // Display register form
        require_once __DIR__ . '/../../Views/auth/register.php';
    }

    private function validateInput($fullname, $email, $password, $password_confirm) {
        $errors = [];

        // Validate fullname
        if (empty($fullname)) {
            $errors[] = 'Nama lengkap harus diisi';
        } elseif (strlen($fullname) < 3) {
            $errors[] = 'Nama lengkap minimal 3 karakter';
        }

        // Validate email
        if (empty($email)) {
            $errors[] = 'Email harus diisi';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Format email tidak valid';
        }

        // Validate password
        if (empty($password)) {
            $errors[] = 'Password harus diisi';
        } elseif (strlen($password) < 6) {
            $errors[] = 'Password minimal 6 karakter';
        }

        // Validate password confirmation
        if ($password !== $password_confirm) {
            $errors[] = 'Konfirmasi password tidak cocok';
        }

        return $errors;
    }

    private function emailExists($email) {
        try {
            $query = "SELECT COUNT(*) as count FROM users WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result['count'] > 0;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Optional: Add additional validation methods if needed
    private function isStrongPassword($password) {
        // Password must contain at least:
        // - 8 characters
        // - 1 uppercase letter
        // - 1 lowercase letter
        // - 1 number
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/';
        return preg_match($pattern, $password);
    }

    private function sanitizeUsername($username) {
        // Remove special characters and spaces
        $username = preg_replace('/[^A-Za-z0-9]/', '', $username);
        // Ensure username is unique by adding number if needed
        $baseUsername = $username;
        $counter = 1;
        
        while ($this->usernameExists($username)) {
            $username = $baseUsername . $counter;
            $counter++;
        }
        
        return $username;
    }

    private function usernameExists($username) {
        try {
            $query = "SELECT COUNT(*) as count FROM users WHERE username = :username";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":username", $username);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result['count'] > 0;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}