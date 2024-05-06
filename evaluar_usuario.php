<?php
session_start();
// require_once("seguridad.php");
?>
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
        }
        
        if ($cont != 0 && password_verify($password, $hashAlmacenada )) {
            echo "<h2>Bienvenido(a)  $nnombres </h2>";
            header("location:autenticacion_exitosa.php");
        } else {
            echo'<script>alert("Datos incorrectos"); window.location = "http://localhost/biometrias/index.php";</script>';
        }
    }
}

$final = new Usuario();
$final->evaluar($_POST["documento"], $_POST["password"]);
?>
