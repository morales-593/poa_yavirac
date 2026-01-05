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

    // OBTENER MEDIOS DE VERIFICACIÓN POR ELABORACIÓN (CON ID_MEDIO)
    public static function obtenerMediosVerificacion($id_elaboracion)
    {
        $stmt = self::db()->prepare("
            SELECT m.id_medio, m.detalle, m.id_plazo, p.nombre_plazo 
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
                        $stmt = $db->prepare("INSERT INTO medios_verificacion (detalle, id_plazo, id_elaboracion) VALUES (?, ?, ?)");
                        $stmt->execute([trim($det), $d['id_plazo'][$i], $id_elab]);
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

    // ============================================
    // MÉTODOS DE SEGUIMIENTO - CON CALIFICACIÓN
    // ============================================

    // OBTENER SEGUIMIENTOS POR ELABORACIÓN
    public static function obtenerSeguimientos($id_elaboracion)
    {
        $db = self::db();
        $sql = "SELECT s.*, 
                       m.detalle as medio_detalle,
                       p.nombre_plazo as medio_plazo,
                       COUNT(DISTINCT ase.id_archivo_seg) as archivos,
                       s.calificacion,
                       s.porcentaje_cumplimiento
                FROM seguimiento s
                LEFT JOIN medios_verificacion m ON s.id_medio = m.id_medio
                LEFT JOIN plazos p ON m.id_plazo = p.id_plazo
                LEFT JOIN archivos_seguimiento ase ON s.id_seguimiento = ase.id_seguimiento
                WHERE s.id_elaboracion = ?
                GROUP BY s.id_seguimiento
                ORDER BY s.fecha_seguimiento DESC";

        $stmt = $db->prepare($sql);
        $stmt->execute([$id_elaboracion]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // OBTENER SEGUIMIENTO POR ELABORACIÓN
    public static function obtenerSeguimiento($id_elaboracion)
    {
        $db = self::db();
        $stmt = $db->prepare("SELECT * FROM seguimiento WHERE id_elaboracion = ? LIMIT 1");
        $stmt->execute([$id_elaboracion]);
        return $stmt->fetch();
    }

    // OBTENER CALIFICACIONES DETALLADAS POR MEDIO
    public static function obtenerCalificacionesMedios($id_seguimiento)
    {
        $db = self::db();
        $sql = "SELECT cm.*, 
                       m.detalle as medio_detalle
                FROM calificaciones_medios cm
                INNER JOIN medios_verificacion m ON cm.id_medio = m.id_medio
                WHERE cm.id_seguimiento = ?
                ORDER BY m.id_medio ASC";

        $stmt = $db->prepare($sql);
        $stmt->execute([$id_seguimiento]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // GUARDAR SEGUIMIENTO COMPLETO CON CALIFICACIÓN
    public static function guardarSeguimiento($datos)
    {
        $db = self::db();

        try {
            $db->beginTransaction();

            // Validar que existan medios de verificación
            if (empty($datos['medios']) || !is_array($datos['medios'])) {
                throw new Exception("No se han proporcionado datos de medios de verificación");
            }

            // Obtener id_medio principal (primer medio)
            $primer_medio = $datos['medios'][0] ?? null;
            $id_medio = $primer_medio['id_medio'] ?? null;

            // Verificar si ya existe seguimiento
            $seguimiento_existente = self::obtenerSeguimiento($datos['id_elaboracion']);

            // Calcular calificación total
            $calificacion_total = self::calcularCalificacionTotal($datos['medios']);

            if ($seguimiento_existente) {
                // Actualizar seguimiento existente
                $stmt = $db->prepare("
                    UPDATE seguimiento SET 
                        fecha_seguimiento = ?,
                        estado = 'COMPLETADO',
                        observacion_general = ?,
                        id_medio = ?,
                        calificacion = ?,
                        porcentaje_cumplimiento = ?
                    WHERE id_seguimiento = ?
                ");

                $stmt->execute([
                    $datos['fecha_seguimiento'],
                    $datos['observacion_general'] ?? '',
                    $id_medio,
                    $calificacion_total['calificacion'],
                    $calificacion_total['porcentaje'],
                    $seguimiento_existente['id_seguimiento']
                ]);

                $id_seguimiento = $seguimiento_existente['id_seguimiento'];

                // Eliminar calificaciones anteriores
                $db->prepare("DELETE FROM calificaciones_medios WHERE id_seguimiento = ?")
                    ->execute([$id_seguimiento]);

            } else {
                // Insertar nuevo seguimiento
                $stmt = $db->prepare("
                    INSERT INTO seguimiento (
                        id_elaboracion, id_medio, fecha_seguimiento, 
                        estado, observacion_general, calificacion, porcentaje_cumplimiento
                    ) VALUES (?, ?, ?, 'COMPLETADO', ?, ?, ?)
                ");

                $stmt->execute([
                    $datos['id_elaboracion'],
                    $id_medio,
                    $datos['fecha_seguimiento'],
                    $datos['observacion_general'] ?? '',
                    $calificacion_total['calificacion'],
                    $calificacion_total['porcentaje']
                ]);

                $id_seguimiento = $db->lastInsertId();
            }

            // Guardar calificaciones por medio
            foreach ($datos['medios'] as $medio) {
                if (isset($medio['id_medio']) && isset($medio['cumplimiento'])) {
                    $stmt = $db->prepare("
                        INSERT INTO calificaciones_medios (
                            id_seguimiento, id_medio, cumplimiento, 
                            calificacion_individual, observacion
                        ) VALUES (?, ?, ?, ?, ?)
                    ");

                    $calificacion_individual = $medio['cumplimiento'] === 'SI' 
                        ? 'CUMPLE - Medio verificado correctamente'
                        : 'NO CUMPLE - Medio no verificado';

                    $stmt->execute([
                        $id_seguimiento,
                        $medio['id_medio'],
                        $medio['cumplimiento'],
                        $calificacion_individual,
                        $medio['observacion'] ?? ''
                    ]);
                }
            }

            // Guardar archivo si existe
            if (isset($datos['archivo_seguimiento']) && $datos['archivo_seguimiento']['error'] === UPLOAD_ERR_OK) {
                self::guardarArchivoSeguimiento($id_seguimiento, $datos['archivo_seguimiento']);
            }

            $db->commit();
            return [
                'success' => true, 
                'id_seguimiento' => $id_seguimiento,
                'calificacion' => $calificacion_total
            ];

        } catch (PDOException $e) {
            $db->rollBack();
            error_log("Error en guardarSeguimiento: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        } catch (Exception $e) {
            $db->rollBack();
            error_log("Error en guardarSeguimiento: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    // CALCULAR CALIFICACIÓN TOTAL
    private static function calcularCalificacionTotal($medios)
    {
        $total_medios = count($medios);
        $cumplidos = 0;

        foreach ($medios as $medio) {
            if ($medio['cumplimiento'] === 'SI') {
                $cumplidos++;
            }
        }

        $porcentaje = $total_medios > 0 ? round(($cumplidos / $total_medios) * 100) : 0;

        // Determinar calificación cualitativa
        if ($porcentaje >= 90) {
            $calificacion = 'EXCELENTE';
        } elseif ($porcentaje >= 80) {
            $calificacion = 'MUY BUENO';
        } elseif ($porcentaje >= 70) {
            $calificacion = 'BUENO';
        } elseif ($porcentaje >= 60) {
            $calificacion = 'REGULAR';
        } else {
            $calificacion = 'DEFICIENTE';
        }

        return [
            'porcentaje' => $porcentaje,
            'calificacion' => $calificacion,
            'cumplidos' => $cumplidos,
            'total' => $total_medios
        ];
    }

    // OBTENER RESUMEN DE CALIFICACIÓN
    public static function obtenerResumenCalificacion($id_elaboracion)
    {
        $db = self::db();
        $sql = "SELECT 
                    s.calificacion,
                    s.porcentaje_cumplimiento,
                    COUNT(DISTINCT cm.id_calificacion) as total_medios,
                    SUM(CASE WHEN cm.cumplimiento = 'SI' THEN 1 ELSE 0 END) as medios_cumplidos
                FROM seguimiento s
                LEFT JOIN calificaciones_medios cm ON s.id_seguimiento = cm.id_seguimiento
                WHERE s.id_elaboracion = ?
                GROUP BY s.id_seguimiento
                LIMIT 1";

        $stmt = $db->prepare($sql);
        $stmt->execute([$id_elaboracion]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // VERIFICAR SI TIENE SEGUIMIENTO
    public static function tieneSeguimiento($id_plan)
    {
        $db = self::db();
        $sql = "SELECT COUNT(*) as total 
                FROM seguimiento s
                INNER JOIN elaboracion e ON s.id_elaboracion = e.id_elaboracion
                WHERE e.id_plan = ?";

        $stmt = $db->prepare($sql);
        $stmt->execute([$id_plan]);
        $result = $stmt->fetch();
        return $result['total'] > 0;
    }

    // ============================================
    // MÉTODOS DE EJECUCIÓN
    // ============================================

    // OBTENER EJECUCIÓN POR PLAN
    public static function obtenerEjecucionPorPlan($id_plan)
    {
        $db = self::db();
        $sql = "SELECT e.*, 
                       COUNT(ae.id_archivo_ejec) as total_archivos
                FROM ejecucion e
                LEFT JOIN archivos_ejecucion ae ON e.id_ejecucion = ae.id_ejecucion
                WHERE e.id_plan = ?
                GROUP BY e.id_ejecucion
                LIMIT 1";

        $stmt = $db->prepare($sql);
        $stmt->execute([$id_plan]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // GUARDAR EJECUCIÓN
    public static function guardarEjecucion($datos, $archivos)
    {
        $db = self::db();

        try {
            $db->beginTransaction();

            // Guardar o actualizar ejecución
            if (!empty($datos['id_ejecucion'])) {
                // Actualizar
                $stmt = $db->prepare("
                    UPDATE ejecucion SET 
                        nombre_ejecucion = ?,
                        resultado_final = ?,
                        observaciones_ejecucion = ?,
                        persona_responsable = ?,
                        fecha_ejecucion = ?
                    WHERE id_ejecucion = ?
                ");

                $stmt->execute([
                    $datos['nombre_ejecucion'] ?? 'Ejecución POA',
                    $datos['resultado_final'] ?? 'PENDIENTE',
                    $datos['observaciones_ejecucion'] ?? '',
                    $datos['persona_responsable'] ?? '',
                    $datos['fecha_ejecucion'],
                    $datos['id_ejecucion']
                ]);

                $id_ejecucion = $datos['id_ejecucion'];
            } else {
                // Insertar nuevo
                $stmt = $db->prepare("
                    INSERT INTO ejecucion (
                        id_plan, nombre_ejecucion, resultado_final,
                        observaciones_ejecucion, persona_responsable, fecha_ejecucion
                    ) VALUES (?, ?, ?, ?, ?, ?)
                ");

                $stmt->execute([
                    $datos['id_plan'],
                    $datos['nombre_ejecucion'] ?? 'Ejecución POA',
                    $datos['resultado_final'] ?? 'PENDIENTE',
                    $datos['observaciones_ejecucion'] ?? '',
                    $datos['persona_responsable'] ?? '',
                    $datos['fecha_ejecucion']
                ]);

                $id_ejecucion = $db->lastInsertId();
            }

            // Guardar archivo de elaboración
            if (isset($archivos['archivo_elaboracion']) && $archivos['archivo_elaboracion']['error'] === UPLOAD_ERR_OK) {
                self::guardarArchivoEjecucion($id_ejecucion, $archivos['archivo_elaboracion'], 'ELABORACION');
            }

            // Guardar archivo de seguimiento
            if (isset($archivos['archivo_seguimiento']) && $archivos['archivo_seguimiento']['error'] === UPLOAD_ERR_OK) {
                self::guardarArchivoEjecucion($id_ejecucion, $archivos['archivo_seguimiento'], 'SEGUIMIENTO');
            }

            // Guardar archivos adicionales
            if (isset($archivos['archivos_adicionales']) && count($archivos['archivos_adicionales']['name']) > 0) {
                for ($i = 0; $i < count($archivos['archivos_adicionales']['name']); $i++) {
                    if ($archivos['archivos_adicionales']['error'][$i] === UPLOAD_ERR_OK) {
                        $archivo_info = [
                            'name' => $archivos['archivos_adicionales']['name'][$i],
                            'tmp_name' => $archivos['archivos_adicionales']['tmp_name'][$i],
                            'size' => $archivos['archivos_adicionales']['size'][$i],
                            'type' => $archivos['archivos_adicionales']['type'][$i]
                        ];

                        self::guardarArchivoEjecucion($id_ejecucion, $archivo_info, 'ADICIONAL');
                    }
                }
            }

            $db->commit();
            return ['success' => true, 'id_ejecucion' => $id_ejecucion];

        } catch (PDOException $e) {
            $db->rollBack();
            error_log("Error en guardarEjecucion: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    // GUARDAR ARCHIVO DE EJECUCIÓN
    private static function guardarArchivoEjecucion($id_ejecucion, $archivo, $tipo = 'ADICIONAL')
    {
        $db = self::db();

        // Validar que sea PDF
        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        if ($extension !== 'pdf') {
            throw new Exception("Solo se permiten archivos PDF");
        }

        // Crear directorio si no existe
        $directorio = "uploads/ejecucion/" . date('Y') . "/" . date('m') . "/";
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }

        // Generar nombre único
        $nombre_unico = uniqid() . '_' . preg_replace('/[^a-z0-9\.]/i', '_', $archivo['name']);
        $ruta_completa = $directorio . $nombre_unico;

        // Mover archivo
        if (!move_uploaded_file($archivo['tmp_name'], $ruta_completa)) {
            throw new Exception("Error al subir el archivo");
        }

        // Guardar en base de datos
        $stmt = $db->prepare("
            INSERT INTO archivos_ejecucion (
                id_ejecucion, nombre_archivo, tipo_archivo,
                descripcion_archivo, ruta_archivo
            ) VALUES (?, ?, ?, ?, ?)
        ");

        $descripcion = match ($tipo) {
            'ELABORACION' => 'Documento final de elaboración',
            'SEGUIMIENTO' => 'Documento de seguimiento',
            default => 'Documento adicional de ejecución'
        };

        return $stmt->execute([
            $id_ejecucion,
            $archivo['name'],
            $tipo,
            $descripcion,
            $ruta_completa
        ]);
    }

    // OBTENER ARCHIVOS DE EJECUCIÓN
    public static function obtenerArchivosEjecucion($id_ejecucion)
    {
        if (!$id_ejecucion)
            return [];

        $db = self::db();
        $sql = "SELECT * FROM archivos_ejecucion 
                WHERE id_ejecucion = ? 
                ORDER BY fecha_subida DESC";

        $stmt = $db->prepare($sql);
        $stmt->execute([$id_ejecucion]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ELIMINAR ARCHIVO DE EJECUCIÓN
    public static function eliminarArchivoEjecucion($id_archivo)
    {
        $db = self::db();

        try {
            // Obtener ruta del archivo
            $stmt = $db->prepare("SELECT ruta_archivo FROM archivos_ejecucion WHERE id_archivo_ejec = ?");
            $stmt->execute([$id_archivo]);
            $archivo = $stmt->fetch();

            if ($archivo && file_exists($archivo['ruta_archivo'])) {
                unlink($archivo['ruta_archivo']);
            }

            // Eliminar registro
            $stmt = $db->prepare("DELETE FROM archivos_ejecucion WHERE id_archivo_ejec = ?");
            return $stmt->execute([$id_archivo]);

        } catch (PDOException $e) {
            error_log("Error al eliminar archivo: " . $e->getMessage());
            return false;
        }
    }

    // VERIFICAR SI TIENE EJECUCIÓN
    public static function tieneEjecucion($id_plan)
    {
        $db = self::db();
        $sql = "SELECT COUNT(*) as total 
                FROM ejecucion e
                WHERE e.id_plan = ?";

        $stmt = $db->prepare($sql);
        $stmt->execute([$id_plan]);
        $result = $stmt->fetch();
        return $result['total'] > 0;
    }

    // ============================================
    // MÉTODOS DE ACTUALIZACIÓN DE ESTADOS
    // ============================================

    public static function actualizarEstadoSeguimiento($id_plan, $estado)
    {
        $db = self::db();
        $stmt = $db->prepare("UPDATE planes SET estado_seguimiento = ? WHERE id_plan = ?");
        return $stmt->execute([$estado, $id_plan]);
    }

    public static function actualizarEstadoEjecucion($id_plan, $estado)
    {
        $db = self::db();
        $stmt = $db->prepare("UPDATE planes SET estado_ejecucion = ? WHERE id_plan = ?");
        return $stmt->execute([$estado, $id_plan]);
    }

    public static function actualizarEstadoPlan($id_plan, $estado)
    {
        $db = self::db();
        $stmt = $db->prepare("UPDATE planes SET estado = ? WHERE id_plan = ?");
        return $stmt->execute([$estado, $id_plan]);
    }

    // MÉTODO AUXILIAR PARA ARCHIVOS DE SEGUIMIENTO
    private static function guardarArchivoSeguimiento($id_seguimiento, $archivo)
    {
        $db = self::db();

        $directorio = "uploads/seguimiento/" . date('Y') . "/" . date('m') . "/";
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }

        $nombre_unico = uniqid() . '_' . preg_replace('/[^a-z0-9\.]/i', '_', $archivo['name']);
        $ruta_completa = $directorio . $nombre_unico;

        if (move_uploaded_file($archivo['tmp_name'], $ruta_completa)) {
            $stmt = $db->prepare("
                INSERT INTO archivos_seguimiento (id_seguimiento, nombre_archivo, tipo_archivo, ruta_archivo)
                VALUES (?, ?, 'INFORME', ?)
            ");

            return $stmt->execute([$id_seguimiento, $archivo['name'], $ruta_completa]);
        }

        return false;
    }

    // OBTENER ARCHIVOS DE SEGUIMIENTO
    public static function obtenerArchivosSeguimiento($id_seguimiento)
    {
        if (!$id_seguimiento)
            return [];

        $db = self::db();
        $sql = "SELECT * FROM archivos_seguimiento 
                WHERE id_seguimiento = ? 
                ORDER BY fecha_subida DESC";

        $stmt = $db->prepare($sql);
        $stmt->execute([$id_seguimiento]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}