<?php
// Remover session_start() de aquí y moverlo a los archivos que lo necesiten
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    public function login($username, $password) {
        $this->user->username = $username;
        $this->user->password = $password;

        $stmt = $this->user->login();
        
        if($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            return true;
        }
        return false;
    }

    public function logout() {
        session_destroy();
        header("Location: login.php");
        exit;
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
}
?>