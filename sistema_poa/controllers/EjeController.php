<?php
require_once 'helpers/session.php';
require_once 'models/Eje.php';

class EjeController {

    public function index() {
        $ejes = Eje::getAll();
        require_once 'views/layout/header.php';
        require_once 'views/ejes/index.php';
        require_once 'views/layout/footer.php';
    }

    public function guardar() {
        Eje::create($_POST['nombre_eje'], $_POST['descripcion_objetivo']);
        header("Location: index.php?action=ejes");
        exit;
    }

    public function editar() {
        Eje::update($_GET['id'], $_POST['nombre_eje'], $_POST['descripcion_objetivo']);
        header("Location: index.php?action=ejes");
        exit;
    }

    public function eliminar() {
        Eje::delete($_GET['id']);
        header("Location: index.php?action=ejes");
        exit;
    }
}
