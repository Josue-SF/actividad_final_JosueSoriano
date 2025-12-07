<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Andatti Café | Menú</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <a href="cafeteria.php" class="logo">andatti</a>
            <ul class="nav-links">
                <li><a href="cafeteria.php">Inicio</a></li>
                <li><a href="menu.php" class="active">Menú</a></li>
                <li><a href="ubicacion.php">Ubicación</a></li>
                <li><a href="horarios.php">Horarios</a></li>
                <li><a href="contacto.php">Contacto</a></li>
                <li><a href="registro.php" style="color: #FFC600;">Registro</a></li>
                <li><a href="login.php" style="color: #FFC600;">Iniciar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <section id="menu">
        <h2>Nuestro Menú</h2>
        <div class="menu-grid">
            <div class="menu-item">
                <h3>Café Americano</h3>
                <p class="price">$25 - $35</p>
                <p>Café puro y aromático, perfecto para comenzar tu día con energía.</p>
                <span class="category-badge">CALIENTE</span>
            </div>

            <div class="menu-item">
                <h3>Cappuccino</h3>
                <p class="price">$35 - $45</p>
                <p>Espresso con leche vaporizada y espuma cremosa. Un clásico italiano.</p>
                <span class="category-badge">CALIENTE</span>
            </div>

            <div class="menu-item">
                <h3>Latte</h3>
                <p class="price">$35 - $45</p>
                <p>Suave combinación de espresso con leche, ideal para cualquier momento.</p>
                <span class="category-badge">CALIENTE</span>
            </div>

            <div class="menu-item">
                <h3>Mocha</h3>
                <p class="price">$40 - $50</p>
                <p>La perfecta mezcla de café, chocolate y leche. Deliciosamente irresistible.</p>
                <span class="category-badge">CALIENTE</span>
            </div>

            <div class="menu-item">
                <h3>Frappé</h3>
                <p class="price">$45 - $55</p>
                <p>Bebida helada con café, perfecta para refrescarte en días calurosos.</p>
                <span class="category-badge">FRÍO</span>
            </div>

            <div class="menu-item">
                <h3>Chai Latte</h3>
                <p class="price">$40 - $50</p>
                <p>Exquisita mezcla de té especiado con leche vaporizada.</p>
                <span class="category-badge">CALIENTE</span>
            </div>

            <div class="menu-item">
                <h3>Chocolate Caliente</h3>
                <p class="price">$30 - $40</p>
                <p>Rico chocolate con leche, corona de crema batida opcional.</p>
                <span class="category-badge">CALIENTE</span>
            </div>

            <div class="menu-item">
                <h3>Café Helado</h3>
                <p class="price">$35 - $45</p>
                <p>Café frío con hielo, refrescante y energizante.</p>
                <span class="category-badge">FRÍO</span>
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