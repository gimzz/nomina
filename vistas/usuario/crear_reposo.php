<?php
  // Include database file
  require_once "../../basededatos/base.php";
  require_once "../../basededatos/reposos/reposos.php";
?>

<!-- Include Sweet Alert script -->
<script src="../../assets/js/sweetalert2@11.js"></script>

<?php
  $usuariosObj = new reposo();
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
      extract($_POST);
      if (!empty($roles) && !empty($fecha_inicio) && !empty($fecha_final)) {
        if (!preg_match("/^[0-9]+$/", $roles)) {
          // Display warning alert using Sweet Alert
          echo "
          
            <script>
            document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
            icon: 'warning',
            title: '¡Alerta!',
            text: 'Debes seleccionar un empleado.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Aceptar'
          });
        });</script>";
        } else {
          $result = $usuariosObj->agregar();  
          if ($result === false) {
            // Display warning alert for existing user
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'warning',
              title: '¡Alerta!',
              text: 'El usuario ya posee un Reposo Registrado en esta Fecha.',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Aceptar'
            });
          }); </script>";
          } else if ($result === true) {
            // Display success alert for successful submission
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'success',
              title: '¡Exito!',
              text: 'El Reposo fue Guardado Exitosamente .',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Aceptar'
            });
          });</script>";
          }
        }
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Registrar Empleado</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel="stylesheet" href="../../assets/css/estilos.css">
  
</head>
<body>

<?php
require_once "menu.php";
?>

<div class="card text-center" style="padding:15px;">
  <h4>Registrar Reposo de Empleados</h4>
</div><br> 
<div class="container">
  <form action="crear_reposo.php" onsubmit="return funcion();"  method="POST">

  <center><label for="usuario">Selecciona un Empleado:</label></center>
  <select class="form-control" id="selector"  name="roles" >
        <option selected >Seleccione una Opción</option>
        <?php
        echo
          $query = $usuariosObj->personas();
          foreach ($query as $fila) 
                         {
                            echo "<option value='".$fila['cedula']."'$cond>" . $fila['nombre']." ".$fila['apellido']."</option>";
                         }
        ?>
        </select>
        <br>
      <center><label for="nombre">Fecha de Inicio:</label></center> 
      <input class="form-control" type="date" value="<?php echo date('Y-m-d')?>" id="fecha_inicio" name="fecha_inicio" required><br>

      <center><label for="clave">Fecha Final </label></center>
      <input class="form-control"   type="date" value="<?php echo date('Y-m-d')?>" name="fecha_final" id="fecha_final" required><br>
     
    <div class="form-group">
      <br>
      <center><input type="submit" name="update" class="btn btn-primary" style="float:right;" value="Registrar"></center>
    </div>
  </form>

</div>
<script>
    function lettersOnly(input) { 
      var regex = /[^a-zA-ZÀ-ÿ]/gi;
    input.value = input.value.replace(regex, "");
} 

function soloNumeros(input) {
  var regex = /[^0-9]/gi;
  input.value = input.value.replace(regex, "");
}

function letrasNumerosEspacios(input) {
  var regex = /[^a-zA-Z0-9\s]/gi;
  input.value = input.value.replace(regex, "");
}

function letras(input) {
  var regex = /[^a-zA-Z]/gi;
  input.value = input.value.replace(regex, "");
}

</script>

  <script src="../../assets/js/sweetalert2@11.js"></script>

<script>
document.getElementById("fecha_inicio").addEventListener("change", function() {
    validarFechas();
});

document.getElementById("fecha_final").addEventListener("change", function() {
    validarFechas();
});

function validarFechas() {
    var fechaInicio = new Date(document.getElementById("fecha_inicio").value);
    var fechaFinal = new Date(document.getElementById("fecha_final").value);

    if (fechaFinal < fechaInicio) {
      Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'La fecha final no puede ser anterior a la fecha de inicio',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar'
            });
        // Restaurar la fecha final a la fecha de inicio
        document.getElementById("fecha_final").value = document.getElementById("fecha_inicio").value;
    }
}
</script>
<script>
  
function funcion() {
      var roles = document.getElementById('selector').value;
      var fecha_inicio = document.getElementById('fecha_inicio').value;
      var fecha_final = document.getElementById('fecha_final').value;

      if (roles.trim() === "") {
         event.preventDefault();
         Swal.fire("Por favor, Seleccione un usuario.");
         return false;
      }
       else if(!/^[0-9]+$/.test(roles)){
         event.preventDefault();
         Swal.fire("Debe seleccionar una opcion Valida");
         return false;
      }  
      
      else if (fecha_inicio.trim() === "") {
         event.preventDefault();
         Swal.fire("La Fecha de inicio Debe ser Valida.");
         return false;
      }

      else if (fecha_final.trim() === "") {
         event.preventDefault();
         Swal.fire("a Fecha Final Debe ser Valida.");
         return false;
      }

      return true;
   }
</script>



</body>
</html>