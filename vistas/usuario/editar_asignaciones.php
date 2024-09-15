<?php
  // Include database file
  require_once "../../basededatos/base.php";
  require_once "../../basededatos/asignaciones/asignaciones.php";
?>

<!-- Include Sweet Alert script -->
<script src="../../assets/js/sweetalert2@11.js"></script>

<?php

if (isset($_GET['mgs']) &&!empty($_GET['mgs'])) {
    $m = $_GET['mgs'];

    if ($m==='danger') {
        echo "
          
        <script>
        document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
        icon: 'warning',
        title: '¡Alerta!',
        text: 'Debes seleccionar un Cargo.',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Aceptar'
      });
    });</script>";
    }

    if ($m==='dangerers') {
        echo "
          
        <script>
        document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
        icon: 'error',
        title: '¡Alerta!',
        text: 'No se pudo Insertar',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Aceptar'
      });
    });</script>";
    }

    

  if ($m==='error') {
    echo "
      
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
    icon: 'warning',
    title: '¡Alerta!',
    text: 'Debes seleccionar un Cargo.',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Aceptar'
  });
});</script>";
}

if ($m==='error_asignada') {
    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      icon: 'warning',
      title: '¡Alerta!',
      text: 'Ya la Asignacion se Encuentra Registrada',
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Aceptar'
    });
  }); </script>";
}
if ($m==='update') {
    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
          icon: 'success',
          title: '¡Exito!',
          text: 'La Asignacion fue Actualizada Exitosamente .',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Aceptar'
        });
      });</script>";
}
}
$usuariosObj = new asignacion();
if (isset($_GET['editId'])&&!empty($_GET['editId'])) 
{
    $id = $_GET['editId'];
    $resultado = $usuariosObj->busqueda_asignacion($id);
    var_dump($resultado);
}

  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
      extract($_POST);
      if (!empty($roles) && !empty($fecha_inicio) && !empty($fecha_final)) {
        if (!preg_match("/^[0-9]+$/", $roles)) {
          // Display warning alert using Sweet Alert
          header("Location:editar_asignaciones.php?mgs=error&editId=$id");
          exit;
        } else {
          $usuariosObj->editar();  
        
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
  <h4>Registrar Asignaciones de Empleados</h4>
</div><br> 
<div class="container">
  <form action="editar_asignaciones.php" onsubmit="return funcion();"  method="POST">

  <center><label for="usuario">Selecciona un cargo:</label></center>
  <select class="form-control" id="selector" name="roles">
    <option selected>Seleccione una Opción</option>
    <?php
    $query = $usuariosObj->cargos();
    foreach ($query as $fila) {
        // Verificar si esta fila corresponde al cargo seleccionado previamente
        if ($resultado[0]['id_cargos'] == $fila['id_cargos']) {
            $cond = "selected"; // Agregar el atributo 'selected' si coincide
        } else {
            $cond = ""; // De lo contrario, dejar vacío
        }
        // Imprimir la opción con el atributo 'selected' si corresponde
        echo "<option value='".$fila['id_cargos']."' ".$cond.">" . $fila['nombre_cargos']."</option>";
    }
    ?>
</select>
        <br>
      <center><label for="nombre">Nombre de la Asignación:</label></center> 
      <input class="form-control" value="<?php echo $resultado[0]['tipo_asignacion']?>" type="text" onkeydown="lettersOnly(this)"  id="fecha_inicio" name="fecha_inicio"><br>

      <center><label for="clave">Valor Asignacion </label></center>
      <input class="form-control" value="<?php echo $resultado[0]['valor_asignacion']?>" onkeydown="soloNumeros(this)"  type="text" name="fecha_final" id="fecha_final" ><br>
     
    <div class="form-group">
      <br>
      <input name="id" type="hidden" value="<?php echo $resultado[0]['id_asignacion']?>">
      <center><input type="submit" name="update" class="btn btn-primary" style="float:right;" value="Registrar"></center>
    </div>
  </form>

</div>
<script>
    function lettersOnly(input) { 
      var regex = /[^a-zA-ZÀ-ÿ\s]/gi;
    input.value = input.value.replace(regex, "");
} 

function soloNumeros(input) {
  var regex = /[^0-9.]/gi;
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
  
function funcion() {
      var roles = document.getElementById('selector').value;
      var fecha_inicio = document.getElementById('fecha_inicio').value;
      var fecha_final = document.getElementById('fecha_final').value;

      if (roles.trim() === "") {
         event.preventDefault();
         Swal.fire("Por favor, Seleccione un Cargo.");
         return false;
      }
       else if(!/^[0-9]+$/.test(roles)){
         event.preventDefault();
         Swal.fire("Debe seleccionar un Cargo");
         return false;
      }  
      
      else if (fecha_inicio.trim() === "") {
         event.preventDefault();
         Swal.fire("El campo nombre de la asignacion no puede estar Vacio");
         return false;
      }

      else if(/[^a-zA-ZÀ-ÿ\s]/.test(fecha_inicio)){
         event.preventDefault();
         Swal.fire("Debe seleccionar una opcion Valida");
         return false;
      }  

      else if (fecha_final.trim() === "") {
         event.preventDefault();
         Swal.fire("EL valor asignado no puede estar vacio");
         return false;
      }

      else if(!/^[0-9.]+$/.test(fecha_final)){
         event.preventDefault();
         Swal.fire("En el valor de la asignacion solo se pueden escribir numeros");
         return false;
      }  

      return true;
   }
</script>



</body>
</html>