<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="migracion_temp\images\favicon.png" />
    <link rel="stylesheet" href="ventana_emergente.css">
    <title>Evaluar usuario</title>
</head>
<body>

<?php
class Usuario {
    public function evaluar($documento, $password) {
        $nnombres = "sin registro";
        $cont = 0;
        
        include("conexion.php");
        $sql = "SELECT * FROM usuarios WHERE nro_documento='$documento'";
        
        if (!$result = $db->query($sql)) {
            die('Hay un error corriendo en la consulta o datos no encontrados!!! [' . $db->error . ']');
        }
        
        while ($row = $result->fetch_assoc()) {
            $hashAlmacenada = $row["password"];
            $nnombres = stripslashes($row["nombres"]);
            $cont++;
            $_SESSION["documento"] = $documento;
            $_SESSION["nombre_usuario"] = $nnombres; // Guarda el nombre del usuario en una variable de sesión
            
            // Verificar si el estado de confirmación es 0
            if ($row['estado_confirmacion'] == 0) {
                // Mostrar mensaje indicando que la cuenta no está confirmada
            echo "   <div class='window-notice' id='window-notice'>";
    echo "    <div class='content'>";
    echo "<div class='content-text'>¡Alerta! <br> Por favor, confirme su cuenta en el correo electrónico.<br> <a href='index.php'>inténtalo nuevamente.! </a>";
     echo "       </div>";
     echo "   </div>";
                return; // Terminar la ejecución del método
            }
        }
        
        if ($cont != 0 && password_verify($password, $hashAlmacenada )) {
            header("location:autenticacion_exitosa.php");
        } else {
            echo "   <div class='window-notice' id='window-notice'>";
    echo "    <div class='content'>";
    echo "<div class='content-text'>¡Datos incorrectos <br> <a href='index.php'> inténtalo nuevamente.! </a>";
     echo "       </div>";
     echo "   </div>";
        }
    }
}

$final = new Usuario();
$final->evaluar($_POST["documento"], $_POST["password"]);
?>
</body>
</html>


