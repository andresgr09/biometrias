<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de usuarios</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="login-container">
        <form class="login-form" method="POST" action="creando_usuario.php">
            <div class="logo-container">
                <img src="migracion_logo.png" alt="Logo">
            </div>
            <h2>Registro</h2>
            <div class="input-group">
                <label for="nombres">Nombres:</label>
                <input type="text" id="nombres" name="nombres" required autocomplete="off" pattern="[A-ZÑÁÉÍÓÚáéíóú a-z]+" >
            </div>
            <div class="input-group">
                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" required autocomplete="off" pattern="[A-ZÑÁÉÍÓÚáéíóú a-z]+" >
            </div>
            <div class="input-group">
                <label for="email">Correo corporativo:</label>
                <input type="email" id="email" name="email" required autocomplete="onn">
            </div>
            <div class="input-group">
                <label for="documento">Documento:</label>
                <input type="text" id="documento" name="documento"required autocomplete="onn"  pattern="[0-9]+">
            </div>
            <div class="input-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required autocomplete="off"  >
            </div>
            <a class="text-reg" link href="index.php"> <p >¿Ya está registrado? Inicie sesión</p> </a> </br>
            <button type="submit">REGISTRAR</button>
        </form>
        
    </div>
</body>
</html>
