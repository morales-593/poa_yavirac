<?php
require_once 'config/database.php';

class Responsable {

    public static function listar() {
        return Database::connect()
            ->query("SELECT * FROM responsables")
            ->fetchAll();
    }

    public static function guardar($nombre, $cargo) {
        $sql = "INSERT INTO responsables (nombre, cargo) VALUES (?,?)";
        Database::connect()->prepare($sql)->execute([$nombre, $cargo]);
    }
}
