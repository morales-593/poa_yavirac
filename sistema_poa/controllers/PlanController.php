<?php
require_once 'models/Plan.php';

class PlanController
{
    // MOSTRAR TODOS LOS PLANES
    public function index()
    {
        $planes = Plan::all();
        require 'views/layout/header.php';
        require 'views/planes/index.php';
        require 'views/layout/footer.php';
    }

    // MOSTRAR MODAL DE ELABORACIÓN
    public function modalElaboracion()
    {
        $id_plan = $_GET['id_plan'];
        $plan = Plan::find($id_plan);
        $elab = Plan::elaboracionPorPlan($id_plan);
        $ejes = Plan::ejes();
        $temas = Plan::temas();
        $responsables = Plan::responsables();
        $plazos = Plan::plazos();

        // Obtener el eje actual si ya hay un indicador seleccionado
        $eje_actual = null;
        if ($elab && isset($elab['id_indicador'])) {
            $eje_actual = Plan::obtenerEjePorIndicador($elab['id_indicador']);
        }

        require 'views/planes/modal_elaboracion.php';
    }

    // OBTENER INDICADORES POR EJE (AJAX)
    public function indicadoresPorEje()
    {
        // Limpiar buffer de salida
        while (ob_get_level())
            ob_end_clean();

        header('Content-Type: application/json');

        $id_eje = $_GET['id_eje'] ?? 0;

        if (!is_numeric($id_eje) || $id_eje <= 0) {
            echo json_encode([]);
            exit;
        }

        $indicadores = Plan::indicadoresPorEje($id_eje);
        echo json_encode($indicadores);
        exit;
    }

    // GUARDAR ELABORACIÓN
    public function guardarElaboracion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar datos requeridos
            $datosRequeridos = ['id_plan', 'id_indicador', 'id_tema', 'id_responsable', 'linea_base', 'actividades'];
            $errores = [];

            foreach ($datosRequeridos as $campo) {
                if (empty($_POST[$campo])) {
                    $errores[] = "El campo <strong>$campo</strong> es requerido";
                }
            }

            // Validar medios de verificación
            if (empty($_POST['detalle']) || !is_array($_POST['detalle'])) {
                $errores[] = "Debe agregar al menos un medio de verificación";
            } else {
                // Validar que cada medio tenga descripción y plazo
                foreach ($_POST['detalle'] as $index => $detalle) {
                    if (empty(trim($detalle))) {
                        $errores[] = "La descripción del medio #" . ($index + 1) . " es requerida";
                    }
                    if (empty($_POST['id_plazo'][$index])) {
                        $errores[] = "El plazo del medio #" . ($index + 1) . " es requerido";
                    }
                }
            }

            if (!empty($errores)) {
                $_SESSION['mensaje'] = '<div class="text-start"><strong>Errores de validación:</strong><br>' . implode('<br>', $errores) . '</div>';
                $_SESSION['tipo_mensaje'] = 'error';
                header("Location: index.php?action=planes");
                exit;
            }

            // Guardar en la base de datos
            $resultado = Plan::guardarElaboracion($_POST);

            if ($resultado['success']) {
                $_SESSION['mensaje'] = '<div class="text-center"><i class="fas fa-check-circle fa-2x text-success mb-2"></i><br><strong>¡Éxito!</strong><br>Elaboración guardada correctamente</div>';
                $_SESSION['tipo_mensaje'] = 'success';
            } else {
                $_SESSION['mensaje'] = '<div class="text-center"><i class="fas fa-times-circle fa-2x text-danger mb-2"></i><br><strong>Error:</strong><br>' . ($resultado['error'] ?? 'No se pudo guardar la elaboración') . '</div>';
                $_SESSION['tipo_mensaje'] = 'error';
            }

