<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Andatti Café | Panel de Administración</title>
    <!-- Incluye Chart.js para las gráficas -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="styles.css">
    <style>
        .dashboard-container {
            display: grid;
            grid-template-columns: 3fr 1fr; /* 3/4 para el contenido, 1/4 para el chat */
            gap: 2rem;
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        .main-content {
            display: grid;
            gap: 2rem;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        }
        .card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .chat-sidebar {
            background: #f8f8f8;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            display: flex;
            flex-direction: column;
            height: calc(100vh - 100px); /* Ajuste de altura */
            position: sticky;
            top: 20px;
        }
        .chat-header {
            padding: 1rem;
            border-bottom: 1px solid #eee;
            background: #1a1a1a;
            color: #FFC600;
            border-radius: 10px 10px 0 0;
            font-weight: bold;
        }
        #chat-messages {
            flex-grow: 1;
            padding: 1rem;
            overflow-y: auto;
            max-height: calc(100vh - 250px);
        }
        .message {
            margin-bottom: 0.5rem;
            line-height: 1.4;
            font-size: 0.9rem;
        }
        .message-mine {
            text-align: right;
        }
        .message-mine .bubble {
            background-color: #FFC600;
            color: #1a1a1a;
            border-radius: 10px 10px 0 10px;
            padding: 0.5rem 0.75rem;
            display: inline-block;
            max-width: 80%;
        }
        .message-other .bubble {
            background-color: #e0e0e0;
            color: #1a1a1a;
            border-radius: 10px 10px 10px 0;
            padding: 0.5rem 0.75rem;
            display: inline-block;
            max-width: 80%;
        }
        .chat-input {
            padding: 1rem;
            border-top: 1px solid #eee;
        }
        .chat-input form {
            display: flex;
        }
        .chat-input input[type="text"] {
            flex-grow: 1;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 5px 0 0 5px;
            margin-right: -1px;
        }
        .chat-input button {
            background-color: #1a1a1a;
            color: #fff;
            padding: 0.75rem 1rem;
            border: none;
            cursor: pointer;
            border-radius: 0 5px 5px 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        th, td {
            border: 1px solid #eee;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            color: #333;
            font-weight: 600;
        }

        /* Responsive Layout */
        @media (max-width: 1024px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }
            .chat-sidebar {
                position: static;
                height: 500px;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="cafeteria.php" class="logo">andatti</a>
            <ul class="nav-links">
                <li><a href="administrador.php" class="active">Dashboard</a></li>
                <!-- El nombre del usuario se inyectará aquí con JS -->
                <li id="user-info-placeholder"></li>
                <li><a href="#" onclick="cerrarSesion(); return false;" style="color: #FFC600;">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <div class="contact-container" style="padding-bottom: 0;">
        <h1 id="welcome-message" style="text-align: center; color: #1a1a1a; margin-bottom: 2rem;">Panel de Administración</h1>
    </div>

    <div class="dashboard-container">
        <!-- Contenido Principal: Gráficas y Tablas -->
        <div class="main-content">

            <!-- Card: Gráfica de Ventas -->
            <div class="card">
                <h3 style="margin-bottom: 1rem; color: #1a1a1a;">Ventas Diarias por Empleado</h3>
                <canvas id="salesChart"></canvas>
            </div>

            <!-- Card: Gráfica de Rendimiento -->
            <div class="card">
                <h3 style="margin-bottom: 1rem; color: #1a1a1a;">Rendimiento de Empleados (Puntos)</h3>
                <canvas id="performanceChart"></canvas>
            </div>

            <!-- Card: Tabla de Rendimiento Detallado -->
            <div class="card" style="grid-column: 1 / -1;">
                <h3 style="margin-bottom: 1rem; color: #1a1a1a;">Tabla Detallada de Rendimiento</h3>
                <table id="performanceTable">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Nivel de Rendimiento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Datos cargados con JS -->
                    </tbody>
                </table>
            </div>
            
        </div>

        <!-- Barra Lateral: Chat -->
        <div class="chat-sidebar">
            <div class="chat-header">
                Comunicación Interna
            </div>
            <div id="chat-messages">
                <!-- Mensajes cargados con JS -->
            </div>
            <div class="chat-input">
                <form id="chat-form">
                    <input type="text" id="chat-input" placeholder="Escribe un mensaje..." required>
                    <button type="submit">Enviar</button>
                </form>
            </div>
        </div>
    </div>

    <footer>
        <p class="footer-brand">andatti® Café | Una marca de OXXO</p>
        <p>© 2025 Todos los derechos reservados</p>
    </footer>

    <script src="funciones_empleados.js"></script>
    <script>
        // La función initializeAdminDashboard se ha movido a funciones_empleados.js
        window.onload = function() {
            // Llama a la función de verificación global con la redirección específica para Admin.
            verificarAccesoDashboard('administrador.php');
        };
    </script>
</body>
</html>