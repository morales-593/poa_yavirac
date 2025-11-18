<?php
class User {
    private $conn;
    private $table_name = "usuarios";

    public $id;
    public $username;
    public $password;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login() {
        $query = "SELECT id, username, password FROM " . $this->table_name . " 
                  WHERE username = :username AND password = :password";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->execute();

        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET username=:username, password=:password";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>