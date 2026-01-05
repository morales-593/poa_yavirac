<?php
// test_ejecucion.php
require_once 'config/database.php';
require_once 'models/Plan.php';

echo "<h2>Test del sistema de ejecución</h2>";

// 1. Probar conexión
try {
    $db = Database::connect();
    echo "✓ Conexión BD OK<br>";
} catch (Exception $e) {
    echo "✗ Error BD: " . $e->getMessage() . "<br>";
}

// 2. Probar existencia de tablas
$tablas = ['ejecucion', 'archivos_ejecucion', 'seguimiento', 'planes'];
foreach ($tablas as $tabla) {
    try {
        $stmt = $db->query("SELECT COUNT(*) as total FROM $tabla LIMIT 1");
        $result = $stmt->fetch();
        echo "✓ Tabla '$tabla' existe (" . $result['total'] . " registros)<br>";
    } catch (Exception $e) {
        echo "✗ Tabla '$tabla' NO existe: " . $e->getMessage() . "<br>";
    }
}

// 3. Probar método limpiarArchivosTemporales
if (method_exists('Plan', 'limpiarArchivosTemporales')) {
    echo "✓ Método limpiarArchivosTemporales existe<br>";
    
    // Crear archivo temporal de prueba
    $testFile = 'uploads/temp/test_' . time() . '.txt';
    file_put_contents($testFile, 'test');
    
    if (file_exists($testFile)) {
        echo "✓ Archivo temporal creado: $testFile<br>";
        
        // Llamar al método (no debería eliminar archivos nuevos)
        Plan::limpiarArchivosTemporales(24);
        
        if (file_exists($testFile)) {
            echo "✓ Archivo temporal NO eliminado (es nuevo)<br>";
            unlink($testFile); // Limpiar
        }
    }
} else {
    echo "✗ Método limpiarArchivosTemporales NO existe<br>";
}

// 4. Verificar plan existente para pruebas
$planes = $db->query("SELECT id_plan, nombre_elaborado FROM planes LIMIT 2")->fetchAll();
echo "<h3>Planes disponibles para pruebas:</h3>";
foreach ($planes as $plan) {
    echo "ID: {$plan['id_plan']} - {$plan['nombre_elaborado']}<br>";
}

echo "<hr><h3>Prueba completada</h3>";
?>