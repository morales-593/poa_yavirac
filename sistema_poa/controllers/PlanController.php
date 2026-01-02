<?php
require_once 'models/Plan.php';

class PlanController
{
    public function index()
    {
        $planes = Plan::all();
        require 'views/layout/header.php';
        require 'views/planes/index.php';
        require 'views/layout/footer.php';
    }

    public function store()
    {
        Plan::create([
            'nombre_elaborado' => $_POST['nombre_elaborado'],
            'nombre_responsable' => $_POST['nombre_responsable'],
            'id_usuario' => $_SESSION['usuario']['id_usuario']
        ]);

        header("Location: index.php?url=planes");
    }

    public function delete()
    {
        Plan::delete($_GET['id']);
        header("Location: index.php?url=planes");
    }

    public function ver()
    {
        $plan = Plan::find($_GET['id']);
        require 'views/layout/header.php';
        require 'views/planes/ver.php';
        require 'views/layout/footer.php';
    }
}
