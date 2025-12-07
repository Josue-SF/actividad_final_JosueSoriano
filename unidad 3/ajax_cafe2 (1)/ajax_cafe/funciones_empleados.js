// funciones_empleados.js - Versión final con Dashboard y Chat

// Variables globales para las gráficas
var salesChart;
var performanceChart;

// --- Funciones de Inicialización de Dashboard (Movidas aquí) ---

function initializeAdminDashboard(userName, userLevel) {
    document.getElementById('welcome-message').innerText = 'Bienvenido ' + userName + ' - Panel de ' + (userLevel === 'admin' ? 'Administración' : 'Gerencia');
    document.getElementById('user-info-placeholder').innerHTML = '<a href="#" style="color: #4CAF50; pointer-events: none;">👤 ' + userName + ' (' + userLevel + ')</a>';
    
    // Inicia la carga de datos y el chat al cargar la página
    cargarDatosDashboard();
    iniciarChat();
    
    // Refrescar datos cada 10 segundos
    setInterval(cargarDatosDashboard, 10000); 
}

function initializeEmployeeDashboard(userName, userLevel) {
    document.getElementById('welcome-message').innerText = 'Bienvenido ' + userName;
    document.getElementById('user-info-placeholder').innerHTML = '<a href="#" style="color: #4CAF50; pointer-events: none;">👤 ' + userName + ' (' + userLevel + ')</a>';
    
    // Inicia la carga de datos y el chat al cargar la página
    cargarDatosDashboard();
    iniciarChat();
    
    // Refrescar datos cada 10 segundos
    setInterval(cargarDatosDashboard, 10000); 
}

// --- 1. Lógica de Login y Redirección ---

/**
 * Verifica la sesión activa y llama al callback si la sesión es válida.
 * Si la sesión no es válida, redirige al login.
 */
function verificarSesionActiva(callback) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "datos_administrativos.php?accion=verificar", true);
    
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status == 200) {
            try {
                var json = JSON.parse(xhr.responseText);
                if(!json.logueado) {
                    console.log("Debes iniciar sesión para acceder a esta página"); 
                    window.location.href = "login.php";
                } else {
                    // Llama al callback con los datos de usuario
                    if (callback) {
                        callback(json.user.nombre, json.user.nivel);
                    }
                }
            } catch(e) {
                console.error("Error al parsear JSON:", e);
                // Si falla la verificación, siempre redirige al login.
                window.location.href = "login.php"; 
            }
        }
    }
    xhr.send();
}

/**
 * Verifica el nivel de acceso para los dashboards (administrador.php y empleado.php).
 * @param {string} currentPage - La página actual ('administrador.php' o 'empleado.php').
 */
function verificarAccesoDashboard(currentPage) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "datos_administrativos.php?accion=verificar", true);
    
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status == 200) {
            try {
                var json = JSON.parse(xhr.responseText);
                
                if(!json.logueado) {
                    // Si no está logueado, lo manda al login.
                    window.location.href = "login.php";
                    return;
                }

                const userLevel = json.user.nivel;
                const isAdminOrGerente = (userLevel === 'admin' || userLevel === 'Gerente');

                if (currentPage === 'administrador.php') {
                    if (isAdminOrGerente) {
                        // El usuario tiene nivel de Admin/Gerente, inicializa el dashboard.
                        initializeAdminDashboard(json.user.nombre, userLevel);
                    } else {
                        // El usuario es Empleado, redirige a su panel.
                        window.location.href = "empleado.php";
                    }
                } else if (currentPage === 'empleado.php') {
                    if (isAdminOrGerente) {
                        // El usuario es Admin/Gerente, redirige a su panel.
                        window.location.href = "administrador.php";
                    } else {
                        // El usuario es Empleado, inicializa el dashboard.
                        initializeEmployeeDashboard(json.user.nombre, userLevel);
                    }
                }

            } catch(e) {
                console.error("Error al verificar acceso de dashboard:", e);
                window.location.href = "login.php"; 
            }
        }
    }
    xhr.send();
}


function cerrarSesion() {
    var proceder = true; // Aquí iría un mensaje de confirmación si lo tuviera
    
    if(proceder) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "datos_administrativos.php?accion=logout", true);
        
        xhr.onreadystatechange = function() {
            if(xhr.readyState == 4 && xhr.status == 200) {
                try {
                    var json = JSON.parse(xhr.responseText);
                    if(json.success) {
                        console.log("Sesión cerrada correctamente");
                        window.location.href = "login.php";
                    }
                } catch(e) {
                    console.error("Error:", e);
                }
            }
        }
        xhr.send();
    }
}

