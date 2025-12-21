<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema POA</title>
    <link rel="stylesheet" href="public/css/styles.css">
    <style>
        .login-container {
            width: 350px;
            margin: 120px auto;
            background: #fff;
            padding: 25px;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0,0,0,.1);
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background: #2563eb;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .login-container button:hover {
            background: #1e40af;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Sistema POA</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?action=autenticar">
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>
</div>

</body>
</html>
