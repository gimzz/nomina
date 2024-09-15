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
               Reporte de Edad de los Empleados
              </h3>
              <img src="../../assets/img/gpg.png" style="max-width: 300px; max-height: 400px;" alt="Reporte" class="img-fluid portada">
            </div>
          </div>
        </div>

      <section>
          <div class="container">
            <div class="row">
              <div class="col-md-12 text-center">
                <form action="reporte3.php" method="post" accept-charset="utf-8">
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
                      <button type="submit" class="btn btn-danger mb-2">Reporte</button>
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
                    <th scope="col">Fecha de nacimiento</th>
                    <th scope="col">Edad</th>
                    <th scope="col">Cargo</th>
                    
                 
                    
                  </tr>
                </thead>
              <?php
              require_once ('../../basededatos/base.php');
                $conn = new conexion();
                $con = $conn->conectar();
              $sqlTrabajadores = "SELECT a.*, b.*, c.*, DATE_FORMAT(a.fecha_nacimiento, '%d-%m-%Y') AS fecha FROM empleado AS a 
               INNER JOIN cargos AS b ON a.id_cargos=b.id_cargos INNER JOIN departamentos AS c ON c.id_departament = b.id_departamento";
            $query = mysqli_query($con, $sqlTrabajadores);
              $i =1;
                while ($dataRow = mysqli_fetch_array($query)) { 
                    
                    $fecha_nacimiento = new DateTime($dataRow['fecha_nacimiento']);
                    $fecha_actual = new DateTime();
                    $diferencia = $fecha_actual->diff($fecha_nacimiento);
                    $edad = $diferencia->y;
                    ?>
                <tbody>
                  <tr>
                    <td><?php echo $i++ ; ?></td>
                    <td><?php echo $dataRow['cedula'];?></td>
                    <td><?php echo $dataRow['nombre']." ".$dataRow['apellido']; ?></td>
                    <td><?php echo $dataRow['fecha']; ?></td>
                    <td><?php echo $edad; ?></td>
                    <td><?php echo $dataRow['nombre_departament']; ?></td>
                    

                        
                </tr>
                </tbody>
              <?php } ?>
              </table>
            </div>

            </div>
          </div>
      </section>


  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="assets/js/material.min.js"></script>
  <script>
  $(function() {
      setTimeout(function(){
        $('body').addClass('loaded');
      }, 1000);


      $("#filtro").on("click", function(e){ 
  e.preventDefault(); // Previene el comportamiento predeterminado del evento de clic, como seguir un enlace o enviar un formulario
  
  loaderF(true); // Llama a la función loaderF con el argumento true para mostrar un indicador de carga

  var fecha_ini = $('input[name=fecha_ini]').val(); // Obtiene el valor del campo de entrada con el nombre "fecha_ini"
  var fecha_fini = $('input[name=fecha_fini]').val(); // Obtiene el valor del campo de entrada con el nombre "fecha_fini"
  console.log(fecha_ini); // Imprime el valor de la variable fecha_ini en la consola
  console.log(fecha_fini); // Imprime el valor de la variable fecha_fini en la consola

  if(fecha_ini != "" && fecha_fini != ""){
    $.post("filtro3.php", {fecha_ini: fecha_ini, fecha_fini: fecha_fini}, function (data) {
      $("#tableEmpleados").hide();
      $(".resultadoFiltro").html(data);
      loaderF(false);
    });  
  }else{
    $("#loaderFiltro").html('<p style="color:red;  font-weight:bold;">Debe colocar alguna fecha</p>');
  }
});



function loaderF(statusLoader){
    console.log(statusLoader);
    if(statusLoader){
      $("#loaderFiltro").show();
      $("#loaderFiltro").html('<img class="img-fluid" src="../../assets/img/cargando.svg" style="left:50%; right: 50%; width:50px;">');
    }else{
      $("#loaderFiltro").hide();
    }
  }
});
</script>

</body>