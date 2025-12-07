<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Andatti Café | Contacto</title>
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
                <li><a href="contacto.php" class="active">Contacto</a></li>
                <li><a href="registro.php" style="color: #FFC600;">Registro</a></li>
                <li><a href="login.php" style="color: #FFC600;">Iniciar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <section id="contacto">
        <h2>Contacto</h2>
        <div class="contact-container">
            <form id="contactForm">
                <div class="form-group">
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="tel" id="telefono" name="telefono" required>
                </div>

                <div class="form-group">
                    <label for="sucursal">Sucursal de Interés</label>
                    <select id="sucursal" name="sucursal" required>
                        <option value="">Selecciona una sucursal</option>
                        <option value="centro">OXXO Centro</option>
                        <option value="norte">OXXO Plaza Norte</option>
                        <option value="universidad">OXXO Universidad</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="mensaje">Mensaje</label>
                    <textarea id="mensaje" name="mensaje" required></textarea>
                </div>

                <button type="submit" class="submit-button">Enviar Mensaje</button>
            </form>
        </div>
    </section>

    <footer>
        <p class="footer-brand">andatti® Café | Una marca de OXXO</p>
        <p>© 2025 Todos los derechos reservados</p>
        <p>📞 01-800-ANDATTI | 📧 contacto@andatti.com.mx</p>
    </footer>
    <script src="funciones.js"></script>
    </body>
</html>