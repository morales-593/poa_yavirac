<?php
require_once 'config/database.php';

class Objetivo {

    public static function listar() {
        $sql = "SELECT o.*, e.nombre AS eje
                FROM objetivos o
                JOIN ejes e ON e.id_eje = o.id_eje";
        return Database::connect()->query($sql)->fetchAll();
    }

    public static function guardar($id_eje, $descripcion) {
        $sql = "INSERT INTO objetivos (id_eje, descripcion) VALUES (?,?)";
        Database::connect()->prepare($sql)->execute([$id_eje, $descripcion]);
    }
}
