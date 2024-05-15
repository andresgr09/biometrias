<?php require_once("seguridad.php"); ?>

<!DOCTYPE html>
<html lang="en">
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
   

      <form action="descargando_biometrias.PHP" method="POST" required>
        <label for="he"> Ingrese número(s) de HE: <br> <br> 

          <input type="radio" name="opcion" id="una_biometria" value="opcion1">
          <label for="opcion1">1 He</label><br>
          
          <input type="radio" name="opcion" id="dos_biometrias" value="opcion2">
          <label for="opcion2">2 o mas He</label><br>
          <div id="campo_nombres" >
            <label for=""></label>
            <input type="text" id="he" name="he" placeholder="Ingrese nro(s) HE"  required autocomplete="off" pattern="[0-9]+">
            <input type="submit" value="Descargar">
            <p id="nota">Nota: ¡Si son 2 o mas HE, separarlos por comas! </p> 
            <!-- &#9888; simbolo-->  
          </div>
      </form>
    </div>
    <div class='button'>
<p><a href='..\front_end\mis_funciones.php'id="atras_bio" class='btn btn-primary' role='button'>Volver atras</a></p>

</div>
        

  
  
  

  <?php include("../menu/footer.php"); ?>   
</body>
</html>
