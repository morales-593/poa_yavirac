<?php

require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController {

    public function index() {
        $search = $_GET['search'] ?? '';
        $usuarios = Usuario::getAll($search);

        require_once 'views/layout/header.php';
        require_once 'views/usuarios/index.php';
        require_once 'views/layout/footer.php';
    }

    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Usuario::create([
                'nombres' => trim($_POST['nombres']),
                'usuario' => trim($_POST['usuario']),
                'password'=> trim($_POST['password']),
                'estado'  => $_POST['estado']
            ]);
            header("Location: index.php?action=usuarios");
            exit;
        }
    }

    public function editar() {
        $id = $_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Usuario::update($id, [
                'nombres' => trim($_POST['nombres']),
                'usuario' => trim($_POST['usuario']),
                'password'=> trim($_POST['password']),
                'estado'  => $_POST['estado']
            ]);
            header("Location: index.php?action=usuarios");
            exit;
        }
    }

    public function eliminar() {
        Usuario::delete($_GET['id']);
        header("Location: index.php?action=usuarios");
        exit;
    }
}
