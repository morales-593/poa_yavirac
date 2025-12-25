<?php
require_once 'config/database.php';

class Dashboard
{
    private static function db()
    {
        return Database::connect();
    }

    public static function totalPlanes()
    {
        return self::db()->query("SELECT COUNT(*) FROM planes")->fetchColumn();
    }

    public static function usuariosActivos()
    {
        return self::db()->query("SELECT COUNT(*) FROM usuarios WHERE estado='ACTIVO'")->fetchColumn();
    }

    public static function planesCompletados()
    {
        return self::db()->query("SELECT COUNT(*) FROM planes WHERE estado='COMPLETADO'")->fetchColumn();
    }

    public static function totalEjes()
    {
        return self::db()->query("SELECT COUNT(*) FROM ejes")->fetchColumn();
    }

    public static function ejes()
    {
        return self::db()->query("SELECT id_eje, nombre_eje FROM ejes")->fetchAll();
    }

    public static function planesPorEje()
    {
        return self::db()->query("
            SELECT e.nombre_eje, COUNT(DISTINCT p.id_plan) AS total
            FROM ejes e
            LEFT JOIN indicadores i ON i.id_eje = e.id_eje
            LEFT JOIN plan_detalle d ON d.id_indicador = i.id_indicador
            LEFT JOIN planes p ON p.id_plan = d.id_plan
            GROUP BY e.id_eje
        ")->fetchAll();
    }

    public static function planesPorMes()
    {
        return self::db()->query("
            SELECT MONTH(fecha_creacion) AS mes, COUNT(*) AS total
            FROM planes
            GROUP BY mes
            ORDER BY mes
        ")->fetchAll();
    }

    public static function estadoPorEje()
    {
        return self::db()->query("
            SELECT e.nombre_eje, COUNT(DISTINCT p.id_plan) AS total
            FROM ejes e
            LEFT JOIN indicadores i ON i.id_eje = e.id_eje
            LEFT JOIN plan_detalle d ON d.id_indicador = i.id_indicador
            LEFT JOIN planes p ON p.id_plan = d.id_plan
            GROUP BY e.id_eje
        ")->fetchAll();
    }

    public static function eficienciaResponsables()
    {
        return self::db()->query("
            SELECT r.nombre_responsable, COUNT(p.id_plan) AS total
            FROM responsables r
            LEFT JOIN planes p ON p.id_responsable = r.id_responsable
            GROUP BY r.id_responsable
        ")->fetchAll();
    }
}