            header("Location: index.php?action=planes");
            exit;
        }
    }

    // GUARDAR NUEVO PLAN
    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar datos
            if (empty($_POST['nombre_elaborado']) || empty($_POST['nombre_responsable'])) {
                $_SESSION['mensaje'] = '<div class="text-center"><i class="fas fa-exclamation-triangle fa-2x text-warning mb-2"></i><br><strong>Advertencia:</strong><br>Todos los campos son requeridos</div>';
                $_SESSION['tipo_mensaje'] = 'warning';
                header("Location: index.php?action=planes");
                exit;
            }

            $resultado = Plan::guardar(
                $_POST['nombre_elaborado'],
                $_POST['nombre_responsable'],
                $_SESSION['usuario']['id_usuario'] ?? 1
            );

            if ($resultado) {
                $_SESSION['mensaje'] = '<div class="text-center"><i class="fas fa-check-circle fa-2x text-success mb-2"></i><br><strong>¡Éxito!</strong><br>Plan creado correctamente</div>';
                $_SESSION['tipo_mensaje'] = 'success';
            } else {
                $_SESSION['mensaje'] = '<div class="text-center"><i class="fas fa-times-circle fa-2x text-danger mb-2"></i><br><strong>Error:</strong><br>No se pudo crear el plan</div>';
                $_SESSION['tipo_mensaje'] = 'error';
            }

            header("Location: index.php?action=planes");
            exit;
        }
    }

    // ELIMINAR PLAN
    public function eliminar()
    {
        $id = $_GET['id'] ?? 0;
        if ($id > 0) {
            $resultado = Plan::eliminar($id);

            if ($resultado) {
                $_SESSION['mensaje'] = '<div class="text-center"><i class="fas fa-check-circle fa-2x text-success mb-2"></i><br><strong>¡Éxito!</strong><br>Plan eliminado correctamente</div>';
                $_SESSION['tipo_mensaje'] = 'success';
            } else {
                $_SESSION['mensaje'] = '<div class="text-center"><i class="fas fa-times-circle fa-2x text-danger mb-2"></i><br><strong>Error:</strong><br>No se pudo eliminar el plan</div>';
                $_SESSION['tipo_mensaje'] = 'error';
            }
        }

        header("Location: index.php?action=planes");
        exit;
    }

    // MOSTRAR DETALLE DE PLAN
    public function detalle()
    {
        $id_plan = $_GET['id'] ?? 0;
        if ($id_plan <= 0) {
            header("Location: index.php?action=planes");
            exit;
        }

        $plan = Plan::find($id_plan);
        $elab = Plan::elaboracionPorPlan($id_plan);

        if (!$plan) {
            header("Location: index.php?action=planes");
            exit;
        }

        require 'views/layout/header.php';
        require 'views/planes/detalle.php';
        require 'views/layout/footer.php';
    }

    // ============================================
    // SEGUIMIENTO
    // ============================================

    // MOSTRAR MODAL DE SEGUIMIENTO
    public function modalSeguimiento()
    {
        $id_plan = $_GET['id_plan'] ?? 0;

        // Verificar que exista elaboración
        $plan = Plan::find($id_plan);
        if (!$plan) {
            echo '<div class="alert alert-danger">El plan no existe</div>';
            exit;
        }

        // Verificar que tenga elaboración
        $elaboracion = Plan::elaboracionPorPlan($id_plan);
        if (!$elaboracion) {
            echo '<div class="alert alert-warning">Debe completar la elaboración antes del seguimiento</div>';
            exit;
        }

        // Obtener datos completos
        $datos_elaboracion = Plan::obtenerElaboracionCompleta($elaboracion['id_elaboracion']);
        $medios_verificacion = Plan::obtenerMediosVerificacion($elaboracion['id_elaboracion']);
        $seguimiento_existente = Plan::obtenerSeguimiento($elaboracion['id_elaboracion']);

        // Obtener calificaciones detalladas si existe seguimiento
        $calificaciones_detalladas = [];
        if ($seguimiento_existente && isset($seguimiento_existente['id_seguimiento'])) {
            $calificaciones_detalladas = Plan::obtenerCalificacionesMedios($seguimiento_existente['id_seguimiento']);
        }

        require 'views/planes/modal_seguimiento.php';
    }

    // GUARDAR SEGUIMIENTO CON CALIFICACIÓN
    public function guardarSeguimiento()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $id_elaboracion = $_POST['id_elaboracion'] ?? 0;
                $id_plan = $_POST['id_plan'] ?? 0;

                if (!$id_elaboracion || !$id_plan) {
                    throw new Exception("Datos incompletos");
                }

                // Validar fecha de seguimiento
                if (empty($_POST['fecha_seguimiento'])) {
                    throw new Exception("La fecha de seguimiento es obligatoria");
                }

                // Obtener medios de verificación
                $medios_verificacion = Plan::obtenerMediosVerificacion($id_elaboracion);
                if (empty($medios_verificacion)) {
                    throw new Exception("No hay medios de verificación definidos");
                }

                // Preparar datos de medios
                $medios_data = [];
                foreach ($medios_verificacion as $index => $medio) {
                    $cumplimiento = $_POST["cumplimiento_$index"] ?? 'NO';

                    $medios_data[] = [
                        'id_medio' => $medio['id_medio'],
                        'cumplimiento' => $cumplimiento,
                        'observacion' => $_POST["observacion_medio_$index"] ?? ''
                    ];
                }

                // Preparar datos completos
                $datos = [
                    'id_elaboracion' => $id_elaboracion,
                    'fecha_seguimiento' => $_POST['fecha_seguimiento'],
                    'observacion_general' => $_POST['observacion_general'] ?? '',
                    'medios' => $medios_data
                ];

                // Agregar archivo si existe
                if (isset($_FILES['archivo_seguimiento']) && $_FILES['archivo_seguimiento']['error'] === UPLOAD_ERR_OK) {
                    $datos['archivo_seguimiento'] = $_FILES['archivo_seguimiento'];
                }

                // Guardar seguimiento
                $resultado = Plan::guardarSeguimiento($datos);

                if ($resultado['success']) {
                    // Actualizar estado en planes
                    Plan::actualizarEstadoSeguimiento($id_plan, 'COMPLETADO');

                    // Guardar calificación en sesión para mostrar
                    $_SESSION['calificacion_seguimiento'] = $resultado['calificacion'] ?? null;

                    $_SESSION['mensaje'] = '<div class="text-center">
                        <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                        <br><strong>¡Éxito!</strong>
                        <br>Seguimiento guardado correctamente
                        <br><small>Calificación: ' . ($resultado['calificacion']['calificacion'] ?? 'N/A') . ' (' . ($resultado['calificacion']['porcentaje'] ?? 0) . '%)</small>
                    </div>';
                    $_SESSION['tipo_mensaje'] = 'success';
                } else {
                    throw new Exception($resultado['error'] ?? 'Error al guardar seguimiento');
                }

            } catch (Exception $e) {
                $_SESSION['mensaje'] = '<div class="text-center">
                    <i class="fas fa-times-circle fa-2x text-danger mb-2"></i>
                    <br><strong>Error:</strong>
                    <br>' . $e->getMessage() . '
                </div>';
                $_SESSION['tipo_mensaje'] = 'error';
            }

            header("Location: index.php?action=planes");
            exit;
        }
    }

    // OBTENER CALIFICACIÓN (AJAX)
    public function obtenerCalificacion()
    {
        header('Content-Type: application/json');

        $id_elaboracion = $_GET['id_elaboracion'] ?? 0;

        if (!$id_elaboracion) {
            echo json_encode(['error' => 'ID no válido']);
            exit;
        }

        $calificacion = Plan::obtenerResumenCalificacion($id_elaboracion);
        echo json_encode($calificacion ?: ['error' => 'No hay calificación']);
        exit;
    }

    // ============================================
    // EJECUCIÓN
    // ============================================

    // MOSTRAR MODAL DE EJECUCIÓN
    public function modalEjecucion()
    {
        $id_plan = $_GET['id_plan'] ?? 0;

        // Verificar que exista elaboración
        $plan = Plan::find($id_plan);
        if (!$plan) {
            echo '<div class="alert alert-danger">El plan no existe</div>';
            exit;
        }

        // Verificar que tenga elaboración
        $elaboracion = Plan::elaboracionPorPlan($id_plan);
        if (!$elaboracion) {
            echo '<div class="alert alert-warning">Debe completar la elaboración antes de la ejecución</div>';
            exit;
        }

        // Obtener datos completos
        $datos_elaboracion = Plan::obtenerElaboracionCompleta($elaboracion['id_elaboracion']);
        $ejecucion_existente = Plan::obtenerEjecucionPorPlan($id_plan);
        $archivos_ejecucion = Plan::obtenerArchivosEjecucion($ejecucion_existente['id_ejecucion'] ?? 0);

        require 'views/planes/modal_ejecucion.php';
    }

    // GUARDAR EJECUCIÓN (OPTIMIZADO)
    public function guardarEjecucion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $id_plan = $_POST['id_plan'] ?? 0;

                if (!$id_plan) {
                    throw new Exception("Plan no especificado");
                }

                // Validar campos requeridos
                $camposRequeridos = [
                    'fecha_ejecucion' => 'Fecha de ejecución',
                    'persona_responsable' => 'Persona responsable',
                    'resultado_final' => 'Resultado final'
                ];

                $errores = [];
                foreach ($camposRequeridos as $campo => $nombre) {
                    if (empty($_POST[$campo])) {
                        $errores[] = "El campo <strong>$nombre</strong> es obligatorio";
                        // Marcar campo como inválido para CSS
                        $_SESSION['campo_invalido'] = $campo;
                    }
                }

                if (!empty($errores)) {
                    throw new Exception(implode('<br>', $errores));
                }

                // Validar archivos mínimos
                if (
                    !isset($_FILES['archivo_elaboracion']) || $_FILES['archivo_elaboracion']['error'] !== UPLOAD_ERR_OK ||
                    !isset($_FILES['archivo_seguimiento']) || $_FILES['archivo_seguimiento']['error'] !== UPLOAD_ERR_OK
                ) {
                    throw new Exception("Debe adjuntar ambos archivos: Documento de Elaboración y Documento de Seguimiento");
                }

                // Limpiar archivos temporales antiguos antes de procesar
                Plan::limpiarArchivosTemporales();

                // Guardar ejecución
                $resultado = Plan::guardarEjecucion($_POST, $_FILES);

                if ($resultado['success']) {
                    // Actualizar estado en planes
                    Plan::actualizarEstadoEjecucion($id_plan, 'COMPLETADO');

                    // Si todas las etapas están completas, marcar plan como completado
                    if (
                        Plan::tieneElaboracion($id_plan) &&
                        Plan::tieneSeguimiento($id_plan) &&
                        Plan::tieneEjecucion($id_plan)
                    ) {
                        Plan::actualizarEstadoPlan($id_plan, 'COMPLETADO');
                    }

                    $_SESSION['mensaje'] = '<div class="text-center">
                        <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                        <br><strong>¡Éxito!</strong>
                        <br>Ejecución guardada correctamente
                        <br><small>Los archivos se han procesado exitosamente</small>
                    </div>';
                    $_SESSION['tipo_mensaje'] = 'success';
                    
                    // Redirigir limpiando el formulario
                    header("Location: index.php?action=planes&refresh=" . time());
                    exit;
                } else {
                    throw new Exception($resultado['error'] ?? 'Error al guardar ejecución');
                }

            } catch (Exception $e) {
                $_SESSION['mensaje'] = '<div class="text-center">
                    <i class="fas fa-times-circle fa-2x text-danger mb-2"></i>
                    <br><strong>Error:</strong>
                    <br>' . $e->getMessage() . '
                </div>';
                $_SESSION['tipo_mensaje'] = 'error';
                
                // Mantener los datos del formulario en sesión para rellenar
                $_SESSION['form_data'] = $_POST;
                
                header("Location: index.php?action=modalEjecucion&id_plan=" . $id_plan);
                exit;
            }
        }
    }

    // ELIMINAR ARCHIVO DE EJECUCIÓN
    public function eliminarArchivoEjecucion()
    {
        $id_archivo = $_GET['id'] ?? 0;
        $id_plan = $_GET['id_plan'] ?? 0;

        if ($id_archivo > 0) {
            $resultado = Plan::eliminarArchivoEjecucion($id_archivo);

            if ($resultado) {
                $_SESSION['mensaje'] = '<div class="text-center"><i class="fas fa-check-circle fa-2x text-success mb-2"></i><br><strong>¡Éxito!</strong><br>Archivo eliminado</div>';
                $_SESSION['tipo_mensaje'] = 'success';
            } else {
                $_SESSION['mensaje'] = '<div class="text-center"><i class="fas fa-times-circle fa-2x text-danger mb-2"></i><br><strong>Error:</strong><br>No se pudo eliminar el archivo</div>';
                $_SESSION['tipo_mensaje'] = 'error';
            }
        }

        header("Location: index.php?action=modalEjecucion&id_plan=" . $id_plan);
        exit;
    }

    // OBTENER SEGUIMIENTOS (AJAX)
    public function obtenerSeguimientosAjax()
    {
        header('Content-Type: application/json');

        $id_elaboracion = $_GET['id_elaboracion'] ?? 0;

        if (!$id_elaboracion) {
            echo json_encode([]);
            exit;
        }

        $seguimientos = Plan::obtenerSeguimientos($id_elaboracion);
        echo json_encode($seguimientos);
        exit;
    }

    // VERIFICAR DISPONIBILIDAD DE BOTONES
    public function verificarEstados()
    {
        $id_plan = $_GET['id_plan'] ?? 0;

        header('Content-Type: application/json');

        if (!$id_plan) {
            echo json_encode(['error' => 'ID no válido']);
            exit;
        }

        $estados = [
            'tiene_elaboracion' => Plan::tieneElaboracion($id_plan),
            'tiene_seguimiento' => Plan::tieneSeguimiento($id_plan),
            'tiene_ejecucion' => Plan::tieneEjecucion($id_plan)
        ];

        echo json_encode($estados);
        exit;
    }
}