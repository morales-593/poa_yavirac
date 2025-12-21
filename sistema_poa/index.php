<?php
session_start();

require_once 'config/database.php';
require_once 'controllers/LoginController.php';

$action = $_GET['action'] ?? 'login';

$login = new LoginController();

switch ($action) {
    case 'login':
        $login->index();
        break;

    case 'autenticar':
        $login->autenticar();
        break;

    case 'logout':
        $login->logout();
        break;

    case 'dashboard':
        require_once 'helpers/session.php';
        verificarSesion();
        echo "<h1>Dashboard POA</h1>";
        echo "<a href='index.php?action=logout'>Salir</a>";
        break;
    case 'ejes':
        require 'controllers/EjeController.php';
        (new EjeController)->index();
        break;

    case 'guardarEje':
        require 'controllers/EjeController.php';
        (new EjeController)->guardar();
        break;

    case 'objetivos':
        require 'controllers/ObjetivoController.php';
        (new ObjetivoController)->index();
        break;

    case 'guardarObjetivo':
        require 'controllers/ObjetivoController.php';
        (new ObjetivoController)->guardar();
        break;

    case 'temas':
        require 'controllers/TemaController.php';
        (new TemaController)->index();
        break;

    case 'guardarTema':
        require 'controllers/TemaController.php';
        (new TemaController)->guardar();
        break;

    case 'indicadores':
        require 'controllers/IndicadorController.php';
        (new IndicadorController)->index();
        break;

    case 'guardarIndicador':
        require 'controllers/IndicadorController.php';
        (new IndicadorController)->guardar();
        break;

    case 'responsables':
        require 'controllers/ResponsableController.php';
        (new ResponsableController)->index();
        break;

    case 'guardarResponsable':
        require 'controllers/ResponsableController.php';
        (new ResponsableController)->guardar();
        break;

    default:
        $login->index();
}
