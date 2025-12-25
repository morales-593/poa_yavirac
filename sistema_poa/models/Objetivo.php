<?php
require_once 'config/database.php';


class Objetivo {

    public static function getAll() {
        $db = Database::connect();
        $sql = "SELECT o.id_objetivo, o.descripcion, e.nombre AS eje
                FROM objetivos o
                JOIN ejes e ON o.id_eje = e.id_eje";
        return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByEje($id_eje) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM objetivos WHERE id_eje = ?");
        $stmt->execute([$id_eje]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($id_eje, $descripcion) {
        $db = Database::connect();
        $stmt = $db->prepare(
            "INSERT INTO objetivos (id_eje, descripcion) VALUES (?, ?)"
        );
        return $stmt->execute([$id_eje, $descripcion]);
    }

    public static function delete($id) {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM objetivos WHERE id_objetivo = ?");
        return $stmt->execute([$id]);
    }
}