function realizarLogin(event) {
    event.preventDefault();
    var username = document.getElementById("nombre_empleado").value;
    var password = document.getElementById("password").value;
    var id = document.getElementById("id").value;
    var messageDiv = document.getElementById("message");
    var submitButton = document.querySelector('.submit-button');
    
    if(!username || !password || !id) {
        messageDiv.innerHTML = '<div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">Por favor completa todos los campos</div>';
        return;
    }
    
    submitButton.innerHTML = 'Iniciando sesión...';
    submitButton.disabled = true;
    messageDiv.innerHTML = '';
    
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "datos_administrativos.php?accion=login", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4) {
            submitButton.innerHTML = 'Entrar';
            submitButton.disabled = false;
            
            if(xhr.status == 200) {
                try {
                    var json = JSON.parse(xhr.responseText);
                    
                    if(json.success) {
                        messageDiv.innerHTML = '<div style="background-color: #d4edda; color: #155724; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">¡Bienvenido ' + json.user + '! Redirigiendo...</div>';
                        
                        var redirectPage = (json.nivel === 'admin' || json.nivel === 'Gerente') ? "administrador.php" : "empleado.php";

                        setTimeout(function() { 
                            window.location.href = redirectPage;
                        }, 1500);
                        
                    } else {
                        messageDiv.innerHTML = '<div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">' + json.mensaje + '</div>';
                    }
                } catch(e) {
                    console.error("Error al parsear respuesta:", e);
                    messageDiv.innerHTML = '<div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">Error de conexión. Por favor intenta de nuevo.</div>';
                }
            } else {
                messageDiv.innerHTML = '<div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">Error de servidor: ' + xhr.status + '</div>';
            }
        }
    };
    var datos = "nombre=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password)+ "&id=" + encodeURIComponent(id);
    xhr.send(datos);
}


// --- 2. Lógica de Gráficas y Tablas (Dashboard) ---

function cargarDatosDashboard() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "datos_administrativos.php?accion=get_data", true);
    
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status == 200) {
            try {
                var json = JSON.parse(xhr.responseText);
                if(json.success) {
                    // Aseguramos que los datos sean arrays, incluso si están vacíos
                    const ventas = json.ventas || [];
                    const rendimiento = json.rendimiento || [];

                    actualizarGraficas(ventas, rendimiento);
                    if (window.location.pathname.split('/').pop() === 'administrador.php') {
                        actualizarTablaRendimiento(rendimiento);
                    }
                } else {
                    console.error("Error al cargar datos del dashboard:", json.mensaje);
                }
            } catch(e) {
                console.error("Error al parsear datos del dashboard:", e);
            }
        }
    };
    xhr.send();
}

function actualizarGraficas(ventasData, rendimientoData) {
    // --- Gráfica de Ventas ---
    var salesLabels = ventasData.map(d => d.nombre_empleado);
    var salesValues = ventasData.map(d => d.total_ventas);
    var salesCtx = document.getElementById('salesChart');

    if (salesChart) {
        salesChart.data.labels = salesLabels;
        salesChart.data.datasets[0].data = salesValues;
        salesChart.update();
    } else if (salesCtx) {
        salesChart = new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: salesLabels,
                datasets: [{
                    label: 'Ventas del Día (Unidades)',
                    data: salesValues,
                    backgroundColor: 'rgba(255, 198, 0, 0.8)', // #FFC600
                    borderColor: 'rgba(26, 26, 26, 1)', // #1a1a1a
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                },
                plugins: {
                    legend: { display: true }
                }
            }
        });
    }

    // --- Gráfica de Rendimiento (Solo para Administrador) ---
    var performanceCtx = document.getElementById('performanceChart');
    if (performanceCtx) {
        var performanceLabels = rendimientoData.map(d => d.nombre);
        var performanceValues = rendimientoData.map(d => d.rendimiento);
        
        if (performanceChart) {
            performanceChart.data.labels = performanceLabels;
            performanceChart.data.datasets[0].data = performanceValues;
            performanceChart.update();
        } else {
            performanceChart = new Chart(performanceCtx, {
                type: 'doughnut',
                data: {
                    labels: performanceLabels,
                    datasets: [{
                        label: 'Puntos de Rendimiento',
                        data: performanceValues,
                        backgroundColor: [
                            '#FFC600', '#1a1a1a', '#4CAF50', '#00bcd4', '#ff9800' // Colores variados
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' }
                    }
                }
            });
        }
    }
}

function actualizarTablaRendimiento(rendimientoData) {
    var tbody = document.getElementById('performanceTable').querySelector('tbody');
    if (tbody) {
        tbody.innerHTML = ''; // Limpiar la tabla
        rendimientoData.forEach(empleado => {
            var row = tbody.insertRow();
            var nameCell = row.insertCell();
            var performanceCell = row.insertCell();
            
            nameCell.textContent = empleado.nombre;
            performanceCell.textContent = empleado.rendimiento;
        });
    }
}


// --- 3. Lógica del Chat ---

function iniciarChat() {
    // Aseguramos que los elementos del chat existen antes de inicializar
    if (document.getElementById('chat-form')) {
        document.getElementById('chat-form').addEventListener('submit', enviarMensajeChat);
        cargarMensajesChat();
        // Actualizar mensajes cada 3 segundos
        setInterval(cargarMensajesChat, 3000); 
    }
}

function enviarMensajeChat(event) {
    event.preventDefault();
    var input = document.getElementById('chat-input');
    var mensaje = input.value.trim();

    if (mensaje === "") return;

    // Simular el mensaje inmediatamente
    agregarMensajeAlChat({
        remitente_nombre: 'Yo', 
        mensaje: mensaje, 
        timestamp: new Date().toISOString()
    }, true); 
    
    input.value = ''; // Limpiar el input

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "datos_administrativos.php?accion=send_chat", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status == 200) {
            try {
                var json = JSON.parse(xhr.responseText);
                if(!json.success) {
                    console.error("Error al enviar mensaje:", json.mensaje);
                    // Opcional: Reinsertar el mensaje fallido en el input
                }
            } catch(e) {
                console.error("Error al procesar respuesta de chat:", e);
            }
        }
    };
    var datos = "mensaje=" + encodeURIComponent(mensaje);
    xhr.send(datos);
}

