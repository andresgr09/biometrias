<?php

function validarHE($numeros) {
    // Eliminar espacios en blanco al inicio y al final
    $numeros = trim($numeros);
    // Validar el patrón de HE (números separados por comas, sin espacios)
    $patron = '/^([0-9]+(,[0-9]+)*){1,50}$/';
    return preg_match($patron, $numeros);
}
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
    // Definir los patrones de expresión regular
    $patronMinusculas = "/[a-z]/";
    $patronMayusculas = "/[A-Z]/";
    $patronNumeros = "/[0-9]/";
    $patronCaracteresEspeciales = "/[!@#$%^&*()\\-_+=}{;:,<.>]/"; // Escapar los caracteres especiales

    // Utilizar la función preg_match() para verificar si la contraseña coincide con los patrones
    // y asignar el resultado a una variable
    $cumpleMinusculas = preg_match($patronMinusculas, $password);
    $cumpleMayusculas = preg_match($patronMayusculas, $password);
    $cumpleNumeros = preg_match($patronNumeros, $password);
    $cumpleCaracteresEspeciales = preg_match($patronCaracteresEspeciales, $password);

    // Retornar true solo si todos los patrones son satisfechos
    return $cumpleMinusculas && $cumpleMayusculas && $cumpleNumeros && $cumpleCaracteresEspeciales;
}
?>





