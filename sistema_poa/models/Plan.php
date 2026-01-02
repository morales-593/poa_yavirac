<?php
require_once 'config/database.php';

class Plan
{
    private static function db()
    {
        return Database::connect();
    }

    public static function all()
    {
        return self::db()->query("
            SELECT *
            FROM planes
            ORDER BY fecha_creacion DESC
        ")->fetchAll();
    }

    public static function create($data)
    {
        $sql = "INSERT INTO planes 
        (nombre_elaborado, nombre_responsable, id_usuario, estado) 
        VALUES (?,?,?,?)";

        $stmt = self::db()->prepare($sql);
        return $stmt->execute([
            $data['nombre_elaborado'],
            $data['nombre_responsable'],
            $data['id_usuario'],
            'PENDIENTE'
        ]);
    }

    public static function find($id)
    {
        $stmt = self::db()->prepare("SELECT * FROM planes WHERE id_plan=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function delete($id)
    {
        $stmt = self::db()->prepare("DELETE FROM planes WHERE id_plan=?");
        return $stmt->execute([$id]);
    }
}
