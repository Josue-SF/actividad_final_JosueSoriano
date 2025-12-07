<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Andatti Café | Iniciar Sesión de Empleados</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <a href="cafeteria.php" class="logo">andatti</a>
            <ul class="nav-links">
                <li><a href="cafeteria.php">Inicio</a></li>
                <li><a href="menu.php">Menú</a></li>
                <li><a href="ubicacion.php">Ubicación</a></li>
                <li><a href="horarios.php">Horarios</a></li>
                <li><a href="contacto.php">Contacto</a></li>
                <li><a href="registro.php" style="color: #FFC600;">Registro</a></li>
                <li><a href="login.php" class="active" style="color: #FFC600;">Iniciar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <div class="contact-container" style="max-width: 500px; margin: 4rem auto;">
        <h2 style="text-align: center; color: #1a1a1a; margin-bottom: 2rem; font-size: 2.5rem;">Iniciar Sesión de Empleados</h2>
        
        <div id="message"></div>

        <form id="loginForm">
            <div class="form-group">
                <label for="numero">Numero de control</label>
                <input type="text" id="id" name="numero_control" required>
            </div>
            <div class="form-group">
                <label for="nombre_empleado">Nombre de empleado</label>
                <input type="text" id="nombre_empleado" name="nombre_empleado" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="submit-button">Entrar</button>
        </form>
        <div style="text-align: center; margin-top: 1.5rem; color: #666;">
            ¿No eres empleado? <a href="login.php" style="color: #FFC600; text-decoration: none; font-weight: bold;">Volver al login de usuario</a>
        </div>
    </div>

    <footer>
        <p class="footer-brand">andatti® Café | Una marca de OXXO</p>
        <p>© 2025 Todos los derechos reservados</p>
        <p>📞 01-800-ANDATTI | 📧 contacto@andatti.com.mx</p>
    </footer>

    
    </body>
    <script src="funciones_empleados.js"></script>
    </html>