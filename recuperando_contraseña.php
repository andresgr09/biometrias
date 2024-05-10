

<?php
    header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="ventana_emergente.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="migracion_temp\images\favicon.png" />
    <link rel="stylesheet" href="ventana_emergente.css">
    <title>Recuperar contraseña</title>
   <style>
    p{
        color:solid black;
    }
   </style>
</head>
<body>
    


<?php
// Clase para gestionar la recuperación de contraseña
class RecuperacionContrasena {
    private $conn;

    public function __construct($servername, $username, $password, $database) {
        // Constructor: Establece la conexión a la base de datos
        $this->conn = new mysqli($servername, $username, $password, $database);

        // Verificar la conexión
        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    public function recuperarContrasena($email) {
        // Consulta SQL para verificar si el correo existe en la base de datos
        $query = "SELECT * FROM usuarios WHERE correo_corp = '$email'";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            // El correo existe en la base de datos, continúa con la generación de la contraseña temporal y el envío por correo.

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
               
                    echo'<script>alert("Se ha enviado una contraseña temporal a tu correo electrónico"); window.location = "index.php";</script>';
                } 
                else {
                    // Error en el envío de correo, muestra un mensaje de error.
                    echo'<script>alert("Error al enviar el correo. Por favor, inténtalo más tarde."); window.location = "index.php";</script>';
                    
                }
            } 
            else {
                return "Error al actualizar la contraseña en la base de datos: " . $this->conn->error;
            }
        } else {
            // El correo no existe en la base de datos, muestra un mensaje de error.
                    echo "   <div class='window-notice' id='window-notice'>";
            echo "    <div class='content'>";
            echo "<div class='content-text'>¡El correo electrónico no está registrado<a href='recuperar_contraseña.php'> inténtalo nuevamente.! </a>";
            echo "       </div>";
            echo "   </div>";
                }
    }

    public function __destruct() {
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
    $mensaje = $recuperacion->recuperarContrasena($email);

    echo $mensaje;
}
?>

   
</body>
</html>
    