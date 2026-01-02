<?php
require_once 'models/Dashboard.php';

class DashboardController
{
    public function index()
    {
        $totalPlanes       = Dashboard::totalPlanes();
        $usuariosActivos   = Dashboard::usuariosActivos();
        $planesCompletados = Dashboard::planesCompletados();
        $totalEjes         = Dashboard::totalEjes();
        $ejes              = Dashboard::ejes();
        $planesPorEje      = Dashboard::planesPorEje();
        $planesPorMes      = Dashboard::planesPorMes();
        $estadoPorEje      = Dashboard::estadoPorEje();
        // $eficiencia        = Dashboard::eficienciaResponsables();

        require_once 'views/layout/header.php';
        require_once 'views/dashboard/index.php';
        require_once 'views/layout/footer.php';
    }
}
