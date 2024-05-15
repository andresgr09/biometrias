<?php
session_start(); // Iniciar o reanudar la sesión

// Destruir todas las variables de sesión
session_unset();
// Destruir la sesión
session_destroy();

// Redirigir al usuario a la página de inicio de sesión u otra página
header("location:..\index.php"); // Cambia esto según tu estructura de URLs
exit();
?>