// Función para obtener los mensajes y mostrarlos
function cargarMensajesChat() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "datos_administrativos.php?accion=get_chat", true);
    
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status == 200) {
            try {
                var json = JSON.parse(xhr.responseText);
                if(json.success) {
                    renderizarMensajes(json.mensajes);
                }
            } catch(e) {
                console.error("Error al cargar mensajes de chat:", e);
            }
        }
    };
    xhr.send();
}

// Función para dibujar los mensajes en la interfaz
function renderizarMensajes(mensajes) {
    var chatBox = document.getElementById('chat-messages');
    // Se corrige la obtención del nombre de usuario:
    var userInfoPlaceholder = document.getElementById('user-info-placeholder');
    // Si el placeholder existe y tiene contenido de enlace, extrae el nombre
    var currentUserName = userInfoPlaceholder ? userInfoPlaceholder.querySelector('a')?.textContent.split('(')[0]?.trim().split(/\s+/).slice(1).join(' ') : 'Yo';


    var shouldScroll = chatBox.scrollTop + chatBox.clientHeight >= chatBox.scrollHeight - 1;
    
    chatBox.innerHTML = ''; // Limpiar antes de renderizar
    
    mensajes.forEach(msg => {
        // La comparación debe ser con el nombre almacenado en la DB
        var isMine = msg.remitente_nombre === currentUserName;
        agregarMensajeAlChat(msg, isMine);
    });
    
    if (shouldScroll) {
        chatBox.scrollTop = chatBox.scrollHeight;
    }
}

function agregarMensajeAlChat(msg, isMine) {
    var chatBox = document.getElementById('chat-messages');
    var messageDiv = document.createElement('div');
    messageDiv.classList.add('message', isMine ? 'message-mine' : 'message-other');

    var time = new Date(msg.timestamp).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

    var bubble = document.createElement('span');
    bubble.classList.add('bubble');
    
    var senderName = isMine ? '' : `<span style="font-weight: bold; color: #1a1a1a;">${msg.remitente_nombre}: </span>`;
    
    bubble.innerHTML = `${senderName}${msg.mensaje}<br><span style="font-size: 0.7em; color: #666;">${time}</span>`;
    messageDiv.appendChild(bubble);
    chatBox.appendChild(messageDiv);
}


// --- 4. Inicialización al cargar la página ---
window.onload = function() {
    var currentPage = window.location.pathname.split('/').pop();
    
    if(currentPage === 'login_empleados.php') {
        var loginForm = document.getElementById('loginForm');
        if(loginForm) {
            loginForm.addEventListener('submit', realizarLogin);
        } else {
            console.error("Formulario de login NO encontrado");
        }
    }
    // No se hace nada aquí, la lógica de verificación se maneja en los archivos PHP
    // y la redirección se maneja en verificarAccesoDashboard.
}