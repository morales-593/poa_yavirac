<?php
require_once 'config/database.php';

class Usuario {

    public static function login($usuario, $password) {
        $db = Database::connect();

        $sql = "SELECT * FROM usuarios 
                WHERE usuario = ?
                AND estado = 'ACTIVO'
                LIMIT 1";

        $stmt = $db->prepare($sql);
        $stmt->execute([$usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }
}
