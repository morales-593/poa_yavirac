<?php
require_once 'models/Responsable.php';

class ResponsableController
{

    public function index()
    {
        $responsables = Responsable::all();
        require_once 'views/layout/header.php';
        require_once 'views/responsables/index.php';
        require_once 'views/layout/footer.php';

    }

    public function guardar()
    {
        Responsable::create($_POST['nombre_responsable']);
        header("Location: index.php?action=responsables");
    }

    public function actualizar()
    {
        Responsable::update($_GET['id'], $_POST['nombre_responsable']);
        header("Location: index.php?action=responsables");
    }

    public function toggle()
    {
        Responsable::toggle($_GET['id']);
        header("Location: index.php?action=responsables");
    }

    public function eliminar()
    {
        Responsable::delete($_GET['id']);
        header("Location: index.php?action=responsables");
    }
}
