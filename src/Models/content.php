<?php
namespace Models;

use PDO;
use PDOException;
use Config\Database;

class Content {
    // Code remains the same...

    private $db;
    private $table = 'educational_contents';

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getAll($limit = null) {
        try {
            $query = "SELECT ec.*, u.username as creator_name 
                     FROM " . $this->table . " ec 
                     LEFT JOIN users u ON ec.created_by = u.id 
                     ORDER BY ec.created_at DESC";
            
            if ($limit) {
                $query .= " LIMIT :limit";
            }

            $stmt = $this->db->prepare($query);
            
            if ($limit) {
                $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getById($id) {
        try {
            $query = "SELECT ec.*, u.username as creator_name 
                     FROM " . $this->table . " ec 
                     LEFT JOIN users u ON ec.created_by = u.id 
                     WHERE ec.id = :id LIMIT 1";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id", $id);
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
                     (title, description, content_type, content, thumbnail, created_by, status) 
                     VALUES (:title, :description, :content_type, :content, :thumbnail, :created_by, :status)";

            $stmt = $this->db->prepare($query);
            
            $stmt->bindParam(":title", $data['title']);
            $stmt->bindParam(":description", $data['description']);
            $stmt->bindParam(":content_type", $data['content_type']);
            $stmt->bindParam(":content", $data['content']);
            $stmt->bindParam(":thumbnail", $data['thumbnail']);
            $stmt->bindParam(":created_by", $data['created_by']);
            $stmt->bindParam(":status", $data['status']);

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
                     " . implode(', ', $fields) . ", 
                     updated_at = CURRENT_TIMESTAMP 
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