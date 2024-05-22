<?php
    include ("seguridad.php");
?>
<!DOCTYPE html>
 <html>
 <head>
   <title> actualizando datos</title>
 </head>
 <body>
 
 
 <?php
        class acdatos{
            public function actualizando_datos($id_usuario,$nombres, $apellidos,$documento, $correo ){
            {

        
               include ("conexion.php");
               mysqli_query($db,"UPDATE usuarios SET nombres = '$nombres' WHERE id_usuario='$id_usuario'");
               mysqli_query($db,"UPDATE usuarios SET apellidos = '$apellidos' WHERE id_usuario='$id_usuario'");
               mysqli_query($db,"UPDATE usuarios SET nro_documento = '$documento' WHERE id_usuario='$id_usuario'");
               mysqli_query($db,"UPDATE usuarios SET correo_corp = '$correo' WHERE id_usuario='$id_usuario'");
            
              
                header("location:actualizar_datos.php");

            //    echo'<script>alert("datos actualizados!"); window.location = "location:/proyecto_oracle/front_end/actualizar_datos.php;"</script>';
                }
            }
          }
       
$final= new acdatos();
$final->actualizando_datos($_POST["id_usuario"],$_POST["nombres"],$_POST["apellidos"],$_POST["nro_documento"],$_POST["correo_corp"]);
?>
</body>
 </html>