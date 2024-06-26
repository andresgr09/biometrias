<?php
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="migracion_temp\images\favicon.png" />
    <link rel="stylesheet" href="estilos_login\ventana_emergente.css">
    <title>Recuperar contraseña</title>
    <style>
        p {
            color: solid black;
        }
    </style>
</head>

<body>

    <?php
    // Clase para gestionar la recuperación de contraseña
    class RecuperacionContrasena
    {
        private $conn;

        public function __construct($servername, $username, $password, $database)
        {
            // Constructor: Establece la conexión a la base de datos
            $this->conn = new mysqli($servername, $username, $password, $database);

            // Verificar la conexión
            if ($this->conn->connect_error) {
                die("Conexión fallida: " . $this->conn->connect_error);
            }
        }

        public function recuperarContrasena($email)
        {
            // Consulta SQL para verificar si el correo existe en la base de datos
            $query = "SELECT * FROM usuarios WHERE correo_corp = '$email'";
            $result = $this->conn->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if ($row['estado_confirmacion'] == 1) {
                    // La cuenta está confirmada, continúa con la generación de la contraseña temporal y el envío por correo.

                    // Genera una contraseña temporal
                    $passwordTemporal = bin2hex(random_bytes(8));

                    // Hashea la contraseña temporal
                    $hashedPassword = password_hash($passwordTemporal, PASSWORD_DEFAULT);

                    // Actualiza la contraseña en la base de datos para el usuario
                    $updateQuery = "UPDATE usuarios SET password = '$hashedPassword' WHERE correo_corp = '$email'";
                    if ($this->conn->query($updateQuery) === TRUE) {
                        // Envía la contraseña temporal por correo usando PHPMailer
                require 'PHPMailer/PHPMailer/Exception.php';
                require 'PHPMailer/PHPMailer/PHPMailer.php';
                require 'PHPMailer/PHPMailer/SMTP.php';

                $mail = new PHPMailer\PHPMailer\PHPMailer();

                $mail->SMTPDebug = 0; // Enable verbose debug output
                $mail->isSMTP(); // Send using SMTP
                $mail->Host = 'relay.migracioncolombia.gov.co'; // Set the SMTP server to send through
                $mail->SMTPAuth = false; // Enable SMTP authentication
                $mail->Username = 'biometrias@migracioncolombia.gov.co';
                $mail->SMTPAutoTLS = false;
                $mail->Port = 25;

                $mail->setFrom('recuperar@migracioncolombia.gov.co');
                $mail->addAddress($email); // Correo del usuario

                $mail->Subject = 'Recuperacion de Contrasena';
                $mail->Body = "Tu nueva contrasenia temporal es:  $passwordTemporal   se recomienda actualizar la contrasenia una vez inicies sesion!";
                        if ($mail->send()) {
                            // Envío de correo exitoso, muestra un mensaje al usuario.
                            echo "<div class='window-notice' id='window-notice'>";
                            echo "<div class='content'>";
                            echo "<div class='content-text'>¡Se ha enviado una contraseña temporal a tu correo electrónico <br><a href='index.php'>Iniciar sesion</a></div>";
                            echo "</div>";
                        } else {
                            // Error en el envío de correo, muestra un mensaje de error.
                            echo "<div class='window-notice' id='window-notice'>";
                            echo "<div class='content'>";
                            echo "<div class='content-text'>¡Error al enviar el correo. Por favor, inténtalo más tarde. <br><a href='index'>Volver a intentar</a></div>";
                            echo "</div>";
                        }
                    } else {
                        return "Error al actualizar la contraseña en la base de datos: " . $this->conn->error;
                    }
                } else {
                    // La cuenta no está confirmada
                    echo "<div class='window-notice' id='window-notice'>";
                    echo "<div class='content'>";
                    echo "<div class='content-text'>¡La cuenta asociada a este correo electrónico aún no ha sido confirmada por correo! Por favor, revisa tu bandeja de entrada y confirma tu cuenta. <br><a href='index.php'>Volver a intentar</a></div>";
                    echo "</div>";
                }
            } else {
                // El correo electrónico no está registrado
                echo "<div class='window-notice' id='window-notice'>";
                echo "<div class='content'>";
                echo "<div class='content-text'>¡El correo electrónico no está registrado en nuestra base de datos! Por favor, verifica si has escrito correctamente tu correo o regístrate si aún no lo has hecho. <br><a href='index.php'>Volver a intentar</a></div>";
                echo "</div>";
            }
        }

        public function __destruct()
        {
            // Destructor: Cierra la conexión a la base de datos
            $this->conn->close();
        }
    }

    // Uso de la clase para recuperación de contraseña
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "biometrias";

        $email = $_POST['email']; // Obtener el correo electrónico del formulario

        $recuperacion = new RecuperacionContrasena($servername, $username, $password, $database);
        $recuperacion->recuperarContrasena($email);
    }
    ?>

</body>

</html>