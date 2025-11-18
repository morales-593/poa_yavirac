<?php
require_once '../config/database.php';
require_once '../models/User.php';

class CoordinacionController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    public function crearUsuario($username, $password) {
        $this->user->username = $username;
        $this->user->password = $password;
        return $this->user->create();
    }

    public function listarUsuarios() {
        return $this->user->read();
    }

    public function eliminarUsuario($id) {
        $this->user->id = $id;
        return $this->user->delete();
    }
}
?>