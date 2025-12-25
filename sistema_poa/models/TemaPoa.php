<?php
require_once 'config/database.php';

class TemaPoa {

    public static function getAll() {
        $db = Database::connect();
        $sql = "SELECT * FROM temas_poa ORDER BY id_tema DESC";
        return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($descripcion) {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO temas_poa (descripcion) VALUES (?)");
        return $stmt->execute([$descripcion]);
    }

    public static function update($id, $descripcion, $estado) {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE temas_poa SET descripcion=?, estado=? WHERE id_tema=?");
        return $stmt->execute([$descripcion, $estado, $id]);
    }

    public static function delete($id) {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE temas_poa SET estado='INACTIVO' WHERE id_tema=?");
        return $stmt->execute([$id]);
    }

    public static function getById($id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM temas_poa WHERE id_tema=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function cambiarEstado($id, $estado) {
    $db = Database::connect();
    $stmt = $db->prepare("UPDATE temas_poa SET estado=? WHERE id_tema=?");
    return $stmt->execute([$estado, $id]);
}

}
