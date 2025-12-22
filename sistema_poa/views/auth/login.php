<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema POA</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>

<body class="login-page">

<div class="login-container">
    <h2>Sistema POA</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?action=autenticar">
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>
</div>

</body>
</html>
