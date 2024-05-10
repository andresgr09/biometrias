<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="migracion_temp\images\favicon.png" />
    <link rel="stylesheet" href="ventana_emergente.css">
    <title>Confirmar cuenta</title>
</head>
<body>
    

<?php
include("conexion.php");

if(isset($_GET['identificador'])) {
    $identifier = $_GET['identificador'];

    // Buscar el hash correspondiente en la base de datos
    $sql = "SELECT hash FROM hash_identificador WHERE identificador = '$identifier'";
    $result = $db->query($sql);

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hash = $row['hash'];

        // Actualizar el estado de confirmación del usuario a confirmado
        $sql_update = "UPDATE usuarios SET estado_confirmacion = 1 WHERE hash = '$hash'";
        if($db->query($sql_update)) {
            echo "   <div class='window-notice' id='window-notice'>";
            echo "    <div class='content'>";
            echo "<div class='content-text'>¡Tu cuenta ha sido confirmada correctamente.<a href='index.php'>  Ahora puedes iniciar sesión.! </a>";
            echo "       </div>";
            echo "   </div>";
        } else {
            echo "Error al confirmar tu cuenta. Por favor, inténtalo de nuevo más tarde.";
        }
    } else {
        echo "   <div class='window-notice' id='window-notice'>";
            echo "    <div class='content'>";
            echo "<div class='content-text'>¡El enlace de confirmación es inválido o ha expirado.'><a href='index.php'>  Volver a intentar! </a>";
            echo "       </div>";
            echo "   </div>";
    }
} else {

    echo "   <div class='window-notice' id='window-notice'>";
            echo "    <div class='content'>";
            echo "<div class='content-text'>¡El enlace de confirmación es inválido o ha expirado.'><a href='index.php'>  Volver a intentar! </a>";
            echo "       </div>";
            echo "   </div>";
}
?>
</body>
</html>