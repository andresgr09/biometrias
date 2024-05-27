<?php
require_once("seguridad.php");
require_once("parametros_conexion_prueba.php");

// Desactivar la visualización de advertencias
error_reporting(E_ALL & ~E_WARNING);

// Clase para la conexión y operaciones en Oracle
class atedesar {
    private $conn;

    public function __construct($userprueba, $passwordprueba, $hostprueba) {
        $this->conn = oci_connect($userprueba, $passwordprueba, $hostprueba);
        if (!$this->conn) {
            $e = oci_error();
            throw new Exception("Error de conexión o base de datos caída Movil 01 Dorado: " . $e['message']);
        }
    }

    public function executeQuery($sql_atedesar) {
        $stid = oci_parse($this->conn, $sql_atedesar);
        if (!oci_execute($stid)) {
            $e = oci_error($stid);
            if ($e['code'] != 942) { // Evita imprimir el mensaje de error si es ORA-00942 (tabla o vista no existe)
                throw new Exception("Error al ejecutar la consulta SQL: " . $e['message']);
            }
        }

        $results = [];
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $results[] = $row;
        }

        oci_free_statement($stid);
        return $results;
    }

    public function executePLSQL($plsql, $numeros) {
        $stid = oci_parse($this->conn, $plsql);
        oci_bind_by_name($stid, ":numeros", $numeros);
        if (!oci_execute($stid)) {
            $e = oci_error($stid);
            if ($e['code'] != 942) { // Evita imprimir el mensaje de error si es ORA-00942 (tabla o vista no existe)
                throw new Exception("Error al ejecutar el PL/SQL: " . $e['message']);
            }
        }

        $messages = $this->getDbmsOutput();
        oci_free_statement($stid);

        return $messages;
    }

    private function getDbmsOutput() {
        $output = '';
        $stid = oci_parse($this->conn, 'BEGIN DBMS_OUTPUT.GET_LINE(:line, :status); END;');
        oci_bind_by_name($stid, ':line', $line, 32767);
        oci_bind_by_name($stid, ':status', $status);

        while (true) {
            oci_execute($stid);
            if ($status != 0) {
                break;
            }
            $output .= htmlspecialchars($line) . "<br/>";
        }

        return $output;
    }

    public function closeConnection() {
        oci_close($this->conn);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numeros = $_POST['he'];

    // Validar y limitar el número de entradas
    $numerosArray = array_map('trim', explode(',', $numeros));
    if (count($numerosArray) > 50) {
        die('Error: Puede ingresar hasta 50 números solamente.');
    }

    // Unir los números para usarlos en PL/SQL
    $numerosEscapados = implode(',', $numerosArray);

    try {
        // Conexión y operación en la base de datos Oracle
        $atedesar = new atedesar($userprueba, $passwordprueba, $hostprueba);

        // Ejemplo de ejecución de PL/SQL con DBMS_OUTPUT
        try {
            $plsql = "
                BEGIN
                    DBMS_OUTPUT.ENABLE(NULL);
                    migracion.PR_EXP_IMAGEN_OFICINA(:numeros);
                END;
            ";
            $mensajes = $atedesar->executePLSQL($plsql, $numerosEscapados);
        } catch (Exception $e) {
            echo '<p style="color:red;">Error al ejecutar el PL/SQL: ' . $e->getMessage() . '</p>';
        }

        // // Aquí va tu código para la conexión a la base de datos MySQL
        // $mysqli = new mysqli("localhost", "root", "", "biometrias");

        // // Verificar la conexión
        // if ($mysqli->connect_error) {
        //     die("Error en la conexión MySQL: " . $mysqli->connect_error);
        // }

        // // Insertar los mensajes en la base de datos MySQL
        // foreach ($mensajes as $mensaje) {
        //     $sql = "INSERT INTO he_descargados (id_he, he_descargado, tipo_mensaje, nombre_responsable, nro_paquete, fecha) VALUES (NULL,'$mensaje','1','andres','4234','45/45/2425')";
        //     if ($mysqli->query($sql) !== TRUE) {
        //         echo "Error al insertar en MySQL: " . $mysqli->error;
        //     }
        // }

        // $mysqli->close();
        // $atedesar->closeConnection();
    } catch (Exception $e) {
        echo '<p style="color:red;">Excepción capturada: ' . $e->getMessage() . '</p>';
    }
}
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

    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Aquí se mostrarán los resultados de la consulta -->
            <?php
            if (isset($mensajes)) {
                echo "<table style='border-collapse: collapse; width: auto; margin: 0 auto;'>";
                echo "<tr>" ;
                 echo "<th style='border :1px solid black'> he </th>";
                 echo "</tr>";
                  echo "<td>";
                 
                echo " <td style='border :1px solid black'> $mensajes </td>";
      
                echo "</table>";
            }
            ?>
        </div>
    </div>

    <div class='button'>
        <p><a href='descarga_biometrias.php' id="atras_bio" class='btn btn-primary' role='button'>Volver atrás</a></p>
    </div>

    <?php include("../menu/footer.php"); ?>
</body>
</html>
