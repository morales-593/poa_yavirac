<?php
require_once 'models/Objetivo.php';
require_once 'models/Eje.php';
require_once 'helpers/session.php';

class ObjetivoController {

    public function index() {
        verificarSesion();
        $objetivos = Objetivo::listar();
        $ejes = Eje::listar();
        require 'views/catalogos/objetivos.php';
    }

    public function guardar() {
        verificarSesion();
        Objetivo::guardar($_POST['id_eje'], $_POST['descripcion']);
        header("Location: index.php?action=objetivos");
    }
}
