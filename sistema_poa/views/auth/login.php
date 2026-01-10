<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Planificación - Login</title>
    <link rel="stylesheet" href="public/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="login-page">
<div class="login-background"></div>

<div class="login-container">
    <div class="login-card">
        <!-- Imagen de tu proyecto -->
        <div class="login-image">
            <div class="image-overlay">
                <i class="fas fa-graduation-cap"></i>
                <h2>Sistema de Planificación</h2>
            </div>
        </div>
        
        <div class="login-content">
            <?php if (!empty($error)): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?= htmlspecialchars($error) ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" action="index.php?action=autenticar" class="login-form" id="loginForm">
                <div class="input-group">
                    <div class="input-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <input type="text" name="usuario" placeholder="Ingrese su usuario" required>
                </div>

                <div class="input-group">
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <input type="password" name="password" placeholder="Ingrese su contraseña" required>
                    <button type="button" class="password-toggle" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>

                <button type="submit" class="login-button" id="submitButton">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Ingresar al Sistema</span>
                    <div class="button-loader">
                        <div class="spinner"></div>
                    </div>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    const submitButton = document.getElementById('submitButton');
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.querySelector('input[name="password"]');
    
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    }
    
    form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            return;
        }
        submitButton.classList.add('loading');
        submitButton.disabled = true;
    });
    
    if (document.querySelector('.error-message')) {
        submitButton.classList.remove('loading');
        submitButton.disabled = false;
    }
});
</script>
</body>
</html>