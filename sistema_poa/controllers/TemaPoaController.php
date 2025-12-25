<?php
require_once 'models/TemaPoa.php';

class TemaPoaController {

    public function index() {
        $temas = TemaPoa::getAll();
        require_once 'views/layout/header.php';
        require_once 'views/temas_poa/index.php';
        require_once 'views/layout/footer.php';
    }

    public function guardar() {
        TemaPoa::create($_POST['descripcion']);
        header("Location: index.php?action=temas_poa");
        exit;
    }

    public function editar() {
        TemaPoa::update($_GET['id'], $_POST['descripcion'], $_POST['estado']);
        header("Location: index.php?action=temas_poa");
        exit;
    }

    public function eliminar() {
        TemaPoa::delete($_GET['id']);
        header("Location: index.php?action=temas_poa");
        exit;
    }
    public function estado() {
    TemaPoa::cambiarEstado($_GET['id'], $_GET['estado']);
    header("Location: index.php?action=temas_poa");
    exit;
}

}
