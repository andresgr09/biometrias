<?php require_once("seguridad.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="formpassword.css" rel="stylesheet" />
  <link rel="stylesheet" href="botones.css">
  <title>Actualizar Contraseña</title>


</head>
<body>
  <?php include("../menu/menu.php");?>
<h1>Cambiar contraseña</h1>
  <form action="actualizando_contraseña.php" method="POST" autocomplete="off">
  <label for="nombre">Nueva contraseña:</label>
  <input type="password" id="nombre" name="nueva_password" placeholder="Ingrese su nueva contraseña aquí" required >
  <br/><input type="submit" name="" value='Actualizar' class=''>
</form>
    </form>
 
    <div class="button">
    <p><a href="autenticacion_exitosa.php" class="btn btn-link" role='button'>volver atras</a></p>
</div>
  <?php include("../menu/footer.php");?>
</body>
</html>
