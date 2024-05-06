<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="login-container">
        <form class="login-form" method="POST" action="evaluar_usuario.php">
            <div class="logo-container">
                <img src="migracion_logo.png" alt="Logo">
            </div>
            <h2>Biometrias</h2>
            <div class="input-group">
                <label for="documento">Número de Documento:</label>
                <input type="text" id="documento" name="documento" required>
            </div>
            <div class="input-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <a class="text-reg" link href="crear_usuario.php"> <p >¿No está registrado? REGÍSTRESE</p> </a> </br>
            <a class="text-reg" link href="recuperar_contraseña.php"> <p >¿Olvidóoo la contraseña?</p> </a>
            <button type="submit">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>
