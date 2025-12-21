<?php
require_once 'config/database.php';

class Tema {

    public static function listar() {
        $sql = "SELECT t.*, o.descripcion AS objetivo
                FROM temas_poa t
                JOIN objetivos o ON o.id_objetivo = t.id_objetivo";
        return Database::connect()->query($sql)->fetchAll();
    }

    public static function guardar($id_objetivo, $nombre) {
        $sql = "INSERT INTO temas_poa (id_objetivo, nombre) VALUES (?,?)";
        Database::connect()->prepare($sql)->execute([$id_objetivo, $nombre]);
    }
}
