<?php
session_start();

require_once 'config/database.php';
require_once 'helpers/session.php';

$action = $_GET['action'] ?? 'login';

// Validación de sesión
if (!isset($_SESSION['usuario']) && !in_array($action, ['login', 'autenticar'])) {
    header("Location: index.php?action=login");
    exit;
}

switch ($action) {
    /* ===== LOGIN ===== */
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
        require_once 'controllers/DashboardController.php';
        (new DashboardController())->index();
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

    /* ===== TEMA POA ===== */
    case 'temas_poa':
        verificarSesion();
        require_once 'controllers/TemaPoaController.php';
        (new TemaPoaController())->index();
        break;

    case 'guardarTema':
        verificarSesion();
        require_once 'controllers/TemaPoaController.php';
        (new TemaPoaController())->guardar();
        break;

    case 'editarTema':
        verificarSesion();
        require_once 'controllers/TemaPoaController.php';
        (new TemaPoaController())->editar();
        break;

    case 'eliminarTema':
        verificarSesion();
        require_once 'controllers/TemaPoaController.php';
        (new TemaPoaController())->eliminar();
        break;

    case 'estadoTema':
        verificarSesion();
        require_once 'controllers/TemaPoaController.php';
        (new TemaPoaController())->estado();
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

    case 'editarEje':
        verificarSesion();
        require_once 'controllers/EjeController.php';
        (new EjeController())->editar();
        break;

    case 'eliminarEje':
        verificarSesion();
        require_once 'controllers/EjeController.php';
        (new EjeController())->eliminar();
        break;

    /* ===== INDICADORES ===== */
    case 'indicadores':
        verificarSesion();
        require_once 'controllers/IndicadorController.php';
        (new IndicadorController())->index();
        break;

    case 'guardarIndicador':
        verificarSesion();
        require_once 'controllers/IndicadorController.php';
        (new IndicadorController())->guardar();
        break;

    case 'eliminarIndicador':
        verificarSesion();
        require_once 'controllers/IndicadorController.php';
        (new IndicadorController())->eliminar();
        break;

    /* ===== PLAZOS ===== */
    case 'plazos':
        verificarSesion();
        require_once 'controllers/PlazoController.php';
        (new PlazoController())->index();
        break;

    case 'guardarPlazo':
        verificarSesion();
        require_once 'controllers/PlazoController.php';
        (new PlazoController())->guardar();
        break;

    case 'actualizarPlazo':
        verificarSesion();
        require_once 'controllers/PlazoController.php';
        (new PlazoController())->actualizar();
        break;

    case 'eliminarPlazo':
        verificarSesion();
        require_once 'controllers/PlazoController.php';
        (new PlazoController())->eliminar();
        break;

    /* ===== RESPONSABLES ===== */
    case 'responsables':
        verificarSesion();
        require_once 'controllers/ResponsableController.php';
        (new ResponsableController())->index();
        break;

    case 'guardarResponsable':
        verificarSesion();
        require_once 'controllers/ResponsableController.php';
        (new ResponsableController())->guardar();
        break;

    case 'actualizarResponsable':
        verificarSesion();
        require_once 'controllers/ResponsableController.php';
        (new ResponsableController())->actualizar();
        break;

    case 'toggleResponsable':
        verificarSesion();
        require_once 'controllers/ResponsableController.php';
        (new ResponsableController())->toggle();
        break;

    case 'eliminarResponsable':
        verificarSesion();
        require_once 'controllers/ResponsableController.php';
        (new ResponsableController())->eliminar();
        break;

    /* ===== PLANES - ELABORACIÓN ===== */
    case 'planes':
        verificarSesion();
        require_once 'controllers/PlanController.php';
        (new PlanController())->index();
        break;

    case 'guardarPlan':
        verificarSesion();
        require_once 'controllers/PlanController.php';
        (new PlanController())->guardar();
        break;

    case 'eliminarPlan':
        verificarSesion();
        require_once 'controllers/PlanController.php';
        (new PlanController())->eliminar();
        break;

    case 'modalElaboracion':
        verificarSesion();
        require_once 'controllers/PlanController.php';
        (new PlanController())->modalElaboracion();
        break;

    case 'guardarElaboracion':
        verificarSesion();
        require_once 'controllers/PlanController.php';
        (new PlanController())->guardarElaboracion();
        break;

    case 'indicadoresPorEje':
        verificarSesion();
        require_once 'controllers/PlanController.php';
        (new PlanController())->indicadoresPorEje();
        break;

    /* ===== PLANES - SEGUIMIENTO ===== */
    case 'modalSeguimiento':
        verificarSesion();
        require_once 'controllers/PlanController.php';
        (new PlanController())->modalSeguimiento();
        break;

    case 'guardarSeguimiento':
        verificarSesion();
        require_once 'controllers/PlanController.php';
        (new PlanController())->guardarSeguimiento();
        break;

    case 'obtenerSeguimientos':
        verificarSesion();
        require_once 'controllers/PlanController.php';
        (new PlanController())->obtenerSeguimientosAjax();
        break;

    /* ===== PLANES - EJECUCIÓN ===== */
    case 'modalEjecucion':
        verificarSesion();
        require_once 'controllers/PlanController.php';
        (new PlanController())->modalEjecucion();
        break;

    case 'guardarEjecucion':
        verificarSesion();
        require_once 'controllers/PlanController.php';
        (new PlanController())->guardarEjecucion();
        break;

    case 'eliminarArchivoEjecucion':
        verificarSesion();
        require_once 'controllers/PlanController.php';
        (new PlanController())->eliminarArchivoEjecucion();
        break;

    case 'verificarEstados':
        verificarSesion();
        require_once 'controllers/PlanController.php';
        (new PlanController())->verificarEstados();
        break;

    /* ===== MÉTODOS ADICIONALES ===== */
    case 'detallePlan':
        verificarSesion();
        require_once 'controllers/PlanController.php';
        (new PlanController())->detalle();
        break;

    case 'testDatos':
        verificarSesion();
        require_once 'controllers/PlanController.php';
        (new PlanController())->testDatos();
        break;

    default:
        if (isset($_SESSION['usuario'])) {
            header("Location: index.php?action=dashboard");
        } else {
            header("Location: index.php?action=login");
        }
        break;
}