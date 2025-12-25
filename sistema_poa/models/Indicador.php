<?php
require_once 'config/database.php';

class Indicador {

    public static function getAll() {
        $db = Database::connect();
        $sql = "SELECT i.*, e.nombre_eje 
                FROM indicadores i
                JOIN ejes e ON i.id_eje = e.id_eje
                ORDER BY i.id_indicador DESC";
        return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($codigo, $descripcion, $id_eje) {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO indicadores (codigo, descripcion, id_eje) VALUES (?, ?, ?)");
        return $stmt->execute([$codigo, $descripcion, $id_eje]);
    }

    public static function delete($id) {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM indicadores WHERE id_indicador=?");
        return $stmt->execute([$id]);
    }

    public static function getEjes() {
        $db = Database::connect();
        return $db->query("SELECT id_eje, nombre_eje FROM ejes ORDER BY nombre_eje")->fetchAll(PDO::FETCH_ASSOC);
    }
}
