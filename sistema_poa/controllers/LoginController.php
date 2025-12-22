<?php
require_once __DIR__ . '/../models/Usuario.php';

class LoginController {

    public function index() {
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function autenticar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = trim($_POST['usuario']);
            $password = trim($_POST['password']);

            $user = Usuario::login($usuario, $password);

            if ($user) {
                $_SESSION['usuario'] = $user;
                header("Location: index.php?action=dashboard");
                exit;
            }

            $_SESSION['error'] = 'Usuario o contraseña incorrectos';
            header("Location: index.php?action=login");
            exit;
        }
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?action=login");
        exit;
    }
}
