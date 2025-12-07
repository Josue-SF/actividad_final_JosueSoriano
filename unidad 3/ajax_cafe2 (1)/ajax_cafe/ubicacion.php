<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Andatti Café | Ubicación</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <a href="cafeteria.php" class="logo">andatti</a>
            <ul class="nav-links">
                <li><a href="cafeteria.php">Inicio</a></li>
                <li><a href="menu.php">Menú</a></li>
                <li><a href="ubicacion.php" class="active">Ubicación</a></li>
                <li><a href="horarios.php">Horarios</a></li>
                <li><a href="contacto.php">Contacto</a></li>
                <li><a href="registro.php" style="color: #FFC600;">Registro</a></li>
                <li><a href="login.php" style="color: #FFC600;">Iniciar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <section id="ubicacion">
        <h2>Ubicación</h2>
        <div class="location-container">
            <div class="location-info">
                <div class="location-item">
                    <h3>📍 OXXO Centro</h3>
                    <p><strong>Dirección:</strong> Av. Principal #123, Col. Centro</p>
                    <p><strong>Ciudad:</strong> Ciudad Victoria, Tamaulipas</p>
                    <p><strong>CP:</strong> 87000</p>
                </div>

                <div class="location-item">
                    <h3>📍 OXXO Plaza Norte</h3>
                    <p><strong>Dirección:</strong> Blvd. Tamaulipas #456, Col. Morelos</p>
                    <p><strong>Ciudad:</strong> Ciudad Victoria, Tamaulipas</p>
                    <p><strong>CP:</strong> 87010</p>
                </div>

                <div class="location-item">
                    <h3>📍 OXXO Universidad</h3>
                    <p><strong>Dirección:</strong> Av. Estudiantes #789, Col. Universitaria</p>
                    <p><strong>Ciudad:</strong> Ciudad Victoria, Tamaulipas</p>
                    <p><strong>CP:</strong> 87020</p>
                </div>
            </div>
            <div class="map-placeholder">
                <img src="da.jpg" alt="Mapa de ubicaciones">
            </div>
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