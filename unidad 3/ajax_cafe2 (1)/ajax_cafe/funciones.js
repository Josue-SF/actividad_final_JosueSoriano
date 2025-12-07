function verificarSesionActiva() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "connection.php?accion=verificar", true);
    
    xhr.onreadystatechange = function() {
        console.log("Verificando sesión - readyState:", xhr.readyState);
        
        if(xhr.readyState == 4) {
            if(xhr.status == 200) {
                try {
                    var json = JSON.parse(xhr.responseText);
                    console.log("Estado de sesión:", json);
                    if(!json.logueado) {
                        alert("Debes iniciar sesión para acceder a esta página");
                        window.location.href = "login.php";
                    } else {
                        console.log("Usuario logueado:", json.user);
                        mostrarUsuarioEnMenu(json.user);
                    }
                } catch(e) {
                    console.error("Error al parsear JSON:", e);
                    console.log("Respuesta recibida:", xhr.responseText);
                }
            } else {
                console.error("Error en la petición:", xhr.status);
            }
        }
    }
    
    xhr.send();
}

function mostrarUsuarioEnMenu(nombreUsuario) {
    var navLinks = document.querySelector('.nav-links');
    if(navLinks) {
        var registroLink = navLinks.querySelector('a[href="registro.php"]');
        var loginLink = navLinks.querySelector('a[href="login.php"]');
        
        if(registroLink && registroLink.parentElement) {
            registroLink.parentElement.innerHTML = '<a href="#" style="color: #4CAF50; pointer-events: none;">👤 ' + nombreUsuario + '</a>';
        }
        if(loginLink && loginLink.parentElement) {
            loginLink.parentElement.innerHTML = '<a href="#" onclick="cerrarSesion(); return false;" style="color: #FFC600;">Cerrar Sesión</a>';
        }
    }
}

function cerrarSesion() {
    if(confirm("¿Estás seguro de cerrar sesión?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "connection.php?accion=logout", true);
        
        xhr.onreadystatechange = function() {
            if(xhr.readyState == 4 && xhr.status == 200) {
                try {
                    var json = JSON.parse(xhr.responseText);
                    if(json.success) {
                        alert("Sesión cerrada correctamente");
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
    
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var messageDiv = document.getElementById("message");
    var submitButton = document.querySelector('.submit-button');
    
    // Validar campos vacíos
    if(!username || !password) {
        messageDiv.innerHTML = '<div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">Por favor completa todos los campos</div>';
        return;
    }
    
    // Mostrar loading
    submitButton.innerHTML = 'Iniciando sesión...';
    submitButton.disabled = true;
    messageDiv.innerHTML = '';
    
    // Crear petición AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "connection.php?accion=login", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4) {
            submitButton.innerHTML = 'Entrar';
            submitButton.disabled = false;
            
            if(xhr.status == 200) {
                try {
                    console.log("Respuesta raw:", xhr.responseText);
                    var json = JSON.parse(xhr.responseText);
                    console.log("Respuesta login:", json);
                    
                    if(json.success) {
                        messageDiv.innerHTML = '<div style="background-color: #d4edda; color: #155724; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">¡Bienvenido ' + json.user + '! Redirigiendo...</div>';
                        setTimeout(function() {
                            window.location.href = "menu.php";
                        }, 1500);
                    } else {
                        messageDiv.innerHTML = '<div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">' + json.mensaje + '</div>';
                    }
                } catch(e) {
                    console.error("Error al parsear respuesta:", e);
                    console.log("Respuesta recibida:", xhr.responseText);
                    messageDiv.innerHTML = '<div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">Error de conexión. Por favor intenta de nuevo.</div>';
                }
            } else {
                messageDiv.innerHTML = '<div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">Error de servidor: ' + xhr.status + '</div>';
            }
        }
    }
    
    var datos = "nombre=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password);
    xhr.send(datos);
}

function verificarUsuarioExistente(username, callback) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "connection.php?accion=verificar_usuario&username=" + encodeURIComponent(username), true);
    
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status == 200) {
            try {
                var json = JSON.parse(xhr.responseText);
                callback(json.existe);
            } catch(e) {
                console.error("Error al verificar usuario:", e);
                callback(false);
            }
        }
    }
    
    xhr.send();
}

function realizarRegistro(event) {
    event.preventDefault();
    
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var messageDiv = document.getElementById("message");
    var submitButton = document.querySelector('.submit-button');
    messageDiv.innerHTML = '';
    
    // Validar campos vacíos
    if(!username || !password) {
        messageDiv.innerHTML = '<div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">Por favor completa todos los campos</div>';
        return;
    }
    
    // Validar longitud mínima
    if(password.length < 4) {
        messageDiv.innerHTML = '<div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">La contraseña debe tener al menos 4 caracteres</div>';
        return;
    }
    
    submitButton.innerHTML = 'Verificando...';
    submitButton.disabled = true;

    verificarUsuarioExistente(username, function(existe) {
        if(existe) {
            messageDiv.innerHTML = '<div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">El nombre de usuario "' + username + '" ya está registrado. Por favor elige otro.</div>';
            submitButton.innerHTML = 'Registrarme';
            submitButton.disabled = false;
        } else {
            submitButton.innerHTML = 'Registrando...';
            registrarNuevoUsuario(username, password, messageDiv, submitButton);
        }
    });
}

function registrarNuevoUsuario(username, password, messageDiv, submitButton) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "connection.php?accion=registrar", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
    xhr.onreadystatechange = function() {
        
        if(xhr.readyState == 4) {
            submitButton.innerHTML = 'Registrarme';
            submitButton.disabled = false;
            
            if(xhr.status == 200) {
                try {
                    var json = JSON.parse(xhr.responseText);
                    
                    if(json.success) {
                        messageDiv.innerHTML = '<div style="background-color: #d4edda; color: #155724; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">¡Registro exitoso! Redirigiendo al inicio de sesión...</div>';
                        setTimeout(function() {
                            window.location.href = "login.php";
                        }, 2000);
                    } else {
                        messageDiv.innerHTML = '<div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">' + json.mensaje + '</div>';
                    }
                } catch(e) {
                    console.error("Error al parsear respuesta:", e);
                    console.log("Respuesta recibida:", xhr.responseText);
                    messageDiv.innerHTML = '<div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">Error de conexión. Por favor intenta de nuevo.</div>';
                }
            } else {
                messageDiv.innerHTML = '<div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">Error de servidor: ' + xhr.status + '</div>';
            }
        }
    }
    
    var datos = "username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password);
    xhr.send(datos);
}

window.onload = function() {
    var currentPage = window.location.pathname.split('/').pop();
    
    if(currentPage === 'menu.php' || currentPage === 'ubicacion.php' || currentPage === 'horarios.php' || currentPage === 'contacto.php') {
        verificarSesionActiva();
    }
    
    if(currentPage === 'login.php') {
        var loginForm = document.getElementById('loginForm');
        if(loginForm) {
            loginForm.addEventListener('submit', realizarLogin);
        } else {
            console.error("Formulario de login NO encontrado");
        }
    }
    
    if(currentPage === 'registro.php') {
        var registerForm = document.getElementById('registerForm');
        if(registerForm) {
            registerForm.addEventListener('submit', realizarRegistro);
        } else {
            console.error("Formulario de registro NO encontrado");
        }
    }
}