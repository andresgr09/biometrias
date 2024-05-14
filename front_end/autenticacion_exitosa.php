<?php
require_once("seguridad.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="botones.css">
    <link rel="icon" type="image/png" href="../migracion_temp/images/favicon.png" />
    <title>Funciones</title>
</head>
<body>
    <?php include("../menu/menu.php");
    include ("conexion_oracle.php");
?>
    <?php
    if(isset($_SESSION['nombre_usuario']) && !empty($_SESSION['nombre_usuario'])) {
        $nombreUsuario = $_SESSION['nombre_usuario'];

        } 
   
   
?>
<h1 style=text-align:center;> Bienvenido(a) <?php echo $nombreUsuario ?></h1>
<div class="button">
    <p> <a href="..\front_end\mis_funciones.php" class="btn btn-link" role="button"> Mis funciones</a> </p>
    <p> <a href="actualizar_contraseña.php" class="btn btn-link" role="button">Actualizar contraseña</a> </p>
    <p> <a href="actualizar_datos.php" class="btn btn-link" role="button">Actualizar mis datos</a> </p>
</div>


<?php
include("../menu/footer.php")
?>
    
</body>
</html>