<script src="../../assets/js/sweetalert2@11.js"></script>
<?php
// Incluye el archivo de la base de datos
require_once "../../basededatos/base.php";
require_once "../../basededatos/cargos/rangos.php";

// Instancia la clase para manipular cargos
$usuariosObj = new cargos();


if(isset($_GET['editId']) && !empty($_GET['editId'])) {
  $deleteId = $_GET['editId'];
  $persona = $usuariosObj->busqueda_cargos($deleteId); 
  $cargoas = $usuariosObj->departamento();
}

if(isset($_GET['msg'])) {
  $mensaje = $_GET['msg'];
  if ($mensaje === "error_missing_fields") {
      // Mostrar el mensaje de éxito utilizando SweetAlert2
      echo "
      <script>
          document.addEventListener('DOMContentLoaded', function() {
              Swal.fire({
                  icon: 'warning',
                  title: 'Error',
                  text: 'Debes llenar todos los campos',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'Aceptar'
              });
          });
      </script>";
  }
  
  else if($mensaje==="error_database_connection")
  {
    echo "
      
      <script>
          document.addEventListener('DOMContentLoaded', function() {
              Swal.fire({
                  icon: 'error',
                  title: 'Ups',
                  text: 'Error en la Base de Datos',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'Aceptar'
              });
          });
      </script>";
  }

  else if($mensaje==="cargos_nocumple")
  {
    echo "
      
      <script>
          document.addEventListener('DOMContentLoaded', function() {
              Swal.fire({
                  icon: 'error',
                  title: 'Ups',
                  text: 'El Campo Cargos no cumple con lo requerido',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'Aceptar'
              });
          });
      </script>";
  }

  else if($mensaje==="departamento_nocumple")
  {
    echo "
      
      <script>
          document.addEventListener('DOMContentLoaded', function() {
              Swal.fire({
                  icon: 'error',
                  title: 'Ups',
                  text: 'El Campo Cargos no cumple con lo requerido',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'Aceptar'
              });
          });
      </script>";
  }

  else if($mensaje==="monto_nocumple")
  {
    echo "
      
      <script>
          document.addEventListener('DOMContentLoaded', function() {
              Swal.fire({
                  icon: 'error',
                  title: 'Ups',
                  text: 'El monto no cumple con lo requerido de 3 a 10 digitos',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'Aceptar'
              });
          });
      </script>";
  }


  else if($mensaje==="update")
  {
    echo "
      
      <script>
          document.addEventListener('DOMContentLoaded', function() {
              Swal.fire({
                  icon: 'success',
                  title: '¡Exito!',
                  text: 'Se a Actualizado Exitosamente',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'Aceptar'
              });
          });
      </script>";
  }

  else if($mensaje==="error_update")
  {
    echo "
      
      <script>
          document.addEventListener('DOMContentLoaded', function() {
              Swal.fire({
                  icon: 'error',
                  title: 'Ups',
                  text: 'Error al Actualizar en la Base de Datos',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'Aceptar'
              });
          });
      </script>";
  }

  else if($mensaje==="error_query_preparation")
  {
    echo "
      
      <script>
          document.addEventListener('DOMContentLoaded', function() {
              Swal.fire({
                  icon: 'error',
                  title: 'Ups',
                  text: 'No se a podido Preparar la Consulta',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'Aceptar'
              });
          });
      </script>";
  }
}

// Verifica si se ha enviado el formulario y se va a actualizar un registro
if(isset($_POST['update'])) {
  extract($_POST);
  if (!empty($cargo)) {
      if (!preg_match("/^[a-zA-Z\s]+$/", $cargo)) {
          header("Location:edit_cargos.php?mgs=cargos_nocumple&editId=$id");
          exit;
      } elseif (!preg_match("/^[0-9]+$/", $departamento)) {
          header("Location:edit_cargos.php?mgs=departamento_nocumple&editId=$id");
          exit;
      } elseif (!preg_match("/^[0-9.]{3,10}$/", $monto)) {
          header("Location:edit_cargos.php?mgs=monto_nocumple&editId=$id");
          exit;
      } else {
          $usuariosObj->editarcargo();  
      }
  }
}  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Registrar Cargo</title>
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
  <h4>Registrar Informacion</h4>
