
<?php
function validarNombres($nombres) {
    // Expresión regular para permitir solo letras, espacios y acentos en los nombres
    $patron = "/^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ\s]+$/";

    // Comprobamos si el nombre coincide con el patrón
    if (preg_match($patron, $nombres)) {
        return true; // El nombre es válido
    } else {
        return false; // El nombre contiene caracteres no permitidos
    }
}
function validarApellidos($apellidos) {
    // Expresión regular para permitir solo letras, espacios y acentos en los nombres
    $patron = "/^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ\s]+$/";

    // Comprobamos si el nombre coincide con el patrón
    if (preg_match($patron, $apellidos)) {
        return true; // El nombre es válido
    } else {
        return false; // El nombre contiene caracteres no permitidos
    }
}
function validarEmail($email) {
    // Expresión regular para validar correos electrónicos con el dominio "@migracioncolombia.gov.co"
    $patron = "/^[a-zA-Z0-9._%+-]+@migracioncolombia\.gov\.co$/";
    
    // Comprobamos si el correo electrónico coincide con el patrón
    if (preg_match($patron, $email)) {
        return true; // El correo electrónico es válido
    } else {
        // El correo electrónico es inválido, mostrar mensaje de error con el dominio correcto
        echo "<script>alert('El correo electrónico debe tener el dominio @migracioncolombia.gov.co'); window.location.href = 'crear_usuario.php';</script>";
        exit; // Detener la ejecución del script
    }
}

function validarDocumento($documento) {
    // Expresión regular para permitir solo números
    $patron = "/^[0-9]+$/";

    // Comprobamos si el documento coincide con el patrón
    if (preg_match($patron, $documento)) {
        return true; // El documento es válido
    } else {
        return false; // El documento contiene caracteres no permitidos
    }
}


?>