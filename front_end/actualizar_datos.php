<?php
ob_start();
include("seguridad.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="formpassword.css" rel="stylesheet" />
  <link rel="stylesheet" href="botones.css">
  <title>Actualizar mis datos</title>

</head>
<body>
  <?php include("../menu/menu.php");?>
  <h1>Actualizar mis datos</h1>

<?php
class misdatos {
    public function actualizar_datos($documento) {
        include("conexion.php");
        $sql = "SELECT * FROM usuarios WHERE nro_documento='$documento'";
        if (!$result = $db->query($sql)) {
            die('Hay un error corriendo en la consulta o datos no encontrados!!! [' . $db->error . ']');
        }
        // Verificar si hay resultados antes de iterar sobre ellos
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id_usuario = stripslashes($row["id_usuario"]);
                $nombres = stripslashes($row["nombres"]);
                $apellidos = stripslashes($row["apellidos"]);
                $documento = stripslashes($row["nro_documento"]);
                $correo = stripslashes($row["correo_corp"]);
            }
        } 
?>

  <form name='' method='POST' action='actualizando_datos.php' >
    <input name='id_usuario' type='hidden' value='<?php echo $id_usuario; ?>'>
    <label>Nombres:</label><input name='nombres' type='text' value='<?php echo $nombres; ?>'><br/>
    <label>Apellidos:</label> <input name='apellidos' type='text' value='<?php echo $apellidos; ?>'><br/>
    <label>Documento:</label> <input name='nro_documento' type='text' value='<?php echo $documento; ?>'><br/>
    <label>Correo:</label> <input name='correo_corp' type='mail' value='<?php echo $correo; ?>'><br/>
    <input type='submit' value='Actualizar datos'>
  </form>

<?php
    }
}

// Verificar si 'documento' está definido antes de llamar a la función
if (isset($_SESSION["documento"])) {
    $final = new misdatos();
    $final->actualizar_datos($_SESSION["documento"]);
} else {
    echo "No se ha encontrado un documento de usuario válido.";
}
?>
 
<div class="button">
    <p><a href="mis_funciones.php" class="btn btn-link" role='button'>volver atras</a></p>
</div>
<?php include("../menu/footer.php");?>
</body>
</html>
