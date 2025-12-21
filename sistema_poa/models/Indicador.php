<?php
require_once 'config/database.php';

class Indicador {

    public static function listar() {
        $sql = "SELECT i.*, e.nombre AS eje
                FROM indicadores i
                JOIN ejes e ON e.id_eje = i.id_eje";
        return Database::connect()->query($sql)->fetchAll();
    }

    public static function guardar($codigo, $descripcion, $id_eje) {
        $sql = "INSERT INTO indicadores (codigo, descripcion, id_eje)
                VALUES (?,?,?)";
        Database::connect()->prepare($sql)
            ->execute([$codigo, $descripcion, $id_eje]);
    }
}
