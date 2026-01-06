<?php
require_once 'models/TemaPoa.php';

class TemaPoaController {

    public function index() {
        $temas = TemaPoa::getAll();
        require_once 'views/layout/header.php';
        require_once 'views/temas_poa/index.php';
        require_once 'views/layout/footer.php';
    }

    public function guardar() {
        $result = TemaPoa::create($_POST['descripcion']);
        if ($result) {
            $_SESSION['alert'] = [
                'type' => 'success',
                'message' => 'Tema POA creado exitosamente'
            ];
        } else {
            $_SESSION['alert'] = [
                'type' => 'danger',
                'message' => 'Error al crear el tema POA'
            ];
        }
        header("Location: index.php?action=temas_poa");
        exit;
    }

    public function editar() {
        $result = TemaPoa::update($_GET['id'], $_POST['descripcion'], $_POST['estado']);
        if ($result) {
            $_SESSION['alert'] = [
                'type' => 'success',
                'message' => 'Tema POA actualizado exitosamente'
            ];
        } else {
            $_SESSION['alert'] = [
                'type' => 'danger',
                'message' => 'Error al actualizar el tema POA'
            ];
        }
        header("Location: index.php?action=temas_poa");
        exit;
    }

    public function eliminar() {
        $result = TemaPoa::delete($_GET['id']);
        if ($result) {
            $_SESSION['alert'] = [
                'type' => 'success',
                'message' => 'Tema POA eliminado exitosamente'
            ];
        } else {
            $_SESSION['alert'] = [
                'type' => 'danger',
                'message' => 'Error al eliminar el tema POA'
            ];
        }
        header("Location: index.php?action=temas_poa");
        exit;
    }

    public function estado() {
        $result = TemaPoa::cambiarEstado($_GET['id'], $_GET['estado']);
        $estadoTexto = $_GET['estado'] == 'ACTIVO' ? 'activado' : 'desactivado';
        if ($result) {
            $_SESSION['alert'] = [
                'type' => 'success',
                'message' => "Tema POA $estadoTexto exitosamente"
            ];
        } else {
            $_SESSION['alert'] = [
                'type' => 'danger',
                'message' => 'Error al cambiar el estado del tema POA'
            ];
        }
        header("Location: index.php?action=temas_poa");
        exit;
    }
}