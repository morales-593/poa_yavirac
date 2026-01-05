<?php
// Archivo de prueba: test_permissions.php
echo "Probando permisos...<br>";

$directorios = [
    'uploads/' => 'uploads',
    'uploads/temp/' => 'uploads/temp',
    'uploads/ejecucion/' => 'uploads/ejecucion',
    'uploads/seguimiento/' => 'uploads/seguimiento',
    'logs/' => 'logs'
];

foreach ($directorios as $ruta => $nombre) {
    if (!file_exists($ruta)) {
        if (mkdir($ruta, 0777, true)) {
            echo "✓ Carpeta $nombre creada<br>";
        } else {
            echo "✗ ERROR: No se pudo crear $nombre<br>";
        }
    } else {
        if (is_writable($ruta)) {
            echo "✓ Carpeta $nombre tiene permisos de escritura<br>";
        } else {
            echo "✗ ADVERTENCIA: $nombre NO tiene permisos de escritura<br>";
        }
    }
}

// Probar conexión a BD
try {
    require_once 'config/database.php';
    $db = Database::connect();
    echo "✓ Conexión a base de datos exitosa<br>";
} catch (Exception $e) {
    echo "✗ ERROR en conexión BD: " . $e->getMessage() . "<br>";
}
?>