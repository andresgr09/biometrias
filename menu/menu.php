
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="menu\menu.cssgit ">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<?php
    echo "<nav class='menu'>";
echo "    <img src='images/migracion_logo.png' alt='Logo' class='logo'>";
if(isset($_SESSION['nombre_usuario']) && !empty($_SESSION['nombre_usuario'])) {
  $nombreUsuario = $_SESSION['nombre_usuario'];
  echo "    <div class='bienvenido'>";
  echo "        <p>¿Que desea hacer hoy?, $nombreUsuario</p>";
  } 
  echo "    </div>";
  echo "<a href='salir.php' class='logout' >Cerrar Sesión </a>";
  echo " </nav>";


?>
</body>
</html>




