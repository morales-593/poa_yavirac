<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function verificarSesion() {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?action=login");
        exit;
    }
}

function cerrarSesion() {
    session_destroy();
    header("Location: index.php?action=login");
    exit;
}
