<?php
session_start();
if (isset($_SESSION["user_id"]) && $_SESSION["password"] != "") {
    // El usuario ya ha iniciado sesión, redirigir a la página de inicio
    header("Location: registro.php");
    exit();
}
?>