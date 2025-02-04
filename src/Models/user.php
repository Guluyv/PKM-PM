<?php
namespace Models;

use PDO;
use PDOException;
use Config\Database;

class User {
    // Code remains the same...

    private $db;
    private $table = 'users';

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getById($id) {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getByEmail($email) {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function create($data) {
        try {
            $query = "INSERT INTO " . $this->table . " 
                     (username, email, password, role, full_name) 
                     VALUES (:username, :email, :password, :role, :full_name)";

            $stmt = $this->db->prepare($query);
            
            $stmt->bindParam(":username", $data['username']);
            $stmt->bindParam(":email", $data['email']);
            $stmt->bindParam(":password", $data['password']);
            $stmt->bindParam(":role", $data['role']);
            $stmt->bindParam(":full_name", $data['full_name']);

            return $stmt->execute() ? $this->db->lastInsertId() : false;
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function update($id, $data) {
        try {
            $fields = array();
            $values = array();

            foreach ($data as $key => $value) {
                $fields[] = "$key = :$key";
                $values[":$key"] = $value;
            }

            $query = "UPDATE " . $this->table . " SET 
                     " . implode(', ', $fields) . "
                     WHERE id = :id";

            $stmt = $this->db->prepare($query);
            $values[":id"] = $id;
            
            return $stmt->execute($values);
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}