<?php require_once("seguridad.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Biometrias</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <!-- Datatables -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>  
  <!-- extension responsive -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">

  <link rel="stylesheet" href="../front_end/formularios.css">
  <link rel="icon" type="image/png" href="../migracion_temp/images/favicon.png" />
  <link rel="stylesheet" href="botones.css">
  
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

  <h1 style="text-align: center;">Reporte Biometrias </h1>

  <div class='container'>
    <div class='row'>
        <div class='col-lg-12'>
            <table id='example' class='table table-bordered display nowrap' cellspacing='0' width='100%'> 
                <thead>
                    <tr>
                    <th>Id_auditoria</th>
                    <th>Nombre Responsable</th>
                    <th>Nro paquetes <br> descargados</th>
                    <th>Observaciones</th>
    </tr>
    </thead>
    <?php
      include("conexion.php");
      $sql = "SELECT * FROM auditorias";
      if(!$result = $db->query($sql)){
          die('Hay un error corriendo en la consulta o datos no encontrados!!! [' . $db->error . ']');
      }

      while ($row = $result->fetch_assoc()) {
          $iid_auditoria = stripslashes($row["id_auditoria"]);
          $nnombre_resp = stripslashes($row["nombre_responsable"]);
          $nnro_paquetes = stripslashes($row["nro_paquetes_descargados"]);
          $oobservaciones = stripslashes($row["observaciones"]);
          ?>
          <tr>
          <td ><?php echo $iid_auditoria;?></td>
          <td><?php echo $nnombre_resp;?></td>
          <td><?php echo $nnro_paquetes;?></td>
          <td><?php echo $oobservaciones;?></td>
          </tr>
          <?php
                    }
          
                    ?>
  </tbody>
            </table>
        </div>
    </div>
</div>

  <div class='button'>
    <p><a href='..\front_end\mis_funciones.php' id="atras_bio" class='btn btn-primary' role='button'>Volver atras</a></p>
  </div>

  <?php include("../menu/footer.php"); ?>
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
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
