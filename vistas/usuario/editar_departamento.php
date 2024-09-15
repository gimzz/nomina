<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
require_once "../../basededatos/base.php";
require_once "../../basededatos/cargos/rangos.php";

$persona = new cargos();

if (isset($_GET['mensaje'])) {
    // Mostrar el mensaje
    $mensaje = $_GET['mensaje'];
    if ($mensaje === "Erroralactualizar") {
        // Mostrar el mensaje de éxito utilizando SweetAlert2
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'ups',
                    text: 'No se pudo Actualizar',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar'
                });
            });
        </script>";
    }
    else if($mensaje==="correcto")
    {
      echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Exito!',
                    text: 'Fue Actualizado Exitosamente',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar'
                });
            });
        </script>";
    }

    else if($mensaje==="error")
    {
      echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Ups',
                    text: 'El campo departamento no cumple con lo requerido',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar'
                });
            });
        </script>";
    }

    else if($mensaje==="cargoyaexiste")
    {
      echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Ups',
                    text: 'El Departamento ya Existe',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar'
                });
            });
        </script>";
    }
}



if(isset($_GET['editId']) && !empty($_GET['editId'])) {
    $deleteId = $_GET['editId'];
     $resultado = $persona->busqueda_departamento($deleteId); 
    }

if (isset($_POST['update'])) {
    extract($_POST);
    if (!empty($cargo)) {
        if (!preg_match("/^[a-zA-Z\s]+$/", $cargo)) {
            header("Location: editar_departamento.php?mensaje=error&editId=$id");
                        exit();
        } else {
            $persona->actualizarDepartamento(); 
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
  <form action="editar_departamento.php" method="POST" onsubmit="return validarFormulario()">
    <center><label for="usuario">Nombre del Departamento:</label></center>
    <input class="form-control" type="text" id="cargo" name="cargo" value="<?php echo $resultado['nombre_departament']?>" maxlength="100" pattern="[a-zA-Z\s]+" title="Solo letras y espacios"><br>
    <input class="form-control" type="hidden" value="<?php echo $resultado['id_departament']?>" name="id" maxlength="100">
    
    <div class="form-group">
      <br>
      <center><input type="submit" name="update" class="btn btn-primary" style="float:right;" value="Actualizar"></center>
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
