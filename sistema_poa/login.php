<?php
session_start();
require_once 'controllers/AuthController.php';

$auth = new AuthController();

if($auth->isLoggedIn()) {
    header("Location: views/coordinacion.php");
    exit;
}

$error = '';
if($_POST && isset($_POST['username']) && isset($_POST['password'])) {
    if($auth->login($_POST['username'], $_POST['password'])) {
        header("Location: views/coordinacion.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema POA</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Estilos básicos para el login */
        :root {
            --primary: #3498db;
            --secondary: #2c3e50;
            --danger: #e74c3c;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 20px;
        }
        
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 420px;
            max-width: 90%;
            padding: 35px;
            text-align: center;
        }
        
        .login-title {
            margin-bottom: 30px;
            color: var(--secondary);
            font-size: 28px;
            font-weight: 700;
        }
        
        .login-logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, #1abc9c 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 32px;
            margin: 0 auto 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--secondary);
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }
        
        .login-btn {
            width: 100%;
            padding: 14px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 15px;
        }
        
        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(52, 152, 219, 0.4);
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }
        
        .alert-danger {
            background: rgba(231, 76, 60, 0.15);
            color: #c0392b;
            border-left: 4px solid var(--danger);
        }
        
        .alert i {
            margin-right: 12px;
            font-size: 22px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-logo">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <h1 class="login-title">Sistema de Planificación</h1>
            
            <?php if(!empty($error)): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <span><?php echo $error; ?></span>
            </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label class="form-label">Usuario</label>
                    <input type="text" name="username" class="form-control" placeholder="Ingrese su usuario" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" placeholder="Ingrese su contraseña" required>
                </div>
                <button type="submit" class="login-btn">Comenzar!</button>
            </form>
        </div>
    </div>
</body>
</html>