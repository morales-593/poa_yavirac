<?php
require_once 'models/Plan.php';

class PlanController {

    public function index(){
        $planes = Plan::all();
        $responsables = Plan::responsables();

        require_once 'views/layout/header.php';
        require_once 'views/planes/index.php';
        require_once 'views/layout/footer.php';
    }

    public function guardar(){
        Plan::create($_POST);
        header("Location: index.php?action=planes");
    }

    public function eliminar(){
        Plan::delete($_GET['id']);
        header("Location: index.php?action=planes");
    }
}
