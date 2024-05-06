<?php
class Usuario {
  public function crear($nombres, $apellidos, $documento, $email, $password) {
      include("conexion.php");
      
      // Validar si ya existe un usuario con el mismo documento
      $sql = "SELECT * FROM usuarios WHERE nro_documento = '$documento'";
      $result = $db->query($sql);
      
      if ($result->num_rows > 0) {
          echo '<script>alert("¡La cédula ya está registrada con otro usuario!"); window.location = "crear_usuario.php";</script>';
          return;
      }
      
      // Validar si ya existe un usuario con el mismo correo
      $sql = "SELECT * FROM usuarios WHERE correo_corp = '$email'";
      $result = $db->query($sql);
      
      if ($result->num_rows > 0) {
          echo '<script>alert("¡El correo ya está registrado con otro usuario!"); window.location = "crear_usuario.php";</script>';
          return;
      }
      
      // Verificar requisitos de contraseña
      if (strlen($password) < 8 || !preg_match("/[a-z]/", $password) || !preg_match("/[A-Z]/", $password) || !preg_match("/[0-9]/", $password) || !preg_match("/[!@#$%^&*()\-_=+{};:,<.>]/", $password)) {
          echo '<script>alert("¡La contraseña debe contener al menos 8 caracteres, una letra mayúscula, una letra minúscula, un número y un carácter especial!"); window.location = "crear_usuario.php";</script>';
          return;
      }
      
      // Generar un salt aleatorio
      
      // Concatenar el salt con la contraseña y luego hacer el hash
      $hashedPassword = password_hash($password , PASSWORD_DEFAULT);
      
      // Insertar el nuevo usuario en la base de datos
      $sql = "INSERT INTO usuarios (nombres, apellidos, nro_documento, correo_corp, password) VALUES ('$nombres', '$apellidos', '$documento', '$email', '$hashedPassword')";
      
      if ($db->query($sql)) {
          echo '<script>alert("¡Usuario registrado correctamente! Puede iniciar sesión."); window.location = "biometrias_prueba\index.php";</script>';
      } else {
          die('Hubo un error al registrar el usuario: ' . $db->error);
      }
  }
}

$final = new Usuario();
$final->crear($_POST["nombres"], $_POST["apellidos"], $_POST["documento"], $_POST["email"], $_POST["password"]);
?>
