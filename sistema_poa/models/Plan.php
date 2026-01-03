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
        return self::db()->query("SELECT * FROM planes ORDER BY fecha_creacion DESC")->fetchAll();
    }

    public static function find($id)
    {
        $stmt = self::db()->prepare("SELECT * FROM planes WHERE id_plan=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function elaboracionPorPlan($id)
    {
        $stmt = self::db()->prepare("SELECT * FROM elaboracion WHERE id_plan=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function obtenerEjePorIndicador($id_indicador)
    {
        $stmt = self::db()->prepare("SELECT id_eje FROM indicadores WHERE id_indicador = ?");
        $stmt->execute([$id_indicador]);
        $res = $stmt->fetch();
        return $res ? $res['id_eje'] : null;
    }

    public static function ejes()
    {
        $db = Database::connect();
        // CORREGIDO: El campo se llama 'objetivo' no 'descripcion_objetivo'
        return $db->query("SELECT id_eje, nombre_eje, objetivo as descripcion_objetivo FROM ejes ORDER BY nombre_eje ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function indicadoresPorEje($id_eje)
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT id_indicador, codigo, descripcion FROM indicadores WHERE id_eje = ? ORDER BY codigo ASC");
        $stmt->execute([$id_eje]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function temas()
    {
        return self::db()->query("SELECT * FROM temas_poa WHERE estado='ACTIVO'")->fetchAll();
    }

    public static function responsables()
    {
        return self::db()->query("SELECT * FROM responsables WHERE estado='ACTIVO'")->fetchAll();
    }

    public static function plazos()
    {
        return self::db()->query("SELECT * FROM plazos")->fetchAll();
    }

    public static function obtenerMediosVerificacion($id_elaboracion)
    {
        $stmt = self::db()->prepare("
            SELECT m.detalle, m.id_plazo, p.nombre_plazo 
            FROM medios_verificacion m 
            LEFT JOIN plazos p ON m.id_plazo = p.id_plazo 
            WHERE m.id_elaboracion = ?
        ");
        $stmt->execute([$id_elaboracion]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerIndicador($id_indicador)
    {
        $stmt = self::db()->prepare("SELECT * FROM indicadores WHERE id_indicador = ?");
        $stmt->execute([$id_indicador]);
        return $stmt->fetch();
    }

    public static function guardarElaboracion($d)
    {
        $db = self::db();
        
        // Validar que exista el plan
        $plan = self::find($d['id_plan']);
        if (!$plan) {
            die("Error: El plan no existe");
        }
        
        try {
            if (!empty($d['id_elaboracion'])) {
                // Modo edición
                $sql = "UPDATE elaboracion SET 
                        id_tema = ?, 
                        id_indicador = ?, 
                        linea_base = ?, 
                        politicas = ?, 
                        metas = ?, 
                        actividades = ?, 
                        indicador_resultado = ?, 
                        id_responsable = ? 
                        WHERE id_elaboracion = ?";
                
                $stmt = $db->prepare($sql);
                $stmt->execute([
                    $d['id_tema'],
                    $d['id_indicador'],
                    $d['linea_base'],
                    $d['politicas'] ?? '',
                    $d['metas'] ?? '',
                    $d['actividades'],
                    $d['indicador_resultado'] ?? '',
                    $d['id_responsable'],
                    $d['id_elaboracion']
                ]);
                
                $id_elab = $d['id_elaboracion'];
            } else {
                // Modo nuevo
                $sql = "INSERT INTO elaboracion (
                        id_tema, id_plan, id_indicador, linea_base, 
                        politicas, metas, actividades, indicador_resultado, id_responsable
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                
                $stmt = $db->prepare($sql);
                $stmt->execute([
                    $d['id_tema'],
                    $d['id_plan'],
                    $d['id_indicador'],
                    $d['linea_base'],
                    $d['politicas'] ?? '',
                    $d['metas'] ?? '',
                    $d['actividades'],
                    $d['indicador_resultado'] ?? '',
                    $d['id_responsable']
                ]);
                
                $id_elab = $db->lastInsertId();
            }

            // Eliminar medios de verificación existentes
            $db->prepare("DELETE FROM medios_verificacion WHERE id_elaboracion = ?")->execute([$id_elab]);
            
            // Insertar nuevos medios de verificación
            if (!empty($d['detalle'])) {
                foreach ($d['detalle'] as $i => $det) {
                    if (trim($det) != '' && !empty($d['id_plazo'][$i])) {
                        $db->prepare("INSERT INTO medios_verificacion (detalle, id_plazo, id_elaboracion) VALUES (?, ?, ?)")
                            ->execute([$det, $d['id_plazo'][$i], $id_elab]);
                    }
                }
            }
            
            return true;
            
        } catch (PDOException $e) {
            error_log("Error al guardar elaboración: " . $e->getMessage());
            return false;
        }
    }

    // Método para guardar un nuevo plan
    public static function guardar($nombre_elaborado, $nombre_responsable, $id_usuario)
    {
        $db = self::db();
        $stmt = $db->prepare("INSERT INTO planes (nombre_elaborado, nombre_responsable, id_usuario) VALUES (?, ?, ?)");
        return $stmt->execute([$nombre_elaborado, $nombre_responsable, $id_usuario]);
    }

    // Método para eliminar un plan
    public static function eliminar($id_plan)
    {
        $db = self::db();
        $stmt = $db->prepare("DELETE FROM planes WHERE id_plan = ?");
        return $stmt->execute([$id_plan]);
    }
}