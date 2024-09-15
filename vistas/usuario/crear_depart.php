<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
require_once "../../basededatos/base.php";
require_once "../../basededatos/cargos/rangos.php";

$usuariosObj = new cargos();

if (isset($_POST['update'])) {
    extract($_POST);
    if (!empty($cargo)) {
        if (!preg_match("/^[a-zA-Z\s]+$/", $cargo)) {
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire('El cargo no cumple con lo requerido');
            });
            </script>";
        } else {
            $result = $usuariosObj->departamentoExiste(); 
            if ($result === true) {
                echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire('¡Exito!', 'Se a Registrado con Exito', 'success');
                });
                </script>";
            } elseif ($result === false) {
                echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire('Error', 'El departamento ya existe en la base de datos', 'warning');
                });
                </script>";
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel="stylesheet" href="../../assets/css/estilos.css">
 
</head>
<body>
<?php require "menu.php";?>
<div class="card text-center" style="padding:15px;">
  <h4>Registrar Departamentos</h4>
</div><br> 
<div class="container">
  <form action="crear_depart.php" method="POST" onsubmit="return validarFormulario()">
    <center><label for="usuario">Nombre del Departamento:</label></center>
    <input class="form-control" type="text" id="cargo" name="cargo" maxlength="100" pattern="[a-zA-Z\s]+" title="Solo letras y espacios"><br>
    
    <div class="form-group">
      <br>
      <center><input type="submit" name="update" class="btn btn-primary" style="float:right;" value="Registrar"></center>
    </div>
  </form>
</div>

<script>
function validarFormulario() { 
  var cargoInput = document.getElementById("cargo");
  var cargoValue = cargoInput.value.trim();
  
  if (cargoValue.length === 0 || cargoValue.length > 100) {
    Swal.fire("Error", "El nombre del departamento no puede estar vacío y debe tener menos de 100 caracteres.", "error");
    return false;
  }

  if (!/^[a-zA-Z\s]+$/.test(cargoValue)) {
    Swal.fire("Error", "El nombre del cargo solo puede contener letras y espacios.", "error");
    return false;
  }

  return true; // El formulario es válido
}
</script>

</body>
</html>
