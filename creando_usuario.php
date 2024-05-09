<?php
include("conexion.php");

class Usuario {
    public function crear($nombres, $apellidos, $documento, $email, $password) {
        global $db;

        // Validar si ya existe un usuario con el mismo documento
        $sql = "SELECT * FROM usuarios WHERE nro_documento = '$documento'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            echo '<script>alert("¡La cédula ya está registrada con otro usuario!"); window.location = "crear_usuario.php";</script>';
            return false;
        }

        // Validar si ya existe un usuario con el mismo correo
        $sql = "SELECT * FROM usuarios WHERE correo_corp = '$email'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            echo '<script>alert("¡El correo ya está registrado con otro usuario!"); window.location = "crear_usuario.php";</script>';
            return false;
        }

        // Verificar requisitos de contraseña
        if (strlen($password) < 8 || !preg_match("/[a-z]/", $password) || !preg_match("/[A-Z]/", $password) || !preg_match("/[0-9]/", $password) || !preg_match("/[!@#$%^&*()\-_=+{};:,<.>]/", $password)) {
            echo '<script>alert("¡La contraseña debe contener al menos 8 caracteres, una letra mayúscula, una letra minúscula, un número y un carácter especial!"); window.location = "crear_usuario.php";</script>';
            return false;
        }

        // Hash de la contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Generar un hash único para confirmación de cuenta
        $hash = md5(rand(0,1000));

        // Insertar el nuevo usuario en la base de datos con estado de confirmación no confirmado (0)
        $sql = "INSERT INTO usuarios (nombres, apellidos, nro_documento, correo_corp, password, estado_confirmacion, hash) VALUES ('$nombres', '$apellidos', '$documento', '$email', '$hashedPassword', 0, '$hash')";

        if ($db->query($sql)) {
            return array('email' => $email, 'hash' => $hash); // Retornar el correo electrónico y el hash del usuario registrado
        } else {
            die('Hubo un error al registrar el usuario: ' . $db->error);
        }
    }
}

class CorreoConfirmacion {
    public function enviarCorreoConfirmacion($email, $hash) {
        require 'PHPMailer/PHPMailer/Exception.php';
        require 'PHPMailer/PHPMailer/PHPMailer.php';
        require 'PHPMailer/PHPMailer/SMTP.php';

        $mail = new PHPMailer\PHPMailer\PHPMailer();

        // Configurar el servidor SMTP
        $mail->SMTPDebug = 0; // Habilitar la salida de depuración detallada
        $mail->isSMTP(); // Usar SMTP
        $mail->Host = 'relay.migracioncolombia.gov.co'; // Servidor SMTP
        $mail->SMTPAuth = false; // Autenticación SMTP deshabilitada
        $mail->Username = 'confirmacion@migracioncolombia.gov.co'; // Correo de origen
        $mail->SMTPAutoTLS = false; // Deshabilitar el cifrado automático TLS
        $mail->Port = 25; // Puerto SMTP

        // Configurar el correo electrónico
        $mail->setFrom('biometrias@migracioncolombia.gov.co'); // Remitente
        $mail->addAddress($email); // Destinatario
        $mail->Subject = 'confirmacion de cuenta bioemtrias'; // Asunto
        $mail->Body = utf8_encode('¡Haz clic en el siguiente enlace para confirmar tu registro: http://localhost/biometrias/confirmar_cuenta.php?hash=' . $hash);  // Cuerpo del correo

        // Enviar correo electrónico
        if ($mail->send()) {
            // No se redirige aquí, el redireccionamiento se manejará después de la confirmación
            return true;
        } else {
            return false;
        }
    }
}

// Ejemplo de uso
$usuario = new Usuario();
$registro = $usuario->crear($_POST["nombres"], $_POST["apellidos"], $_POST["documento"], $_POST["email"], $_POST["password"]);

if ($registro) {
    $correoConfirmacion = new CorreoConfirmacion();
    if ($correoConfirmacion->enviarCorreoConfirmacion($registro['email'], $registro['hash'])) {
        // Redirigir al usuario a la página de autenticación después de enviar el correo de confirmación
        header("Location: autenticacion_exitosa.php");
        exit;
    } else {
        echo '<script>alert("Error al enviar el correo electrónico de confirmación. Por favor, inténtalo nuevamente.");</script>';
    }
} else {
    echo '<script>alert("Hubo un error al crear el usuario. Por favor, inténtalo nuevamente.");</script>';
}
?>
