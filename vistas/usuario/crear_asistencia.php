<?php
  
 // Include database file
 require_once "../../basededatos/base.php";
 require_once "../../basededatos/asistencia/asistencia.php";


  $usuariosObj = new asistencia_persona();

  // Insert Record in customer table
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tu código de manejo de formulario aquí
    extract($_POST);
    if (empty($roles) && empty($password1) && empty($nombre) && empty($password)) 
    {
      echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>Swal.fire("Todos los campos estan vacios debe llenarlos");</script>';
      return false;
    }
    if (!empty($roles) && !empty($password1) && !empty($nombre) && !empty($password)) {

        if (!preg_match("/^[0-9]+$/", $roles)) {
          
            echo " <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>Swal.fire('Debe Seleccionar un Empleado');</script>";
            return false;
        } else {
            $resultado = $usuariosObj->registrar(); 
            /* var_dump($resultado);  */

        }
    }
}  
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Crear Asistencias De Empleados</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel="stylesheet" href="../../assets/css/estilos.css">
  <!-- Incluir SweetAlert -->
  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
</head>
<body>

<?php
require_once "menu.php";
?>

<div class="card text-center" style="padding:15px;">
  <h4>Registrar Informacion de asistencia</h4>
</div><br> 
<div class="container">
  <form id="formulario" action="crear_asistencia.php" method="POST">

    <center><label for="usuario">Nombre y Apellido:</label></center>
    <select class="form-control" id="selector"  name="roles">
      <option selected>Seleccione un Empleado</option>
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

    <center><label for="nombre">Hora de Llegada:</label></center> 
    <input class="form-control" type="time" id="llegada"  pattern="^(0[1-9]|1[0-2]):[0-5][0-9] (AM|PM)$" name="nombre" ><br>

    <center><label for="clave">Hora de Salida:</label></center>
    <input class="form-control" type="time" id="salida"  pattern="^(0[1-9]|1[0-2]):[0-5][0-9] (AM|PM)$" min="nombre" max="23:59" name="password" ><br>

    <center><label for="clave">Fecha</label></center>
    <input class="form-control" readonly  type="date"  value="<?php echo date('Y-m-d');?>"  name="password1" ><br>
     
    <div class="form-group">
      <br>
      <center><button type="button" class="btn btn-primary" style="float:right;" onclick="validarYEnviarFormulario()">Registrar</button></center>
    </div>
  </form>

</div>
<script>
  // Obtener los elementos de entrada de hora de salida y hora de llegada
  var salidaInput = document.getElementById("salida");
  var llegadaInput = document.getElementById("llegada");

  // Agregar un evento al cambio de la hora de salida
  salidaInput.addEventListener("change", function() {
    // Establecer la hora de salida como el valor mínimo de la hora de llegada
    llegadaInput.min = salidaInput.value;
  });

  // Agregar un evento al cambio de la hora de llegada
  llegadaInput.addEventListener("change", function() {
    // Verificar si la hora de llegada es anterior a la hora de salida
    if (llegadaInput.value < salidaInput.value) {
      Swal.fire("La hora de llegada tiene que ser inferior a la hora de salida");
      llegadaInput.value = salidaInput.value; // Establecer la hora de salida como la hora de llegada
    }
  });
</script>

<script>
function validarFormulario() {
    var horaLlegada = document.getElementById("llegada").value;
    var horaSalida = document.getElementById("salida").value;
    var persona = document.getElementById("selector").value;
    
     if(!/^[0-9]+$/.test(persona)){
         event.preventDefault();
         Swal.fire("Debe seleccionar una opcion Valida");
         return false;
      }  

    
      
    // Verificar que los campos no estén vacíos
    if (horaLlegada === "")  {
          Swal.fire("Debes colocar la hora de Llegada");
        return false;
    }

    if (horaSalida === "")  {
          Swal.fire("Debes colocar la hora de Salida");
        return false;
    }

    // Convertir las horas a objetos Date para compararlas
    var fechaLlegada = new Date("2000-01-01 " + horaLlegada);
    var fechaSalida = new Date("2000-01-01 " + horaSalida);

    // Verificar que la hora de salida no sea menor que la hora de llegada
    if (fechaSalida < fechaLlegada) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'La hora de salida no puede ser menor que la hora de llegada.'
        });
        return false;
    }

    // Verificar que la hora de llegada y salida estén dentro del horario normal (por ejemplo, de 8:00 AM a 5:00 PM)
    var horaInicio = new Date("2000-01-01 08:00");
    var horaFin = new Date("2000-01-01 17:00");

    if (fechaLlegada < horaInicio || fechaSalida > horaFin) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'La hora de llegada y salida deben estar dentro del horario normal (de 8:00 AM a 5:00 PM).'
        });
        return false;
    }

    // Si todas las validaciones pasan, retorna true
    return true;
}

function validarYEnviarFormulario() {
    if (validarFormulario()) {
        document.getElementById("formulario").submit();
    }
}
</script>
</body>
</html>
