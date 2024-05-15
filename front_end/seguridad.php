<?php
// Configurar el tiempo de vida máxima de la sesión y el tiempo de expiración de la cookie de sesión
ini_set('session.gc_maxlifetime', 60); // 30 minutos
session_set_cookie_params(60);

session_start(); // Iniciar o reanudar la sesión

if (!isset($_SESSION['documento']) || empty($_SESSION['documento'])) {
    // Si no hay sesión activa, redirigir al usuario a la página de inicio de sesión
    header("location:/biometrias/index.php"); // Cambia esto según tu estructura de URLs
    exit();
}
?>
