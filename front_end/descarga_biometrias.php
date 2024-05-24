<?php require_once("seguridad.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Biometrias</title>
  <link rel="stylesheet" href="../front_end/formularios.css">
  <link rel="icon" type="image/png" href="../migracion_temp/images/favicon.png" />
  <link rel="stylesheet" href="botones.css">
</head>
<body>
  <?php include("../menu/menu.php"); ?>

  <div class="wrapper fadeInDown">
    <div id="formContent">
      <br>
      <h1 style='text-align:center'>Descarga Bíometria(s)</h1>

      <form action="descargando_biometrias.php" method="POST">
    <h3>Ingrese nro(s) de HE</h3>
          <div id="campo_nombres">
            <label for="he"></label>
            <input type="text" id="he" name="he" placeholder="Ingrese nro(s) HE" required autocomplete="off" pattern="([0-9]+(,[0-9]+)*){1,50}">
            <input type="submit" value="Descargar">
            <p id="nota">Nota: ¡Si son 2 o más HE, separarlos por comas sin espacios!</p>
          </div>
      </form>
    </div>
  </div>

  <div class='button'>
    <p><a href='..\front_end\mis_funciones.php' id="atras_bio" class='btn btn-primary' role='button'>Volver atrás</a></p>
  </div>

  <?php include("../menu/footer.php"); ?>
</body>
</html>
