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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <!-- Datatables -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>  
  <!-- extension responsive -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="../front_end/formularios.css">
    <link rel="icon" type="image/png" href="../migracion_temp/images/favicon.png" />
    <link rel="stylesheet" href="botones.css">
    <link rel="stylesheet" href="../estilos_login\ventana_emergente.css">

    <style>
         table thead {
            background-color: #005dca;        
        }
        th{
            color:white;
            text-align:center;
        }
    </style>
</head>
<body>
    <?php include("../menu/menu.php"); ?>
<h1>Biometrias descargadas</h1>
<div class='container'>
    <div class='row'>
        <div class='col-lg-12'>
            <table id='example' class='table table-bordered display nowrap' cellspacing='0' width='100%'> 
                <thead>
                    <tr>
                    <th>HE</th>
                    <!-- <th>Nombre Responsable</th> -->
                    <th>Respuesta </th>
                    <th>Nombre Responsable</th>
                    <th>Fecha de descarga</th>
                    </tr>
    </thead>
    <tbody>
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
        ?>
       

            <?php
        foreach ($resultadosArray as $numero => $resultadoInfo) {
            $resultado = $resultadoInfo['resultado'];
            $mensajes = $resultadoInfo['mensajes'];
            ?>

            <tr>
                <td><?php echo $numero;?></td>
                <td><?php echo $mensajes;?></td>
                <td><?php echo $nombreResponsable;?></td>
                <td><?php echo $fechaActual;?></td>
            </tr>
           
        <?php
        }


        $mysqli->close();
        $atedesar->closeConnection();
    } catch (Exception $e) {
        echo '<p style="color:red;">Excepción capturada: ' . $e->getMessage() . '</p>';
    }
}

?>
 </tbody>
            </table>
        </div>
    </div>
</div>
<div class='button'>
    <p><a href='..\front_end\descarga_biometrias.php' id="atras_bio" class='btn btn-primary' role='button'>Volver atrás</a></p>
</div>

<?php include("../menu/footer.php"); ?>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
            
    <!-- Datatables-->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>  
      
    <!-- extension responsive -->
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    
    <script>
    $(document).ready(function() {
    $('#example').DataTable({
        responsive: true,
        "language": {
            "decimal":        "",
            "emptyTable":     "No hay datos disponibles en la tabla",
            "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
            "infoFiltered":   "(filtrado de _MAX_ registros totales)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Mostrar _MENU_ registros por página",
            "loadingRecords": "Cargando...",
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "zeroRecords":    "No se encontraron registros coincidentes",
            "paginate": {
                "first":      "Primero",
                "last":       "Último",
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
            "aria": {
                "sortAscending":  ": activar para ordenar la columna ascendente",
                "sortDescending": ": activar para ordenar la columna descendente"
            }
        }
    });
});
  
    </script>
</body>
</html>
