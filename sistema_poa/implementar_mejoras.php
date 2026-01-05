<?php
// implementar_mejoras.php
echo "<h2>Implementando mejoras para timeout</h2>";

// 1. Crear directorios necesarios
$directorios = [
    'uploads/temp',
    'logs',
    'uploads/ejecucion/' . date('Y'),
    'uploads/seguimiento/' . date('Y')
];

foreach ($directorios as $dir) {
    if (!file_exists($dir)) {
        if (mkdir($dir, 0777, true)) {
            echo "✓ Directorio creado: $dir<br>";
        } else {
            echo "✗ Error creando: $dir<br>";
        }
    } else {
        echo "✓ Directorio ya existe: $dir<br>";
    }
}

// 2. Crear cron_job.php
$cronContent = '<?php
// cron_job.php
date_default_timezone_set(\'America/Guayaquil\');
require_once __DIR__ . \'/config/database.php\';
require_once __DIR__ . \'/models/Plan.php\';

if (class_exists(\'Plan\')) {
    Plan::limpiarArchivosTemporales(24);
    error_log("[" . date(\'Y-m-d H:i:s\') . "] Limpieza automática ejecutada");
    echo "Limpieza completada";
}
?>';

if (file_put_contents('cron_job.php', $cronContent)) {
    echo "✓ Archivo cron_job.php creado<br>";
} else {
    echo "✗ Error creando cron_job.php<br>";
}

// 3. Verificar archivos que deben actualizarse
$archivos = [
    'models/Plan.php' => 'Debe ser reemplazado con el código optimizado',
    'views/planes/modal_ejecucion.php' => 'Debe ser reemplazado con la vista optimizada',
    'controllers/PlanController.php' => 'Debe actualizarse el método guardarEjecucion'
];

echo "<h3>Archivos a actualizar manualmente:</h3>";
foreach ($archivos as $archivo => $descripcion) {
    if (file_exists($archivo)) {
        echo "• <strong>$archivo</strong> - $descripcion<br>";
    } else {
        echo "• ✗ <strong>$archivo</strong> - NO EXISTE<br>";
    }
}

echo "<hr><h3>CONFIGURACIÓN COMPLETADA</h3>";
echo "Ahora debes:<br>";
echo "1. Reemplazar models/Plan.php con el código proporcionado<br>";
echo "2. Actualizar el método guardarEjecucion en controllers/PlanController.php<br>";
echo "3. Reemplazar views/planes/modal_ejecucion.php<br>";
echo "4. Probar subiendo archivos desde la ejecución<br>";

echo "<br><a href='index.php?action=planes'>Ir a Planes</a>";
?>