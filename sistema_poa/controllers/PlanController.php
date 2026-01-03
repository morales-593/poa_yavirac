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
        while (ob_get_level()) ob_end_clean();
        
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
    
    // MÉTODO PARA PROBAR DATOS
    public function testDatos()
    {
        echo "<h2>Test de Datos del Sistema</h2>";
        
        // Test 1: Ver ejes
        $ejes = Plan::ejes();
        echo "<h3>Ejes disponibles (" . count($ejes) . "):</h3>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Objetivo</th></tr>";
        foreach ($ejes as $eje) {
            echo "<tr>";
            echo "<td>" . $eje['id_eje'] . "</td>";
            echo "<td>" . $eje['nombre_eje'] . "</td>";
            echo "<td>" . (isset($eje['descripcion_objetivo']) ? substr($eje['descripcion_objetivo'], 0, 100) . "..." : "SIN OBJETIVO") . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Test 2: Ver indicadores para cada eje
        echo "<h3>Indicadores por Eje:</h3>";
        foreach ($ejes as $eje) {
            $indicadores = Plan::indicadoresPorEje($eje['id_eje']);
            echo "<h4>Eje: " . $eje['nombre_eje'] . " (ID: " . $eje['id_eje'] . ") - " . count($indicadores) . " indicadores</h4>";
            if (count($indicadores) > 0) {
                echo "<ul>";
                foreach ($indicadores as $ind) {
                    echo "<li>[" . $ind['codigo'] . "] " . $ind['descripcion'] . " (ID: " . $ind['id_indicador'] . ")</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No hay indicadores</p>";
            }
        }
        
        // Test 3: Ver planes
        $planes = Plan::all();
        echo "<h3>Planes disponibles (" . count($planes) . "):</h3>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Elaborado por</th><th>Responsable</th><th>Estado</th><th>Fecha</th></tr>";
        foreach ($planes as $p) {
            echo "<tr>";
            echo "<td>" . $p['id_plan'] . "</td>";
            echo "<td>" . $p['nombre_elaborado'] . "</td>";
            echo "<td>" . $p['nombre_responsable'] . "</td>";
            echo "<td>" . $p['estado'] . "</td>";
            echo "<td>" . $p['fecha_creacion'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        exit;
    }
}