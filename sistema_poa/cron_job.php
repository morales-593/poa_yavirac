<?php
// cron_job.php - Limpieza automática de archivos temporales
// Ejecutar periódicamente (ej: cada día a las 3 AM)

// Configurar zona horaria
date_default_timezone_set('America/Guayaquil');

// Registrar inicio
$logFile = __DIR__ . '/logs/cron.log';
$startTime = date('Y-m-d H:i:s');
file_put_contents($logFile, "[" . $startTime . "] INICIO: Ejecutando limpieza de archivos temporales\n", FILE_APPEND);

try {
    // Incluir clases necesarias
    require_once __DIR__ . '/config/database.php';
    require_once __DIR__ . '/models/Plan.php';
    
    // Verificar que la clase Plan existe
    if (!class_exists('Plan')) {
        throw new Exception("Clase Plan no encontrada");
    }
    
    // Limpiar archivos temporales de más de 24 horas
    Plan::limpiarArchivosTemporales(24);
    
    // Registrar éxito
    $message = "[" . date('Y-m-d H:i:s') . "] ÉXITO: Limpieza completada\n";
    file_put_contents($logFile, $message, FILE_APPEND);
    
    echo $message;
    
} catch (Exception $e) {
    // Registrar error
    $errorMessage = "[" . date('Y-m-d H:i:s') . "] ERROR: " . $e->getMessage() . "\n";
    file_put_contents($logFile, $errorMessage, FILE_APPEND);
    
    echo $errorMessage;
}
?>