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
        if (Eje::create($_POST['nombre_eje'], $_POST['objetivo'])) {
            header("Location: index.php?action=ejes&mensaje=Eje+creado+correctamente");
        } else {
            header("Location: index.php?action=ejes&error=Error+al+crear+eje");
        }
        exit;
    }

    public function editar() {
        if (Eje::update($_GET['id'], $_POST['nombre_eje'], $_POST['objetivo'])) {
            header("Location: index.php?action=ejes&mensaje=Eje+actualizado+correctamente");
        } else {
            header("Location: index.php?action=ejes&error=Error+al+actualizar+eje");
        }
        exit;
    }

    public function eliminar() {
        if (Eje::delete($_GET['id'])) {
            header("Location: index.php?action=ejes&mensaje=Eje+eliminado+correctamente");
        } else {
            header("Location: index.php?action=ejes&error=Error+al+eliminar+eje");
        }
        exit;
    }
}