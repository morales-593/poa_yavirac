<?php
require_once 'models/Indicador.php';

class IndicadorController {

    public function index() {
        $indicadores = Indicador::getAll();
        $ejes = Indicador::getEjes();
        require_once 'views/layout/header.php';
        require_once 'views/indicadores/index.php';
        require_once 'views/layout/footer.php';
    }

    public function guardar() {
        Indicador::create($_POST['codigo'], $_POST['descripcion'], $_POST['id_eje']);
        header("Location: index.php?action=indicadores");
        exit;
    }

    public function eliminar() {
        Indicador::delete($_GET['id']);
        header("Location: index.php?action=indicadores");
        exit;
    }
}
