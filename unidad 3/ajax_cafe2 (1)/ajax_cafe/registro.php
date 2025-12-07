<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Andatti Café | Registro</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <a href="index.html" class="logo">andatti</a>
            <ul class="nav-links">
                <li><a href="cafeteria.php">Inicio</a></li>
                <li><a href="menu.php">Menú</a></li>
                <li><a href="ubicacion.php">Ubicación</a></li>
                <li><a href="horarios.php">Horarios</a></li>
                <li><a href="contacto.php">Contacto</a></li>
                <li><a href="registro.php" class="active" style="color: #FFC600;">Registro</a></li>
                <li><a href="login.php" style="color: #FFC600;">Iniciar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <div class="contact-container" style="max-width: 500px; margin: 4rem auto;">
        <h2 style="text-align: center; color: #1a1a1a; margin-bottom: 2rem; font-size: 2.5rem;">Crear Cuenta</h2>
        
        <div id="message"></div>

        <form id="registerForm">
            <div class="form-group">
                <label for="username">Nombre de Usuario</label>
                <input type="text" id="username" name="username" required minlength="3">
                <small style="color: #666;">Mínimo 3 caracteres</small>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required minlength="6">
                <small style="color: #666;">Mínimo 6 caracteres</small>
            </div>

            <button type="submit" class="submit-button">Registrarme</button>
        </form>

        <div style="text-align: center; margin-top: 1.5rem; color: #666;">
            ¿Ya tienes cuenta? <a href="login.html" style="color: #FFC600; text-decoration: none; font-weight: bold;">Iniciar Sesión</a>
        </div>
    </div>

    <footer>
        <p class="footer-brand">andatti® Café | Una marca de OXXO</p>
        <p>© 2025 Todos los derechos reservados</p>
        <p>📞 01-800-ANDATTI | 📧 contacto@andatti.com.mx</p>
    </footer>
    <script src="funciones.js"></script>
</body>
</html>