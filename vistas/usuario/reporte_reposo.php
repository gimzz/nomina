<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i|Roboto+Mono:300,400,700|Roboto+Slab:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
    <link rel="stylesheet" href="../../assets/css/estilos.css">
   
</head>
    <body>
        <div id="demo-content">
          <div id="loader-wrapper">
            <div id="loader"></div>
            <div class="loader-section section-left"></div>
                <div class="loader-section section-right"></div>
            </div>
          <div id="content"> </div>
        </div>

<?php require_once "menu.php";?>



        <div class="container">
          <div class="row">
            <div class="col-md-12 text-center" style="padding:100px 0px;">
              <h3 class="text-center" style="font-size:40px; color:#333; font-weight:900;">
               Reporte de Reposos
              </h3>
              <img src="../../assets/img/gpg.png" style="max-width: 300px; max-height: 400px;" alt="Reporte" class="img-fluid portada">
            </div>
          </div>
        </div>

      <section>
          <div class="container">
            <div class="row">
              <div class="col-md-12 text-center">
                <form action="reporte5.php" method="post" accept-charset="utf-8">
                  <div class="row">
  <div class="col">
    <label>Fecha Inicial</label>
    <input type="Date" name="fecha_ini" class="form-control">
  </div>
  <div class="col">
    <label>Fecha Final</label>
    <input type="Date" name="fecha_fini" class="form-control">
  </div>
</div>
<br>
                    <div class="col">
                      <span class="btn btn-dark mb-2" id="filtro">Filtrar</span>
                      <button type="submit" class="btn btn-danger mb-2" id="btn-reporte" disabled>Reporte</button>
                    </div>
                  </div>
                </form>
              </div>

              <div class="col-md-12 text-center mt-5">     
                <span id="loaderFiltro">  </span>
              </div>
              
              
            <div class="table-responsive resultadoFiltro">
              <table class="table table-hover" id="tableEmpleados">
                <thead>
                  <tr>
                  <th scope="col">Nº</th>
                    <th scope="col">Cedula</th>
                    <th scope="col">Nombre y Apellido</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Cargo</th>
                 
                    
                  </tr>
                </thead>
              <?php
              require_once ('../../basededatos/base.php');
                $conn = new conexion();
                $con = $conn->conectar();
              $sqlTrabajadores = "SELECT a.*, c.*, d.*, DATE_FORMAT(b.fecha_inicio, '%d-%m-%Y') AS fecha, b.* FROM empleado AS a 
              INNER JOIN reposo_empleado AS b ON a.cedula = b.cedula_reposo INNER JOIN cargos AS c ON c.id_cargos = a.id_cargos 
              INNER JOIN departamentos AS d ON c.id_departamento=d.id_departament";
            $query = mysqli_query($con, $sqlTrabajadores);
              $i =1;
                while ($dataRow = mysqli_fetch_array($query)) { ?>
                <tbody>
                  <tr>
                    <td><?php echo $i++ ; ?></td>
                    <td><?php echo $dataRow['cedula_empleado'];?></td>
                    <td><?php echo $dataRow['nombre']." ".$dataRow['apellido']; ?></td>
                    <td><?php echo $dataRow['fecha']; ?></td>
                    <td><?php echo $dataRow['nom_departamento']; ?></td>

                        
                </tr>
                </tbody>
              <?php } ?>
              </table>
            </div>

            </div>
          </div>
      </section>


  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="../../assets/js/material.min.js"></script>




<script>
$(function() {
    // Función para habilitar o deshabilitar el botón de reporte según el estado del filtro
    function toggleReportButton() {
        var fechaIni = $('input[name=fecha_ini]').val();
        var fechaFini = $('input[name=fecha_fini]').val();

        // Habilitar el botón de reporte solo si se han ingresado fechas válidas en el filtro
        if (fechaIni !== "" && fechaFini !== "") {
            $("#btn-reporte").prop("disabled", false);
        } else {
            $("#btn-reporte").prop("disabled", true);
        }
    }

    // Llama a la función toggleReportButton al cargar la página
    toggleReportButton();

    // Llama a la función toggleReportButton cada vez que cambia el valor de los campos de fecha
    $('input[name=fecha_ini], input[name=fecha_fini]').on("change", function() {
        toggleReportButton();
    });

    // Resto del código existente...

    $("#filtro").on("click", function(e) {
        e.preventDefault();
        loaderF(true);

        var fecha_ini = $('input[name=fecha_ini]').val();
        var fecha_fini = $('input[name=fecha_fini]').val();

        if (fecha_ini !== "" && fecha_fini !== "") {
            $.post("filtro5.php", {fecha_ini: fecha_ini, fecha_fini: fecha_fini}, function(data) {
                $("#tableEmpleados").hide();
                $(".resultadoFiltro").html(data);
                loaderF(false);
            });
        } else {
            $("#loaderFiltro").html('<p style="color:red; font-weight:bold;">Debe colocar alguna fecha</p>');
        }
    });

    function loaderF(statusLoader) {
        if (statusLoader) {
            $("#loaderFiltro").show();
            $("#loaderFiltro").html('<img class="img-fluid" src="../../assets/img/cargando.svg" style="left:50%; right: 50%; width:50px;">');
        } else {
            $("#loaderFiltro").hide();
        }
    }
});
</script>

</body>