</div><br> 
<div class="container">
  <form action="edit_cargos.php" onsubmit="return validarFormulario()" method="POST">

  <center><label for="usuario">Nombre del Cargo:</label></center>
    <input class="form-control" type="text" value="<?php echo $persona['nombre_cargos']?>" id="cargo" name="cargo" maxlength="100" pattern="[a-zA-Z\s]+" title="Solo letras y espacios"><br>
    
    <center><label>Departamentos</label></center>
    <select class="form-control" id="departamento" name="departamento" >
      <option value="" disabled selected>Seleccione un Departamento</option>
      <?php
      if (isset($cargoas)) {
          foreach ($cargoas as $fila) {
            if ($persona['id_departamento'] == $fila['id_departament']) {
              $cond = "selected=selected";
          } else {
              $cond = "";  
          }
              echo "<option value='".$fila['id_departament']."'$cond>" . $fila['nombre_departament']."</option>";
          }
      } else {
          echo "<option>No se ha definido la variable \$persona.</option>";
      }
      ?>
    </select>
    <br>

    <center><label for="usuario">Monto a Ganar:</label></center>
    <input class="form-control"value="<?php echo $persona['monto_a_gana']?>" type="text" id="monto" name="monto" maxlength="10" pattern="[0-9.]+" title="Solo números"><br>
    <br>
    
      <center><label for="usuario">Estatus:</label></center>
      <select name="estatus" class="form-control" id="estatus">
    <option value="Activo" <?php if($persona['estado'] === 'Activo') echo 'selected'; ?>>
        Activo
    </option>
    <option value="Inactivo" <?php if($persona['estado'] === 'Inactivo') echo 'selected'; ?>>
        Inactivo
    </option>
</select>
    <div class="form-group">
      <br>
      <input class="form-control" onkeyup="soloNumeros(this)" value="<?php echo $persona['id_cargos'] ;?>" type="hidden" id="id" name="id" required><br>
      <center><input type="submit" name="update" class="btn btn-primary" style="float:right;" value="Actualizar"></center>
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

function validarFormulario() { 
  var cargoInput = document.getElementById("cargo");
  var montoInput = document.getElementById("monto");
  var departamentoInput = document.getElementById("departamento");
  var cargoValue = cargoInput.value.trim();
  var montoValue = montoInput.value.trim();
  var departamentoValue = departamentoInput.value;

  if (cargoValue.length === 0 || cargoValue.length > 100) {
    Swal.fire("Error", "El nombre del cargo no puede estar vacío y debe tener menos de 100 caracteres.", "error");
    return false;
  }

  if (isNaN(departamentoValue)) {
    Swal.fire("Error", "Debes seleccionar un Departamento", "error");
    return false;
  }

  if (montoValue.length === 0) {
    Swal.fire("Error", "El monto no puede estar vacío", "error");
    return false;
  }

  if (montoValue.length < 3) {
    Swal.fire("Error", "El monto debe tener al menos 3 números", "error");
    return false;
  }

  if (montoValue.length > 10) {
    Swal.fire("Error", "El monto no puede tener más de 10 números", "error");
    return false;
  }

  if (!/^[a-zA-Z\s]+$/.test(cargoValue)) {
    Swal.fire("Error", "El nombre del cargo solo puede contener letras y espacios.", "error");
    return false;
  }

  if (isNaN(departamentoValue)) {
    Swal.fire("Error", "Debes seleccionar un Departamento", "error");
    return false;
  }

  if (!/^[0-9.]+$/.test(montoValue)) {
    Swal.fire("Error", "El monto solo puede contener números.", "error");
    return false;
  }

  return true; // El formulario es válido
}
</script>
</body>
</html>