
<?php
// session_start();
require_once("../seguridad.php");
// ?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">

  <title>Funciones</title>
  <link rel="icon" type="image/x-icon" href="images/logo_head.png" />

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
          
  <p> <a href="/proyecto_oracle/actualizar_replicas/replicas_mysql.php" class="btn btn-link" id="replicas-btn" role="button"> Informe bíometrias descargadas</a> </p>



  
</div>



      
    
    
              
 <center><a class="btn btn-primary" href="..\front_end\autenticacion_exitosa.php" role="button">atras</a></center>
</body>
</footer></footer>

<?php
 include ("../menu/footer.php");
 ?>
</html>


