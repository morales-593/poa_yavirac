<?php
require_once 'config/database.php';

class Plan
{
    private static function db()
    {
        return Database::connect();
    }

    // OBTENER TODOS LOS PLANES
    public static function all()
    {
        return self::db()->query("SELECT * FROM planes ORDER BY fecha_creacion DESC")->fetchAll();
    }

    // BUSCAR UN PLAN POR ID
    public static function find($id)
    {
        $stmt = self::db()->prepare("SELECT * FROM planes WHERE id_plan=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // OBTENER ELABORACIÓN POR PLAN
    public static function elaboracionPorPlan($id)
    {
        $stmt = self::db()->prepare("SELECT * FROM elaboracion WHERE id_plan=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // OBTENER EJE POR INDICADOR
    public static function obtenerEjePorIndicador($id_indicador)
    {
        $stmt = self::db()->prepare("SELECT id_eje FROM indicadores WHERE id_indicador = ?");
        $stmt->execute([$id_indicador]);
        $res = $stmt->fetch();
        return $res ? $res['id_eje'] : null;
    }

    // OBTENER TODOS LOS EJES
    public static function ejes()
    {
        $db = Database::connect();
        return $db->query("SELECT id_eje, nombre_eje, objetivo as descripcion_objetivo FROM ejes ORDER BY nombre_eje ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    // OBTENER INDICADORES POR EJE
    public static function indicadoresPorEje($id_eje)
    {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT id_indicador, codigo, descripcion FROM indicadores WHERE id_eje = ? ORDER BY codigo ASC");
        $stmt->execute([$id_eje]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // OBTENER TODOS LOS TEMAS ACTIVOS
    public static function temas()
    {
        return self::db()->query("SELECT * FROM temas_poa WHERE estado='ACTIVO'")->fetchAll();
    }

    // OBTENER TODOS LOS RESPONSABLES ACTIVOS
    public static function responsables()
    {
        return self::db()->query("SELECT * FROM responsables WHERE estado='ACTIVO'")->fetchAll();
    }

    // OBTENER TODOS LOS PLAZOS
    public static function plazos()
    {
        return self::db()->query("SELECT * FROM plazos ORDER BY nombre_plazo ASC")->fetchAll();
    }

    // OBTENER MEDIOS DE VERIFICACIÓN POR ELABORACIÓN
    public static function obtenerMediosVerificacion($id_elaboracion)
    {
        $stmt = self::db()->prepare("
            SELECT m.detalle, m.id_plazo, p.nombre_plazo 
            FROM medios_verificacion m 
            LEFT JOIN plazos p ON m.id_plazo = p.id_plazo 
            WHERE m.id_elaboracion = ?
            ORDER BY m.id_medio ASC
        ");
        $stmt->execute([$id_elaboracion]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // OBTENER UN INDICADOR ESPECÍFICO
    public static function obtenerIndicador($id_indicador)
    {
        $stmt = self::db()->prepare("SELECT * FROM indicadores WHERE id_indicador = ?");
        $stmt->execute([$id_indicador]);
        return $stmt->fetch();
    }

    // GUARDAR ELABORACIÓN COMPLETA
    public static function guardarElaboracion($d)
    {
        $db = self::db();

        // Validar que exista el plan
        $plan = self::find($d['id_plan']);
        if (!$plan) {
            throw new Exception("El plan no existe");
        }

        try {
            $db->beginTransaction();

            if (!empty($d['id_elaboracion'])) {
                // MODO EDICIÓN
                $sql = "UPDATE elaboracion SET 
                        id_tema = ?, 
                        id_indicador = ?, 
                        linea_base = ?, 
                        politicas = ?, 
                        metas = ?, 
                        actividades = ?, 
                        indicador_resultado = ?, 
                        id_responsable = ?,
                        fecha_actualizacion = NOW()
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
                // MODO NUEVO
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

            // ELIMINAR MEDIOS DE VERIFICACIÓN EXISTENTES
            $db->prepare("DELETE FROM medios_verificacion WHERE id_elaboracion = ?")->execute([$id_elab]);

            // INSERTAR NUEVOS MEDIOS DE VERIFICACIÓN
            if (!empty($d['detalle']) && is_array($d['detalle'])) {
                foreach ($d['detalle'] as $i => $det) {
                    if (trim($det) != '' && !empty($d['id_plazo'][$i])) {
                        $db->prepare("INSERT INTO medios_verificacion (detalle, id_plazo, id_elaboracion) VALUES (?, ?, ?)")
                            ->execute([trim($det), $d['id_plazo'][$i], $id_elab]);
                    }
                }
            }

            $db->commit();
            return ['success' => true, 'id_elaboracion' => $id_elab];

        } catch (PDOException $e) {
            $db->rollBack();
            error_log("Error al guardar elaboración: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    // GUARDAR UN NUEVO PLAN
    public static function guardar($nombre_elaborado, $nombre_responsable, $id_usuario)
    {
        $db = self::db();
        $stmt = $db->prepare("INSERT INTO planes (nombre_elaborado, nombre_responsable, id_usuario) VALUES (?, ?, ?)");
        return $stmt->execute([$nombre_elaborado, $nombre_responsable, $id_usuario]);
    }

    // ELIMINAR UN PLAN
    public static function eliminar($id_plan)
    {
        $db = self::db();

        try {
            $db->beginTransaction();

            // Primero eliminar medios de verificación relacionados
            $stmt = $db->prepare("DELETE m FROM medios_verificacion m 
                                  INNER JOIN elaboracion e ON m.id_elaboracion = e.id_elaboracion 
                                  WHERE e.id_plan = ?");
            $stmt->execute([$id_plan]);

            // Luego eliminar elaboraciones
            $stmt = $db->prepare("DELETE FROM elaboracion WHERE id_plan = ?");
            $stmt->execute([$id_plan]);

            // Finalmente eliminar el plan
            $stmt = $db->prepare("DELETE FROM planes WHERE id_plan = ?");
            $stmt->execute([$id_plan]);

            $db->commit();
            return true;

        } catch (PDOException $e) {
            $db->rollBack();
            error_log("Error al eliminar plan: " . $e->getMessage());
            return false;
        }
    }

    // OBTENER PLANES CON INFORMACIÓN DE ELABORACIÓN
    public static function planesConElaboracion()
    {
        $db = self::db();
        $sql = "SELECT p.*, 
                       COUNT(e.id_elaboracion) as tiene_elaboracion,
                       MAX(e.fecha_creacion) as fecha_elaboracion
                FROM planes p
                LEFT JOIN elaboracion e ON p.id_plan = e.id_plan
                GROUP BY p.id_plan
                ORDER BY p.fecha_creacion DESC";

        return $db->query($sql)->fetchAll();
    }

    // VERIFICAR SI UN PLAN TIENE ELABORACIÓN
    public static function tieneElaboracion($id_plan)
    {
        $stmt = self::db()->prepare("SELECT COUNT(*) as total FROM elaboracion WHERE id_plan = ?");
        $stmt->execute([$id_plan]);
        $result = $stmt->fetch();
        return $result['total'] > 0;
    }

    // OBTENER INFORMACIÓN COMPLETA DE UNA ELABORACIÓN
    public static function obtenerElaboracionCompleta($id_elaboracion)
    {
        $db = self::db();
        $sql = "SELECT e.*, 
                       p.nombre_elaborado, p.nombre_responsable,
                       ej.nombre_eje, ej.objetivo,
                       i.codigo, i.descripcion as descripcion_indicador,
                       t.descripcion as tema,
                       r.nombre_responsable as nombre_completo_responsable
                FROM elaboracion e
                INNER JOIN planes p ON e.id_plan = p.id_plan
                INNER JOIN indicadores i ON e.id_indicador = i.id_indicador
                INNER JOIN ejes ej ON i.id_eje = ej.id_eje
                INNER JOIN temas_poa t ON e.id_tema = t.id_tema
                INNER JOIN responsables r ON e.id_responsable = r.id_responsable
                WHERE e.id_elaboracion = ?";

        $stmt = $db->prepare($sql);
        $stmt->execute([$id_elaboracion]);
        return $stmt->fetch();
    }
}