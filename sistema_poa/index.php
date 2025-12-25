<?php
session_start();

require_once 'config/database.php';
require_once 'helpers/session.php';

$action = $_GET['action'] ?? 'login';

if (!isset($_SESSION['usuario']) && !in_array($action, ['login', 'autenticar'])) {
    header("Location: index.php?action=login");
    exit;
}

switch ($action) {
    /* ===== login ===== */
    case 'login':
        require_once 'controllers/LoginController.php';
        (new LoginController())->index();
        break;

    case 'autenticar':
        require_once 'controllers/LoginController.php';
        (new LoginController())->autenticar();
        break;

    case 'logout':
        require_once 'controllers/LoginController.php';
        (new LoginController())->logout();
        break;

    case 'dashboard':
        verificarSesion();
        require_once 'views/dashboard/index.php';
        break;

    /* ===== USUARIOS ===== */

    case 'usuarios':
        verificarSesion();
        require_once __DIR__ . '/controllers/UsuarioController.php';
        (new UsuarioController())->index();
        break;

    case 'crearUsuario':
        verificarSesion();
        require_once __DIR__ . '/controllers/UsuarioController.php';
        (new UsuarioController())->crear();
        break;

    case 'editarUsuario':
        verificarSesion();
        require_once __DIR__ . '/controllers/UsuarioController.php';
        (new UsuarioController())->editar();
        break;

    case 'eliminarUsuario':
        verificarSesion();
        require_once __DIR__ . '/controllers/UsuarioController.php';
        (new UsuarioController())->eliminar();
        break;


    /* ===== EJES ===== */

    case 'ejes':
        verificarSesion();
        require_once 'controllers/EjeController.php';
        (new EjeController())->index();
        break;

    case 'guardarEje':
        verificarSesion();
        require_once 'controllers/EjeController.php';
        (new EjeController())->guardar();
        break;

    default:
        header("Location: index.php?action=login");
        break;
}
