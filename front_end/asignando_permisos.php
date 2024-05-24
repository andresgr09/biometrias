<?php include("seguridad.php");?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="migracion_temp/images/favicon.png" />
    <link rel="stylesheet" href="../estilos_login/ventana_emergente.css">
    <title>Asignando rol</title>
</head>
<body>
  
</head>
<body>

<?php
class Usuario{

    public function asignando_rol($documento,$fk_id_rol){
        $existe="0";
        include("conexion.php");
                $sql = "SELECT * FROM permisos WHERE nro_documento='$documento' AND rol='$fk_id_rol'";
if(!$result = $db->query($sql)){
  die('Hay un error corriendo en la consulta o datos no encontrados!!! [' . $db->error . ']');
}
while($row = $result->fetch_assoc())
{
	$ddocumento=stripslashes($row["nro_documento"]);
    $fk_id_rol=stripcslashes($row["rol"]);
    $existe=$existe+1;
			
}
    if ($existe=="0")
    {
                include ("conexion.php");
                mysqli_query($db,"INSERT INTO permisos (id_permiso, nro_documento, rol) VALUES 
(NULL, '$documento', '$fk_id_rol')") or die(mysqli_error($db));
echo "Permiso registrado correctamente";
            echo "<div class='window-notice' id='window-notice'>";
            echo "<div class='content'>";
            echo "<div class='content-text'>¡Permiso registrado correctamente <br><a href='asignar_permisos.php'> volver a asignar roles.!</a>";
            echo "</div>";
            echo "</div>";
}
if ($existe!="0")
{

echo "<div class='window-notice' id='window-notice'>";
            echo "<div class='content'>";
            echo "<div class='content-text'>¡El permiso ya existe <br><a href='asignar_permisos.php'> volver a asignar roles.!</a>";
            echo "</div>";
            echo "</div>";
}



   }
 }

$final= new Usuario();
$final->asignando_rol($_POST["documento"],$_POST["fk_id_rol"]);
?>  
</body>
</html>