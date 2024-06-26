<?php
require_once("seguridad.php");
require_once("parametros_conexion_prueba.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados Biometrías</title>
    <link rel="stylesheet" href="../front_end/formularios.css">
    <link rel="icon" type="image/png" href="../migracion_temp/images/favicon.png" />
    <link rel="stylesheet" href="botones.css">
    <link rel="stylesheet" href="../estilos_login\ventana_emergente.css">

    <style>
        .resultados {
            text-align: center;
            margin-top: 20px;
        }
        table {
            border: 2px;
        }
    </style>
</head>
<body>
    <?php include("../menu/menu.php"); ?>
<h1>Biometrias descargadas</h1>
<?php
define('BASE_PATH', 'C:\xampp\htdocs\biometrias');
include(BASE_PATH . '/validaciones.php');

// Desactivar la visualización de advertencias
error_reporting(E_ALL & ~E_WARNING);

// Clase para la conexión y operaciones en Oracle


$numeros = $_POST['he'];

        // Validar el campo de apellidos
        if (!validarHE($numeros)) {
            echo "   <div class='window-notice' id='window-notice'>";
            echo "    <div class='content'>";
            echo" <div class='content-text'>No se admiten espacios ni caracteres especiales en el formulario<br><a href='descarga_biometrias.php'> inténtalo nuevamente.!</a>";
             echo "       </div>";
             echo "   </div>";
             exit ;
            
        }
           include("creando_conexion_atedesar.php");

// Procesar los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numeros = $_POST['he'];

    // Validar y limitar el número de entradas
    $numerosArray = array_map('trim', explode(',', $numeros));
    if (count($numerosArray) > 50) {
        die('Error: Puede ingresar hasta 50 números solamente.');
    }

    try {
        // Conexión y operación en la base de datos Oracle
        $atedesar = new atedesar($userprueba, $passwordprueba, $hostprueba);

        // Aquí va tu código para la conexión a la base de datos MySQL
        $mysqli = new mysqli("localhost", "root", "", "biometrias");

        // Verificar la conexión
        if ($mysqli->connect_error) {
            die("Error en la conexión MySQL: " . $mysqli->connect_error);
        }

        // Obtener la fecha actual
        $fechaActual = date("Y-m-d H:i:s");

        // Obtener el nombre del responsable desde la tabla usuarios usando el documento de la sesión
        $documento = $_SESSION['documento'];
        $sqlNombreResponsable = "SELECT nombres, apellidos FROM usuarios WHERE nro_documento = '$documento'";
        $resultNombreResponsable = $mysqli->query($sqlNombreResponsable);

        if ($resultNombreResponsable && $resultNombreResponsable->num_rows > 0) {
            $rowNombreResponsable = $resultNombreResponsable->fetch_assoc();
            $nombreResponsable = $rowNombreResponsable['nombres'] . ' ' . $rowNombreResponsable['apellidos'];
        } else {
            $nombreResponsable = "No definido";
        }

        // Insertar resultados en he_descargados y consultar otra tabla
        $resultadosArray = [];
        foreach ($numerosArray as $numero) {
            // Ejecutar PL/SQL para cada número
            try {
                $plsql = "
                    BEGIN
                        DBMS_OUTPUT.ENABLE(NULL);
                        migracion.PR_EXP_IMAGEN_OFICINA(:numeros);
                    END;
                ";
                    //    $plsql = " 
                                            
                    //     BEGIN
                    //     migracion.PR_EXP_IMAGEN_OFICINA(:numeros);
                    //     END;
                    //    ";
                       

                $mensajes = $atedesar->executePLSQL($plsql, $numero);
        
                // Procesar el resultado para determinar si es 1 o 0
                $resultado = 0;
                foreach ($mensajes as $mensaje) {
                    if (strpos($mensaje, '1') !== false) {
                        $resultado = 1;
                        break;
                    }
                    if (strpos($mensaje, '3') !== false) {
                        $resultado = 1;
                        break;
                    }
                }
    
        
                // Subconsulta a otra tabla en MySQL para obtener información adicional
                $mensajes = "Sin información";
                $sql = "SELECT mensajes FROM respuesta_descargas WHERE numero_tipo = '$resultado'";
                $result = $mysqli->query($sql);
        
                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $mensajes = $row['mensajes'];
                } else {
                    if ($resultado == 0) {
                        $mensajes = "No se encontró la imagen.";
                    }
                }
        
                // Insertar el resultado en la base de datos MySQL incluyendo la fecha y el responsable
                $sql = "INSERT INTO he_descargados (he_descargado, tipo_mensaje, nombre_responsable, fecha) VALUES ('$numero', '$resultado', '$nombreResponsable', '$fechaActual')";
                if ($mysqli->query($sql) !== TRUE) {
                    echo "Error al insertar en MySQL: " . $mysqli->error;
                }
        
                // Guardar resultado en el array para mostrar después
                $resultadosArray[$numero] = [
                    'resultado' => $resultado,
                    'mensajes' => $mensajes
                ];
        
            } catch (Exception $e) {
                echo '<p style="color:red;">Error al ejecutar el PL/SQL: ' . $e->getMessage() . '</p>';
            }
        }
        

        // Mostrar los resultados de he_descargados junto con la información adicional de la subconsulta
        echo "<div class='wrapper fadeInDown'><div id='formContent'><table style='border-collapse: collapse; width: auto; margin: 0 auto;'>";
        echo "<tr><th style='border: 1px solid black'>HE</th><th style='border: 1px solid black'>Respuesta</th><th style='border: 1px solid black'>Nombre Responsable</th><th style='border: 1px solid black'>Fecha de descarga</th></tr>";

        foreach ($resultadosArray as $numero => $resultadoInfo) {
            $resultado = $resultadoInfo['resultado'];
            $mensajes = $resultadoInfo['mensajes'];
            echo "<tr><td style='border: 1px solid black'>$numero</td><td style='border: 1px solid black'>$mensajes</td><td style='border: 1px solid black'>$nombreResponsable</td><td style='border: 1px solid black'>$fechaActual</td></tr>";
        }

        echo "</table></div></div>";

        $mysqli->close();
        $atedesar->closeConnection();
    } catch (Exception $e) {
        echo '<p style="color:red;">Excepción capturada: ' . $e->getMessage() . '</p>';
    }
}
?>
<div class='button'>
    <p><a href='..\front_end\descarga_biometrias.php' id="atras_bio" class='btn btn-primary' role='button'>Volver atrás</a></p>
</div>

<?php include("../menu/footer.php"); ?>
</body>
</html>
