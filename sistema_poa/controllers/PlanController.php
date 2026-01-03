<?php
require_once 'models/Plan.php';

class PlanController
{
    public function index()
    {
        $planes = Plan::all();
        require 'views/layout/header.php';
        require 'views/planes/index.php';
        require 'views/layout/footer.php';
    }

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

    public function guardarElaboracion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar datos requeridos
            $datosRequeridos = ['id_plan', 'id_indicador', 'id_tema', 'id_responsable', 'linea_base', 'actividades'];
            foreach ($datosRequeridos as $campo) {
                if (empty($_POST[$campo])) {
                    die("Error: El campo $campo es requerido");
                }
            }
            
            // Guardar en la base de datos
            $resultado = Plan::guardarElaboracion($_POST);
            
            if ($resultado) {
                // Redirigir con mensaje de éxito
                $_SESSION['mensaje'] = 'Elaboración guardada correctamente';
                $_SESSION['tipo_mensaje'] = 'success';
            } else {
                $_SESSION['mensaje'] = 'Error al guardar la elaboración';
                $_SESSION['tipo_mensaje'] = 'error';
            }
            
            header("Location: index.php?action=planes");
            exit;
        }
    }

    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultado = Plan::guardar(
                $_POST['nombre_elaborado'],
                $_POST['nombre_responsable'],
                $_SESSION['usuario']['id_usuario'] ?? 1
            );
            
            if ($resultado) {
                $_SESSION['mensaje'] = 'Plan creado correctamente';
                $_SESSION['tipo_mensaje'] = 'success';
            } else {
                $_SESSION['mensaje'] = 'Error al crear el plan';
                $_SESSION['tipo_mensaje'] = 'error';
            }
            
            header("Location: index.php?action=planes");
            exit;
        }
    }
    
    public function eliminar()
    {
        $id = $_GET['id'] ?? 0;
        if ($id > 0) {
            $resultado = Plan::eliminar($id);
            
            if ($resultado) {
                $_SESSION['mensaje'] = 'Plan eliminado correctamente';
                $_SESSION['tipo_mensaje'] = 'success';
            } else {
                $_SESSION['mensaje'] = 'Error al eliminar el plan';
                $_SESSION['tipo_mensaje'] = 'error';
            }
        }
        
        header("Location: index.php?action=planes");
        exit;
    }
    
    // Método para probar datos (temporal)
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
        exit;
    }
}