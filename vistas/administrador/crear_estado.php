<script src="../../assets/js/sweetalert2@11.js"></script>
<?php
require_once "../../basededatos/base.php";
require_once "../../basededatos/estadoYmunicipio/est_muni.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST);

    if (empty($estado)) {
        echo "
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'warning',
                title: '¡Alerta!',
                text: 'El campo Estado está vacío.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar'
            });
        });
        </script>";
        return false;
    } else {
        // Si el campo no está vacío, realizas la validación adicional
        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{3,30}$/', $estado)) {
            echo "
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: '¡Alerta!',
                    text: 'El campo Estado solo debe contener letras y espacios.',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar'
                });
            });
            </script>";
            return false;
        } 
        else 
        {
           $est_muni = new est_muni();
           $est_muni->insert_estado();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel="stylesheet" href="../../assets/css/estilos.css">
  <!-- Incluir SweetAlert -->
  <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <title>Crear Estado</title>
</head>
<body>
<?php
require_once "menu.php";
?>


<div class="card text-center" style="padding:15px;">
  <h4>Registrar Estado</h4>
</div><br> 

<div class="container">
<form id="formulario" action="crear_estado.php" method="POST">

    <center><label for="clave">Nombre del nuevo Estado</label></center>
    <input class="form-control" type="text" onkeyup="letras(this)"  id="estado" name="estado" ><br>
     
    <div class="form-group">
      <br>
      <center><button type="button" class="btn btn-primary" style="float:right;" onclick="validarYEnviarFormulario()">Registrar</button></center>
    </div>
  </form>

</div>


</form>
<script>
    function letras(input) {
          var regex = /[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/gi;
          input.value = input.value.replace(regex, "");
        }
</script>
<script>
    function validarFormulario() {
        var estado = document.getElementById("estado").value;

        // Verificar que el campo no esté vacío
        if (estado === "") {
            Swal.fire("Debes llenar el campo del nombre del Estado");
            return false;
        }

        // Verificar longitud del estado
        if (estado.length < 3) {
            Swal.fire("El estado debe tener al menos tres letras");
            return false;
        }

        if (estado.length > 30) {
            Swal.fire("El estado debe tener menos de 31 letras");
            return false;
        }

        // Verificar que solo contenga letras
        if (!/^[a-zA-ZÀ-ÿ\s]+$/.test(estado)) {
            Swal.fire("Solo se puede escribir letras");
            return false;
        }

        return true; // Devuelve true si la validación es exitosa
    }

    function validarYEnviarFormulario() {
        if (validarFormulario()) {
            document.getElementById("formulario").submit();
        }
    }
</script>
</body>
</html>
