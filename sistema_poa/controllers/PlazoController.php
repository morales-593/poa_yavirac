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
        if (Plazo::create($_POST['nombre_plazo'])) {
            header("Location: index.php?action=plazos&mensaje=Plazo+creado+correctamente");
        } else {
            header("Location: index.php?action=plazos&error=Error+al+crear+plazo");
        }
        exit();
    }

    public function actualizar() {
        if (Plazo::update($_GET['id'], $_POST['nombre_plazo'])) {
            header("Location: index.php?action=plazos&mensaje=Plazo+actualizado+correctamente");
        } else {
            header("Location: index.php?action=plazos&error=Error+al+actualizar+plazo");
        }
        exit();
    }

    public function eliminar() {
        if (Plazo::delete($_GET['id'])) {
            header("Location: index.php?action=plazos&mensaje=Plazo+eliminado+correctamente");
        } else {
            header("Location: index.php?action=plazos&error=Error+al+eliminar+plazo");
        }
        exit();
    }
}