<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ventana_emergente.css">
    <title>Document</title>
</head>
<body>
    
<?php
include("conexion.php");

// Verificar si se proporciona un hash en la URL
// if(isset($_GET['hash'])) {
//     $hash = $_GET['hash'];

if(isset($_GET['hash'])) {
    $hash = $_GET['hash'];
    // Buscar el hash en la base de datos
    $sql = "SELECT * FROM usuarios WHERE hash = '$hash'";
    $result = $db->query($sql);

    if($result->num_rows > 0) {
        // Actualizar el estado de confirmación del usuario a confirmado
        $sql_update = "UPDATE usuarios SET estado_confirmacion = 1 WHERE hash = '$hash'";
        if($db->query($sql_update)) {
           echo" <div class='window-notice' id='window-notice'>";
      echo"  <div class='content'>";
      echo"      <div class='content-text'>Tu cuenta ha sido confirmada correctamente. <a href='index.php'>Ahora puedes iniciar sesión. ";
       echo" </div>";
  echo"  </div>";
        } else {
            echo" <div class='window-notice' id='window-notice'>";
            echo"  <div class='content'>";
            echo"      <div class='content-text'>Tu cuenta ha sido confirmada correctamente. <a href='index.php'>Ahora puedes iniciar sesión. ";
            echo" </div>";
            echo"  </div>";
        }
    } else {
        echo" <div class='window-notice' id='window-notice'>";
        echo"  <div class='content'>";
        echo"      <div class='content-text'>El enlace de confirmación es inválido o ha expirado. <a href='index.php'>Volver atras. ";
        echo" </div>";
        echo"  </div>";
    }
} else {

    echo" <div class='window-notice' id='window-notice'>";
    echo"  <div class='content'>";
    echo"      <div class='content-text'>El enlace de confirmación es inválido o ha expirado. <a href='index.php'>Volver atras. ";
    echo" </div>";
    echo"  </div>";
}
?>
</body>
</html>