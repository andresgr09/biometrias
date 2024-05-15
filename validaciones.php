<?php

function validarNombres($nombres) {
    // Expresión regular para permitir solo letras, espacios y acentos en los nombres
    $patron = "/^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ\s]+$/";
    // Comprobamos si el nombre coincide con el patrón
    return preg_match($patron, $nombres);
}


function validarApellidos($apellidos) {
    // Expresión regular para permitir solo letras, espacios y acentos en los apellidos
    $patron = "/^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ\s]+$/";
    // Comprobamos si los apellidos coinciden con el patrón
    return preg_match($patron, $apellidos);
}

function validarEmail($email) {
    // Expresión regular para validar correos electrónicos con el dominio "@migracioncolombia.gov.co"
    $patron = "/^[a-zA-Z0-9._%+-]+@migracioncolombia\.gov\.co$/";
    // Comprobamos si el correo electrónico coincide con el patrón
    return preg_match($patron, $email);
}

function validarDocumento($documento) {
    // Expresión regular para permitir solo números
    $patron = "/^[0-9]+$/";
// Comprobamos si el documento coincide con el patrón
    return preg_match($patron, $documento);
}
function validarContraseña($password) {
    // Definir el patrón de expresión regular
    $patron = "/[a-z]/";
    $patron .= "/[A-Z]/";
    $patron .= "/[0-9]/";
    $patron .= "/[!@#$%^&*()\\-_+=}{;:,<.>]/"; // Escapar los caracteres especiales

    // Utilizar la función preg_match() para verificar si la contraseña coincide con el patrón
    return preg_match($patron, $password);
}

?>





