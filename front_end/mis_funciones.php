
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
 
   <?php

 
class Usuario{
    public function mis_permisos(){
        $documento=$_SESSION["documento"];
      
        include ("conexion.php");
         $sql2 = "SELECT * FROM permisos WHERE nro_documento='$documento'";
         if(!$result2 = $db->query($sql2)){
           die('Hay un error corriendo en la consulta o datos no encontrados!!! [' . $db->error . ']');
         }
         while($row2 = $result2->fetch_assoc())
         {
             $ffk_id_rol=stripslashes($row2["rol"]);
             $ddocumento=stripslashes($row2["nro_documento"]);
          
            
             if ($ffk_id_rol=="1")
             {
                $_SESSION["usuario"]="1";
                
                echo "   <div class='button'>";
                 echo "      <p> <a href='../front_end/descarga_biometrias.php' class='btn btn-link' id='personasbtn' role='button'> Descarga de Biometrías</a> </p>";
                  echo "    <p> <a href='../front_end/reporte_biometrias.php' class='btn btn-link' id='replicas-btn' role='button'> Informe bíometrias descargadas</a> </p>";
                

          
             }
             if ($ffk_id_rol=="2")
             {
                $_SESSION["administrador"]="1";            
           
                echo "      <p id='boton'> <a href='../front_end/asignar_permisos.php' class='btn btn-link' id='personasbtn' role='button'> Asignar roles</a> </p>";

                echo "  </div>";
             }
          }
 
    }
}
$final= new Usuario();
$final->mis_permisos();     

?>   

  


  
</div>



      
    
    
              
 <center><a class="btn btn-primary" id="atras" href="..\front_end\autenticacion_exitosa.php" role="button" id="atras">Atras</a></center>
</body>
</footer></footer>

<?php
 include ("../menu/footer.php");
 ?>
</html>


