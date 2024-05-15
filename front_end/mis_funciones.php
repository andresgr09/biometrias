
<?php
// session_start();
 require_once("seguridad.php"); 
// ?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">

  <title>Funciones</title>
  <link rel="icon" type="image/x-icon" href="images/logo_head.png" />
  <link rel="icon" type="image/png" href="../migracion_temp/images/favicon.png" />

  <link rel="stylesheet" href="../front_end/botones.css">

</head>
<style>
.loading-overlay {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  justify-content: center;
  align-items: center;
}

.loading-text {
  color: white;
}

.loading-overlay.active {
  display: flex;
}

</style>
</head>
<body>
<?php
  include("../menu/menu.php");

  ?>
   

  
 <div class="button">
  <p> <a href="../front_end/descarga_biometrias.php" class="btn btn-link" id="personasbtn" role="button"> Descarga de Biometrías</a> </p>
          
  <p> <a href="../front_end/reporte_biometrias.php" class="btn btn-link" id="replicas-btn" role="button"> Informe bíometrias descargadas</a> </p>



  
</div>



      
    
    
              
 <center><a class="btn btn-primary" id="atras" href="..\front_end\autenticacion_exitosa.php" role="button">Atras</a></center>
</body>
</footer></footer>

<?php
 include ("../menu/footer.php");
 ?>
</html>


