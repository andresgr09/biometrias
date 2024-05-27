<?php
require_once("seguridad.php");
require_once("parametros_conexion_prueba.php");?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados Biometrías</title>
    <link rel="stylesheet" href="../front_end/formularios.css">
    <link rel="icon" type="image/png" href="../migracion_temp/images/favicon.png" />
    <link rel="stylesheet" href="botones.css">
    <style>
        .resultados {
            text-align: center;
            margin-top: 20px;
        }
        table{
            border:2px;
        }
    </style>
</head>
<body>
    <?php include("../menu/menu.php"); ?>
    

<?php

// Desactivar la visualización de advertencias
error_reporting(E_ALL & ~E_WARNING);

// Clase para la conexión y operaciones en Oracle
class atedesar {
    private $conn;

    public function __construct($userprueba, $passwordprueba, $hostprueba) {
        $this->conn = oci_connect($userprueba, $passwordprueba, $hostprueba);
        if (!$this->conn) {
            $e = oci_error();
            throw new Exception("Error de conexión : " . $e['message']);
        }
    }

    public function executePLSQL($plsql, $numeros) {
        $stid = oci_parse($this->conn, $plsql);
        oci_bind_by_name($stid, ":numeros", $numeros);
        if (!oci_execute($stid)) {
            $e = oci_error($stid);
            throw new Exception("Error al ejecutar el PL/SQL: " . $e['message']);
        }

        $messages = $this->getDbmsOutput();
        oci_free_statement($stid);

        return $messages;
    }

    private function getDbmsOutput() {
        oci_execute(oci_parse($this->conn, 'BEGIN DBMS_OUTPUT.ENABLE(NULL); END;'));

        $output = [];
        $stid = oci_parse($this->conn, 'BEGIN DBMS_OUTPUT.GET_LINE(:line, :status); END;');
        oci_bind_by_name($stid, ':line', $line, 32767);
        oci_bind_by_name($stid, ':status', $status);

        while (true) {
            oci_execute($stid);
            if ($status != 0) {
                break;
            }
            $output[] = $line;
        }

        return $output;
    }

    public function closeConnection() {
        oci_close($this->conn);
    }
}

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
        
                // Subconsulta para obtener el nombre y apellido del usuario según el número de documento
                if (isset($_SESSION["documento"])) {
                    $documento = $_SESSION["documento"];
                    $sql2 = "SELECT nombres, apellidos FROM usuarios WHERE nro_doucmento = '$documento'";
                    $result2 = $mysqli->query($sql2);
                    if ($result2 && $result2->num_rows > 0) {
                        $row2 = $result2->fetch_assoc();
                        $nombres = $row2['nombres'];
                        $apellidos = $row2['apellidos'];
                    } else {
                        $nombres = "No encontrado";
                        $apellidos = "No encontrado";
                    }
                } else {
                    // Manejar el caso en que $_SESSION["documento"] no está definida
                    $nombres = "No definido";
                    $apellidos = "No definido";
                }
        
                // Insertar el resultado en la base de datos MySQL
                $sql = "INSERT INTO he_descargados (he_descargado, tipo_mensaje, nombre_responsable)  VALUES ('$numero', '$resultado', '$nombres' )";
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
        echo "<tr><th style='border: 1px solid black'>HE</th><th style='border: 1px solid black'>Resultado</th><th style='border: 1px solid black'>Respuesta</th><th style='border: 1px solid black'>nombre responsable</th></tr>";

        foreach ($resultadosArray as $numero => $resultadoInfo) {
            $resultado = $resultadoInfo['resultado'];
            $mensajes = $resultadoInfo['mensajes'];
            echo "<tr><td style='border: 1px solid black'>$numero</td><td style='border: 1px solid black'>$resultado</td><td style='border: 1px solid black'>$mensajes</td><td style='border: 1px solid black'>$nombres </td></tr>";
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
    <p><a href='..\front_end\mis_funciones.php' id="atras_bio" class='btn btn-primary' role='button'>Volver atrás</a></p>
  </div>

  <?php include("../menu/footer.php"); ?>
</body>
</html>
