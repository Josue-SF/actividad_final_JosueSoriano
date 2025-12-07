<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$bd = "andatti";
$accion = $_GET["accion"] ?? "";

$conexion = mysqli_connect($servidor, $usuario, $contraseña, $bd);

if (!$conexion) {
    echo json_encode(["error" => "Error de conexión a la base de datos: " . mysqli_connect_error()]);
    exit();
}

mysqli_set_charset($conexion, "utf8mb4");

// Acción: Verificar sesión
if ($accion == "verificar") {
    if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] != "") {
        echo json_encode([
            "logueado" => true,
            "user" => $_SESSION["user"]
        ]);
    } else {
        echo json_encode(["logueado" => false]);
    }
    mysqli_close($conexion);
    exit();
}

// Acción: Verificar si usuario existe
if ($accion == "verificar_usuario") {
    $username = $_GET["username"] ?? "";
    
    if (empty($username)) {
        echo json_encode(["existe" => false]);
        mysqli_close($conexion);
        exit();
    }
    
    $stmt = mysqli_prepare($conexion, "SELECT num_usuario FROM usuarios WHERE nombre = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        echo json_encode(["existe" => true]);
    } else {
        echo json_encode(["existe" => false]);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
    exit();
}

// Acción: Login
if ($accion == "login") {
    $nombre = $_POST["nombre"] ?? "";
    $pass = $_POST["password"] ?? "";
    
    if (empty($nombre) || empty($pass)) {
        echo json_encode([
            "success" => false,
            "mensaje" => "Por favor completa todos los campos"
        ]);
        mysqli_close($conexion);
        exit();
    }
    
    $stmt = mysqli_prepare($conexion, "SELECT num_usuario, nombre FROM usuarios WHERE nombre = ? AND contraseña = ?");
    mysqli_stmt_bind_param($stmt, "ss", $nombre, $pass);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);
        $_SESSION["user_id"] = $fila["num_usuario"];
        $_SESSION["user"] = $fila["nombre"];
        
        echo json_encode([
            "success" => true,
            "user" => $fila["nombre"]
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "mensaje" => "Usuario o contraseña incorrectos"
        ]);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
    exit();
}


if ($accion == "registrar") {
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";
    
    if (empty($username) || empty($password)) {
        echo json_encode([
            "success" => false,
            "mensaje" => "Todos los campos son obligatorios"
        ]);
        mysqli_close($conexion);
        exit();
    }
    
    if (strlen($password) < 4) {
        echo json_encode([
            "success" => false,
            "mensaje" => "La contraseña debe tener al menos 4 caracteres"
        ]);
        mysqli_close($conexion);
        exit();
    }
    
    // Verificar si el usuario ya existe
    $stmt = mysqli_prepare($conexion, "SELECT num_usuario FROM usuarios WHERE nombre = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        echo json_encode([
            "success" => false,
            "mensaje" => "El nombre de usuario ya está registrado"
        ]);
        mysqli_stmt_close($stmt);
    } else {
        mysqli_stmt_close($stmt);
        
        // Insertar nuevo usuario
        $stmt_insert = mysqli_prepare($conexion, "INSERT INTO usuarios (nombre, contraseña) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt_insert, "ss", $username, $password);
        
        if (mysqli_stmt_execute($stmt_insert)) {
            echo json_encode([
                "success" => true,
                "mensaje" => "Usuario registrado exitosamente"
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "mensaje" => "Error al registrar usuario: " . mysqli_error($conexion)
            ]);
        }
        mysqli_stmt_close($stmt_insert);
    }
    mysqli_close($conexion);
    exit();
}

// Acción: Cerrar sesión
if ($accion == "logout") {
    session_destroy();
    echo json_encode(["success" => true]);
    mysqli_close($conexion);
    exit();
}

// Si no hay acción válida
echo json_encode(["error" => "Acción no válida"]);
mysqli_close($conexion);
?>