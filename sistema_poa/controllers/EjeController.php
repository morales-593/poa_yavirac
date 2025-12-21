<?php
require_once 'models/Eje.php';
require_once 'helpers/session.php';

class EjeController {

    public function index() {
        verificarSesion();
        $ejes = Eje::listar();
        require 'views/catalogos/ejes.php';
    }

    public function guardar() {
        verificarSesion();
        Eje::guardar($_POST['nombre'], $_POST['descripcion']);
        header("Location: index.php?action=ejes");
    }
}
