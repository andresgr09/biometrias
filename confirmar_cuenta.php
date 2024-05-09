<?php
include("conexion.php");

// Verificar si se proporciona un hash en la URL
// if(isset($_GET['hash'])) {
//     $hash = $_GET['hash'];

if(isset($_POST['hash'])) {
    $hash = $_POST['hash'];
    // Buscar el hash en la base de datos
    $sql = "SELECT * FROM usuarios WHERE hash = '$hash'";
    $result = $db->query($sql);

    if($result->num_rows > 0) {
        // Actualizar el estado de confirmación del usuario a confirmado
        $sql_update = "UPDATE usuarios SET estado_confirmacion = 1 WHERE hash = '$hash'";
        if($db->query($sql_update)) {
            echo "Tu cuenta ha sido confirmada correctamente. Ahora puedes iniciar sesión.";
        } else {
            echo "Error al confirmar tu cuenta. Por favor, inténtalo de nuevo más tarde.";
        }
    } else {
        echo "El enlace de confirmación es inválido o ha expirado.";
    }
} else {
    echo "El enlace de confirmación es inválido o ha expirado.";
}
?>
