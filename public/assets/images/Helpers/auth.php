<?php
class Auth {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function login($email, $password) {
        try {
            $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            if($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if(password_verify($password, $row['password'])) {
                    // Set session
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['role'] = $row['role'];
                    $_SESSION['username'] = $row['username'];
                    return true;
                }
            }
            return false;
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function register($username, $email, $password, $full_name) {
        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $query = "INSERT INTO users (username, email, password, role, full_name) 
                     VALUES (:username, :email, :password, 'student', :full_name)";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $hashed_password);
            $stmt->bindParam(":full_name", $full_name);

            return $stmt->execute();
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    public function logout() {
        session_destroy();
        return true;
    }

    public function getCurrentUser() {
        if(!$this->isLoggedIn()) return null;
        
        try {
            $query = "SELECT id, username, email, role, full_name, profile_picture 
                     FROM users WHERE id = :id LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id", $_SESSION['user_id']);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }
}