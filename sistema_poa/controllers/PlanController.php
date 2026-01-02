<?php
require_once 'models/Plan.php';

class PlanController
{

    public function index()
    {
        $planes = Plan::all();
        require_once 'views/layout/header.php';
        require_once 'views/planes/index.php';
        require_once 'views/layout/footer.php';

    }

    public function guardar()
    {
        Plan::create($_POST);
        header("Location:index.php?action=planes");
    }

    public function eliminar()
    {
        Plan::delete($_GET['id']);
        header("Location:index.php?action=planes");
    }

    public function modalElaboracion()
    {
        $id_plan = $_GET['id_plan'];
        $elab = Plan::elaboracionPorPlan($id_plan);
        $temas = Plan::temas();
        $indicadores = Plan::indicadores();
        $responsables = Plan::responsables();
        require 'views/planes/modal_elaboracion.php';
    }

    public function guardarElaboracion()
    {
        Plan::guardarElaboracion($_POST);
        header("Location:index.php?action=planes");
    }
}
