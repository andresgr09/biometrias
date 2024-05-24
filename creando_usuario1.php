<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="migracion_temp/images/favicon.png" />
    <link rel="stylesheet" href="estilos_login/ventana_emergente.css">
    <title>Creacion usuario</title>
</head>
<body>
<?php
include("conexion.php");
include("validaciones.php"); // Incluir el archivo con las funciones de validación

class Usuario {
    public function crear($nombres, $apellidos, $documento, $email, $password) {
        global $db;

        // Validar si ya existe un usuario con el mismo documento
        $sql = "SELECT * FROM usuarios WHERE nro_documento = '$documento'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            return "La cédula ya está registrada con otro usuario.";
        }

        // Validar si ya existe un usuario con el mismo correo
        $sql = "SELECT * FROM usuarios WHERE correo_corp = '$email'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            return "El correo ya está registrado con otro usuario.";
        }

        // Verificar requisitos de contraseña
       

        // Validar el campo de nombres
        if (!validarNombres($nombres)) {
            echo "<div class='window-notice' id='window-notice'>";
            echo "<div class='content'>";
            echo "<div class='content-text'>Los nombres contienen caracteres no permitidos <br><a href='crear_usuario.php'> inténtalo nuevamente.!</a>";
            echo "</div>";
            echo "</div>";
            exit;
        }

        // Validar el campo de apellidos
        if (!validarApellidos($apellidos)) {
            echo "<div class='window-notice' id='window-notice'>";
            echo "<div class='content'>";
            echo "<div class='content-text'>Los apellidos contienen caracteres no permitidos <br><a href='crear_usuario.php'> inténtalo nuevamente.!</a>";
            echo "</div>";
            echo "</div>";
            exit;
        }

        if (!validarEmail($email)) {
            echo "<div class='window-notice' id='window-notice'>";
            echo "<div class='content'>";
            echo "<div class='content-text'>El correo electrónico debe tener el dominio @migracioncolombia.gov.co <br><a href='crear_usuario.php'> inténtalo nuevamente.!</a>";
            echo "</div>";
            echo "</div>";
            exit;
        }

        if (!validarDocumento($documento)) {
            echo "<div class='window-notice' id='window-notice'>";
            echo "<div class='content'>";
            echo "<div class='content-text'>El numero de documento no puede contener letras o caracteres especiales<br><a href='crear_usuario.php'> inténtalo nuevamente.!</a>";
            echo "</div>";
            echo "</div>";
            exit;
        }
        if (!validarContraseña($password)) {
            echo "<div class='window-notice' id='window-notice'>";
            echo "<div class='content'>";
            echo "<div class='content-text'>La contraseña debe cumplir con los estándares de seguridad requeridos.<br>Asegúrate de que tu contraseña tenga al menos 8 caracteres y contenga una combinación de letras mayúsculas, minúsculas, al menos 1 número y 1 caracter especial.<br><a href='index.php'> inténtalo nuevamente.!</a>";
            echo "</div>";
            echo "</div>";
            exit;
        }
        // Hash de la contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Generar un hash único para confirmación de cuenta
        $hash = md5(rand(0, 1000));

        // Iniciar una transacción
        $db->begin_transaction();

        try {
            // Consulta para insertar en la tabla usuarios
            $sql = "INSERT INTO usuarios (nombres, apellidos, nro_documento, correo_corp, password, estado_confirmacion, hash) 
                    VALUES ('$nombres', '$apellidos', '$documento', '$email', '$hashedPassword', 0, '$hash')";

            if ($db->query($sql)) {
                // Consulta para insertar en la tabla permisos
                $fk_id_rol = 1;
                $sqlPermisos = "INSERT INTO permisos (id_permiso, nro_documento, rol) 
                                VALUES (NULL, '$documento', '$fk_id_rol')";

                if ($db->query($sqlPermisos)) {
                    // Confirmar la transacción
                    $db->commit();
                    return array('email' => $email, 'hash' => $hash);
                } else {
                    // Si hay un error al insertar en permisos, deshacer la transacción
                    $db->rollback();
                    return "Hubo un error al registrar los permisos: " . $db->error;
                }
            } else {
                // Si hay un error al insertar en usuarios, deshacer la transacción
                $db->rollback();
                return "Hubo un error al registrar el usuario: " . $db->error;
            }
        } catch (Exception $e) {
            // En caso de cualquier excepción, deshacer la transacción
            $db->rollback();
            return "Hubo un error: " . $e->getMessage();
        }
    }
}

class CorreoConfirmacion {
    public function enviarCorreoConfirmacion($email, $hash) {
        require 'PHPMailer/PHPMailer/Exception.php';
        require 'PHPMailer/PHPMailer/PHPMailer.php';
        require 'PHPMailer/PHPMailer/SMTP.php';

        global $db;

        // Generar un identificador único y aleatorio
        $identifier = uniqid();

        // Guardar el identificador y el hash en la base de datos
        $sql_insert = "INSERT INTO hash_identificador (hash, identificador) VALUES ('$hash', '$identifier')";
        $db->query($sql_insert);

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
        $mail->Subject = 'Confirmación de cuenta biometrías'; // Asunto
        $mail->Body = utf8_encode('¡Haz clic en el siguiente enlace para confirmar tu registro: http://localhost/biometrias/confirmar_cuenta.php?identificador=' . $identifier);  // Cuerpo del correo

        // Enviar correo electrónico
        if ($mail->send()) {
            // No se redirige aquí, el redireccionamiento se manejará después de la confirmación
            return true;
        } else {
            return false;
        }
    }
}

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ejemplo de uso
    $usuario = new Usuario();
    $registro = $usuario->crear($_POST["nombres"], $_POST["apellidos"], $_POST["documento"], $_POST["email"], $_POST["password"]);

    if (is_array($registro)) {
        $correoConfirmacion = new CorreoConfirmacion();
        if ($correoConfirmacion->enviarCorreoConfirmacion($registro['email'], $registro['hash'])) {
            // Redirigir al usuario a la página de autenticación después de enviar el correo de confirmación
            echo "<div class='window-notice' id='window-notice'>";
            echo "<div class='content'>";
            echo "<div class='content-text'>¡Usuario registrado correctamente, confirme su registro en el correo electrónico!<br><a href='crear_usuario.php'>Iniciar sesión.</a></div>";
            echo "</div>";
            echo "</div>";
        } else {
            echo "<div class='window-notice' id='window-notice'>";
            echo "<div class='content'>";
            echo "<div class='content-text'>¡Error al enviar el correo electrónico de confirmación. Por favor,<br><a href='crear_usuario.php'>inténtalo nuevamente.</a></div>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<div class='window-notice' id='window-notice'>";
        echo "<div class='content'>";
        echo "<div class='content-text'>¡Hubo un error al crear el usuario. Por favor,<br><a href='crear_usuario.php'>inténtalo nuevamente.</a></div>";
        echo "</div>";
        echo "</div>";
    }
}
?>
</body>
</html>
