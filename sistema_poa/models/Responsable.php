<?php
require_once 'config/database.php';

class Responsable {

    public static function all() {
        $db = Database::connect();
        $sql = "SELECT * FROM responsables ORDER BY id_responsable DESC";
        return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($nombre) {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO responsables (nombre_responsable) VALUES (?)");
        return $stmt->execute([$nombre]);
    }

    public static function find($id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM responsables WHERE id_responsable=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function update($id, $nombre) {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE responsables SET nombre_responsable=? WHERE id_responsable=?");
        return $stmt->execute([$nombre, $id]);
    }

    public static function toggle($id) {
        $db = Database::connect();
        $sql = "UPDATE responsables 
                SET estado = IF(estado='ACTIVO','INACTIVO','ACTIVO') 
                WHERE id_responsable=?";
        $stmt = $db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public static function delete($id) {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM responsables WHERE id_responsable=?");
        return $stmt->execute([$id]);
    }
}
