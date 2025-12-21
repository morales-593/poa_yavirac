<?php
require_once 'config/database.php';

class Eje {

    public static function listar() {
        return Database::connect()
            ->query("SELECT * FROM ejes")
            ->fetchAll();
    }

    public static function guardar($nombre, $descripcion) {
        $sql = "INSERT INTO ejes (nombre, descripcion) VALUES (?,?)";
        Database::connect()->prepare($sql)->execute([$nombre, $descripcion]);
    }
}
