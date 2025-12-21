<?php
require_once 'models/Usuario.php';

class LoginController {

    public function index() {
        require 'views/login.php';
    }

    public function autenticar() {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=login");
            exit;
        }

        $usuario  = trim($_POST['usuario']);
        $password = trim($_POST['password']);

        $user = Usuario::login($usuario, $password);

        if ($user) {
            $_SESSION['usuario'] = [
                'id'     => $user['id_usuario'],
                'nombre' => $user['nombres']
            ];

            header("Location: index.php?action=dashboard");
            exit;
        }

        $error = "Usuario o contraseña incorrectos";
        require 'views/login.php';
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?action=login");
        exit;
    }
}
