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

    // Modal de elaboración
    public function modalElaboracion()
    {
        $id_plan = $_GET['id_plan'];

        $plan = Plan::find($id_plan);
        $elab = Plan::elaboracionPorPlan($id_plan);
        $ejes = Plan::ejes();
        $temas = Plan::temas();
        $responsables = Plan::responsables();
        $plazos = Plan::plazos();

        require 'views/planes/modal_elaboracion.php';
    }

    // Ajax para indicadores por eje
    public function indicadoresPorEje()
    {
        echo json_encode(Plan::indicadoresPorEje($_GET['id_eje']));
    }

    public function guardarElaboracion()
    {
        Plan::guardarElaboracion($_POST);
        header("Location:index.php?action=planes");
    }
}
