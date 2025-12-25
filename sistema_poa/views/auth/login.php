<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="public/css/login.css">
</head>

<body class="login-page">

<div class="login-container">
    <h2>Sistema de Planificación</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?action=autenticar">
        <h2>Usuario:</h2>
        <input type="text" name="usuario" placeholder="Usuario" required>
        <h2>Contraseña:</h2>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitButton = form.querySelector('button[type="submit"]');
    
    form.addEventListener('submit', function() {
        // Agregar clase de carga al botón
        submitButton.classList.add('loading');
        submitButton.disabled = true;
    });
    
    // Si hay un error, asegurarse de que el botón se restablezca
    const errorDiv = document.querySelector('.error');
    if (errorDiv) {
        submitButton.classList.remove('loading');
        submitButton.disabled = false;
    }
});
</script>
</body>
</html>
