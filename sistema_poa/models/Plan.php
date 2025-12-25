<?php
require_once 'config/database.php';

class Plan {

    private static function db(){
        return Database::connect();
    }

    public static function all(){
        $sql = "
        SELECT p.*, r.nombre_responsable, u.nombres
        FROM planes p
        JOIN responsables r ON r.id_responsable = p.id_responsable
        JOIN usuarios u ON u.id_usuario = p.id_usuario
        ORDER BY p.fecha_creacion DESC";
        return self::db()->query($sql)->fetchAll();
    }

    public static function responsables(){
        return self::db()->query("SELECT * FROM responsables WHERE estado='ACTIVO'")->fetchAll();
    }

    public static function create($data){
        $sql = "INSERT INTO planes 
        (nombre_elaborado,id_responsable,id_usuario,estado,fecha_elaboracion)
        VALUES (?,?,?,?,?)";

        self::db()->prepare($sql)->execute([
            $data['nombre'],
            $data['responsable'],
            $_SESSION['usuario']['id_usuario'],
            'PENDIENTE',
            $data['fecha']
        ]);
    }

    public static function delete($id){
        self::db()->prepare("DELETE FROM planes WHERE id_plan=?")->execute([$id]);
    }
}
