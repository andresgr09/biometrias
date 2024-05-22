<?php
require_once("seguridad.php");
?> // Asegúrate de que has iniciado sesión en otras partes de tu aplicación
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="migracion_temp\images\favicon.png" />
    <link rel="stylesheet" href="estilos_login\ventana_emergente.css">
    <title>Creacion usuario</title>
</head>
<body>




<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibe la nueva contraseña desde el formulario
    $nuevaPassword = $_POST["nueva_password"];

    // Verificar si el usuario ha iniciado sesión
    if (isset($_SESSION["nro_documento"])) {
        // El usuario ha iniciado sesión y está autorizado para actualizar su contraseña
        include("conexion.php"); // Asegúrate de incluir tu archivo de conexión

        $documento = $_SESSION["documento"];

        // Actualiza la contraseña
        $hashedPassword = password_hash($nuevaPassword, PASSWORD_DEFAULT);
        $updateSql = "UPDATE usuarios SET password='$hashedPassword' WHERE nro_documento='$documento'";

        if ($db->query($updateSql)) {
            echo "<div class='window-notice' id='window-notice'>";
          echo "<div class='content'>";
          echo "<div class='content-text'>Contraseña actualizada correctamente <br><a href='mis_funciones.php'>Volver a mis funciones</a></div>";
          echo "</div>";
        
        } else {
            die(echo "se actualiza correctamente" . $db->error);
        }
    } else {
        echo "<h3 class='text-true'>No estás autorizado para actualizar esta contraseña.</h3>";
        echo "<div class='text-formulario1'>";
        echo "<a href='index.php'>Volver</a>";
        echo "</div>";

        echo "<div class='window-notice' id='window-notice'>";
          echo "<div class='content'>";
          echo "<div class='content-text'>¡No estás autorizado para actualizar esta contraseña. <br><a href='index.php'>Volver a intentar</a></div>";
          echo "</div>";
    }
}
?>  
</body>
</html>