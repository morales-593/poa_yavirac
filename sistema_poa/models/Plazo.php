<?php
require_once 'config/database.php';

class Plazo {

    public static function all() {
        $db = Database::connect();
        $sql = "SELECT * FROM plazos ORDER BY id_plazo DESC";
        return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($nombre) {
        $db = Database::connect();
        $sql = "INSERT INTO plazos (nombre_plazo) VALUES (?)";
        $stmt = $db->prepare($sql);
        return $stmt->execute([$nombre]);
    }

    public static function find($id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM plazos WHERE id_plazo = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function update($id, $nombre) {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE plazos SET nombre_plazo=? WHERE id_plazo=?");
        return $stmt->execute([$nombre, $id]);
    }

    public static function delete($id) {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM plazos WHERE id_plazo=?");
        return $stmt->execute([$id]);
    }
}
