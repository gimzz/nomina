<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
  
 // Include database file
 require_once "../../basededatos/base.php";
 require_once "../../basededatos/cargos/rangos.php";
  $usuariosObj = new cargos();

  $persona = $usuariosObj->departamento();
  // Insert Record in customer table
  if(isset($_POST['update'])) {

    extract($_POST);
  if (!empty($cargo)) 
  {
    if (!preg_match("/^[a-zA-Z\s]+$/", $cargo)) {
      echo " document.addEventListener('DOMContentLoaded', function() {
      <script>Swal.fire('El cargo no cumple con lo requerido');</script>;
    });";

    }
    
    if (!preg_match("/^[0-9]+$/", $departamento)) {
      echo " document.addEventListener('DOMContentLoaded', function() {
      <script>Swal.fire('Debe seleccionar un Departamento');</script>;
    });";

    }

    if (!preg_match("/^[0-9]{3,10}$/", $monto)) {
      echo "<script>document.addEventListener('DOMContentLoaded', function() {
          Swal.fire('Error', 'EL monto no cumple con lo requerido de 3 a 10 digitos', 'error');
      });</script>";
  }
    
    
    
    
    else 
      {
          $result = $usuariosObj->cargoExiste(); 
          if ($result===false) 
          {
              echo "<script>document.addEventListener('DOMContentLoaded', function() {
              Swal.fire('Error', 'El dato Ya Existe en la base de datos', 'error');
              });</script>";
          } 

          if ($result===true) 
          {
              echo "<script>document.addEventListener('DOMContentLoaded', function() {
              Swal.fire('¡Exito!', 'Se a Registrado Con Exito', 'error');
              });</script>";
          } 
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
  <link rel="stylesheet" href="../../assets/css/estilos.css">
</head>
<body>

<?php
require_once "menu.php";
require_once "../../basededatos/base.php";
require_once "../../basededatos/cargos/rangos.php";

$usuariosObj = new cargos();
$persona = $usuariosObj->departamento();

if(isset($_POST['update'])) {
    extract($_POST);
    if (!empty($cargo)) {
        if (!preg_match("/^[a-zA-Z\s]+$/", $cargo)) {
            echo "<script>Swal.fire('El cargo no cumple con lo requerido');</script>";
        } elseif (!preg_match("/^[0-9]+$/", $departamento)) {
            echo "<script>Swal.fire('Debe seleccionar un Departamento');</script>";
        } elseif (!preg_match("/^[0-9]{3,10}$/", $monto)) {
            echo "<script>Swal.fire('Error', 'El monto no cumple con lo requerido de 3 a 10 digitos', 'error');</script>";
        } else {
            $usuariosObj->cargoExiste();  
        }
    }
}  
?>
<div class="card text-center" style="padding:15px;">
  <h4>Registrar Informacion</h4>
</div><br> 
<div class="container">
  <form action="crear_cargos.php" method="POST" onsubmit="return validarFormulario()">
    <center><label for="usuario">Nombre del Cargo:</label></center>
    <input class="form-control" type="text" id="cargo" name="cargo" maxlength="100" pattern="[a-zA-Z\s]+" title="Solo letras y espacios"><br>
    
    <center><label>Departamentos</label></center>
    <select class="form-control" id="departamento" name="departamento" >
      <option value="" disabled selected>Seleccione un Departamento</option>
      <?php
      if (isset($persona)) {
          foreach ($persona as $fila) {
              echo "<option value='".$fila['id_departament']."'>" . $fila['nombre_departament']."</option>";
          }
      } else {
          echo "<option>No se ha definido la variable \$persona.</option>";
      }
      ?>
    </select>
    <br>
    <center><label for="usuario">Monto a Ganar:</label></center>
    <input class="form-control" type="text" id="monto" name="monto" maxlength="10" pattern="[0-9]+" title="Solo números"><br>
    <div class="form-group">
      <br>
      <center><input type="submit" name="update" class="btn btn-primary" style="float:right;" value="Registrar"></center>
    </div>
  </form>
</div>

<script>
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

  if (isNaN(montoValue)) {
    Swal.fire("Error", "El monto solo puede contener números.", "error");
    return false;
  }

  return true; // El formulario es válido
}
</script>

</body>
</html>