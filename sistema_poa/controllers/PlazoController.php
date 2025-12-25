<?php
require_once 'models/Plazo.php';

class PlazoController {

    public function index() {
        $plazos = Plazo::all();
        require_once 'views/layout/header.php';
        require_once 'views/plazos/index.php';
        require_once 'views/layout/footer.php';
    }

    public function guardar() {
        Plazo::create($_POST['nombre_plazo']);
        header("Location: index.php?action=plazos");
    }

    public function actualizar() {
        Plazo::update($_GET['id'], $_POST['nombre_plazo']);
        header("Location: index.php?action=plazos");
    }

    public function eliminar() {
        Plazo::delete($_GET['id']);
        header("Location: index.php?action=plazos");
    }
}
