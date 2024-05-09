<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de contraseña</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="login-container">
        <form class="login-form" method="POST" action="recuperando_contraseña.php">
            <div class="logo-container">
                <img src="migracion_logo.png" alt="Logo">
            </div>
            <h2>Recuperacion de Contraseña</h2>
            
            <div class="input-group">
                <label for="email">ingrese su correo:</label>
                <input type="email" id="email" name="email" required autocomplete="off"  >
            </div>
            <a class="text-reg" link href="crear_usuario.php"> <p >¿No está registrado? REGÍSTRESE</p> </a> </br>
            <a class="text-reg" link href="recuperar_contraseña.php"> <p >¿Olvidó la contraseña?</p> </a>
            <button type="submit">REGISTRAR</button>
        </form>
        
    </div>
</body>
</html>
