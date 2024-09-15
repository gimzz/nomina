<?php
  
 // Include database file
 require_once "../../basededatos/base.php";
 require_once "../../basededatos/asistencia/asistencia.php";
  $usuariosObj = new asistencia_persona();

  // Verificar si se ha recibido un mensaje a través de la URL
  if(isset($_GET['msg'])) {
      $mensaje = $_GET['msg'];
      if ($mensaje === "update") {
          // Mostrar el mensaje de éxito utilizando SweetAlert2
          echo "
          <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
          <script>
              document.addEventListener('DOMContentLoaded', function() {
                  Swal.fire({
                      icon: 'success',
                      title: 'Éxito',
                      text: 'Fue actualizado con éxito',
                      confirmButtonColor: '#3085d6',
                      confirmButtonText: 'Aceptar'
                  });
              });
          </script>";
      }
      else if($mensaje==="update_failed")
      {
        echo "
          <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
          <script>
              document.addEventListener('DOMContentLoaded', function() {
                  Swal.fire({
                      icon: 'error',
                      title: 'Ups',
                      text: 'No fue Actualizado Ninguna Fila',
                      confirmButtonColor: '#3085d6',
                      confirmButtonText: 'Aceptar'
                  });
              });
          </script>";
      }

      else if($mensaje==="missing_data")
      {
        echo "
          <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
          <script>
              document.addEventListener('DOMContentLoaded', function() {
                  Swal.fire({
                      icon: 'error',
                      title: 'Ups',
                      text: 'Faltan datos por llenar',
                      confirmButtonColor: '#3085d6',
                      confirmButtonText: 'Aceptar'
                  });
              });
          </script>";
      }
  }
  
  

  if(isset($_GET['editId']) && !empty($_GET['editId'])) {
    $deleteId = $_GET['editId'];
    $persona = $usuariosObj->busqueda1($deleteId); 
  

}
  // Insert Record in customer table
  if(isset($_POST['update'])) {

    extract($_POST);
    if (empty($id) && empty($password1) && empty($nombre) && empty($password)) 
    {
        echo "
          
        <script>
        document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
        icon: 'warning',
        title: '¡Alerta!',
        text: 'Debes Llenar Todos los Campos.',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Aceptar'
      });
    });</script>";
    }
  if (!empty($id) && !empty($password1) && !empty($nombre) && !empty($password)) 
  {
    if (!preg_match("/^[0-9]+$/", $id)) {
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
    return false;
    }  else 
      {
           $usuariosObj->update();   
      }
    }

  }  
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Editar Asistencia</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
  <h4>Editar Informacion</h4>
</div><br> 
<div class="container">
  <form action="editar_asistencia.php" method="POST">

  <center><label for="usuario">Cedula:</label></center>
      <input class="form-control" readonly onkeyup="soloNumeros(this)" value="<?php echo $persona['cedula_empleado'];?>" type="text" name="id" id="cedula"  required><br>

    <center><label for="usuario">Nombre y Apellido:</label></center>
      <input class="form-control" readonly onkeyup="lettersOnly(this)"  type="text" value="<?php echo $persona['nombre']." ".$persona['apellido'];?>" id="usuario"  required><br>

      <center><label for="nombre">Hora de Llegada:</label></center> 
      <input class="form-control" type="time"  value="<?php echo $persona['hora_llegada'];?>"  id="nombre" name="nombre" required><br>

      <center><label for="clave">Hora de Salida </label></center>
      <input class="form-control"   type="time"  value="<?php echo $persona['hora_salida'];?>"  name="password" required><br>

      <center><label for="clave">Fecha</label></center>
      <input class="form-control"   type="date"  value="<?php echo $persona['fecha_ingreso'];?>"  name="password1" required><br>
     <input type="hidden" name="id" value="<?php echo $persona['id_asistencia'];?>">

    <div class="form-group">
      <br>
      <center><input type="submit" name="update" class="btn btn-primary" style="float:right;" value="Actualizar"></center>
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

<script src="../../assets/js/jquery.min.js"></script>
<script src="../../assets/js/bootstrap.min.js"></script>
</body>
</html>