<?php require_once("seguridad.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Asignar roles</title>
  <link rel="stylesheet" href="../front_end/formularios.css">
  <link rel="icon" type="image/png" href="../migracion_temp/images/favicon.png" />
  <link rel="stylesheet" href="botones.css">


  

</head>
<body>
  <?php include("../menu/menu.php"); ?>
  <h1>Asignar roles</h1>
  <?php


echo "<form name='' action='asignando_permisos.php' method='POST'>";
echo "<label>Usuario</label>"; 
echo "<select name='documento' required>";
echo "<option value=''>Seleccione:</option>";

class Usuario{
    public function asignar_rol(){
        include ("conexion.php");
        $sql = "SELECT * FROM usuarios";
        if(!$result = $db->query($sql)){
          die('Hay un error corriendo en la consulta o datos no encontrados!!! [' . $db->error . ']');
        }
        
        
        
        while($row = $result->fetch_assoc())
        {
           
            
            $aapellidos=stripslashes($row["apellidos"]);
            $nnombres=stripslashes($row["nombres"]);
            $ddocumento=stripslashes($row["nro_documento"]);
            echo "<option value='$ddocumento'> $nnombres $aapellidos</option>";
        
        
            
           
        }
        echo "</select>";
        
        echo "<br/>";echo "<br/>";echo "<br/>";
        echo "<label>Seleccione Rol:</label>";
      
       
        echo "<select name='fk_id_rol' required>";
        echo "<option value=''>Seleccione:</option>";
        $sql = "SELECT * FROM roles";
        if(!$result = $db->query($sql)){
          die('Hay un error corriendo en la consulta o datos no encontrados!!! [' . $db->error . ']');
        }
        while($row = $result->fetch_assoc())
        {

            $iid_rol=stripslashes($row["id_rol"]);
            $rrol=stripslashes($row["rol"]);
            echo "<option value='$iid_rol'>$rrol</option>";
        }    
        echo "</select>";
        
        echo "<br/>";echo "<br/>";
        echo "<input type='submit' value='Asignar rol' class='boton-enviar'>";
        
        
        
        echo "</form></br>";

    }
}
$final= new Usuario();
$final->asignar_rol();

?>





    <div class='button'>
<p><a href='..\front_end\mis_funciones.php'id="atras_bio" class='btn btn-primary' role='button'>Volver atras</a></p>

</div>
        

  
  
  

  <?php include("../menu/footer.php"); ?>   
</body>
</html>
