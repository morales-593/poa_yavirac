<?php
require_once 'config/database.php';

class Eje {

    public static function getAll() {
        $db = Database::connect();
        $sql = "SELECT * FROM ejes ORDER BY id_eje DESC";
        return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($nombre, $objetivo) {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO ejes (nombre_eje, descripcion_objetivo) VALUES (?, ?)");
        return $stmt->execute([$nombre, $objetivo]);
    }

    public static function update($id, $nombre, $objetivo) {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE ejes SET nombre_eje=?, descripcion_objetivo=? WHERE id_eje=?");
        return $stmt->execute([$nombre, $objetivo, $id]);
    }

    public static function delete($id) {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM ejes WHERE id_eje=?");
        return $stmt->execute([$id]);
    }

    public static function getById($id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM ejes WHERE id_eje=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
