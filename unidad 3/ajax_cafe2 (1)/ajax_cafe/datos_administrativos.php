<?php
// FORZAR MUESTRA DE ERRORES para depurar el error 500
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');
session_start();

// --- 1. CONFIGURACIÓN DE LA BASE DE DATOS ---
$host = "localhost";
$db = "andatti";
$user = "root";
$pass = "";
$charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Manejo estricto de errores
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,     // Devolver resultados como array asociativo
    PDO::ATTR_EMULATE_PREPARES   => false,                // Deshabilitar emulación de consultas preparadas (más seguro)
];

try {
    // Intenta crear la conexión PDO
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Si falla, devuelve un error JSON y termina el script
    echo json_encode(["error" => "Error de conexión a la base de datos: " . $e->getMessage()]);
    exit();
}
// --- FIN CONFIGURACIÓN DE LA BASE DE DATOS ---


$accion = $_GET["accion"] ?? "";

// --- 2. ACCIÓN: VERIFICAR SESIÓN ---
if ($accion == "verificar") {
    // Atención: Ahora la sesión guarda el ID de empleado (num_empleados) en user_id
    if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] != "") {
        // Devuelve el estado de la sesión activa
        echo json_encode([
            "logueado" => true,
            "user" => $_SESSION["user"]
        ]);
    } else {
        echo json_encode(["logueado" => false]);
    }
    // No cerramos la conexión PDO aquí; se cerrará automáticamente al final del script
    exit();
}
if ($accion == "login") {
    // Recoge los datos del POST (los mismos nombres que envías desde JS)
    $nombre = $_POST["nombre"] ?? "";
    $password_input = $_POST["password"] ?? "";
    $id = $_POST["id"] ?? "";
    
    if (empty($nombre) || empty($password_input) || empty($id)) {
        echo json_encode([
            "success" => false,
            "mensaje" => "Por favor completa todos los campos"
        ]);
        exit();
    }
    $sql = "SELECT num_empleados, nombre, nivel, contraseña FROM empleados WHERE nombre = :nombre AND num_empleados = :id AND contraseña = :password";
    $stmt = $pdo->prepare($sql);
    
    // Vincula los parámetros de forma segura
    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':password', $password_input, PDO::PARAM_STR);
    
    // Intenta ejecutar la consulta. 
    $stmt->execute();
    $fila = $stmt->fetch(); // Obtiene la primera (y única) fila

    if ($fila) {
        // Login exitoso
        // CORRECCIÓN: Usamos num_empleados para el ID de sesión
        $_SESSION["user_id"] = $fila["num_empleados"];
        $_SESSION["user"] = [
            "nombre" => $fila["nombre"],
            "nivel" => $fila["nivel"]
        ];
        
        echo json_encode([
            "success" => true,
            "user" => $fila["nombre"],
            "nivel" => $fila["nivel"]
        ]);
            
    } else {
        echo json_encode([
            "success" => false,
            "mensaje" => "Número de control, usuario o contraseña incorrectos"
        ]);
    }
    exit();
}

if ($accion == "logout") {
    session_unset();
    session_destroy();
    echo json_encode(["success" => true, "mensaje" => "Sesión cerrada"]);
    exit();
}
?>