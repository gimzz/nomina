<?php
  // Include database file
  require_once "../../basededatos/base.php";
  require_once "../../basededatos/personal/empleados.php";
?>

<!-- Include Sweet Alert script -->
<script src="../../assets/js/sweetalert2@11.js"></script>

<?php
  $usuariosObj = new trabajador();
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
      extract($_POST);
      if (empty($roles) && empty($usuario) && empty($clave)) 
      {
        echo "
        <script>
        document.addEventListener('DOMContentLoaded', function() {
        
        Swal.fire({
        icon: 'warning',
        title: '¡Alerta!',
        text: 'Debes llenar todos los Campos.',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Aceptar'
      });
    });
      </script>";
        return false;
      }
      if (!empty($roles) && !empty($usuario) && !empty($clave)) {
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
        });
          </script>";
        } 

        if (!preg_match("/^[a-zA-Z0-9]+$/", $clave)) {
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
          });
            </script>";
          }

          if (!preg_match("/^[a-zA-Z0-9]+$/", $usuario)) {
            // Display warning alert using Sweet Alert
            echo "
              <script>
              document.addEventListener('DOMContentLoaded', function() {
              
              Swal.fire({
              icon: 'warning',
              title: '¡Alerta!',
              text: 'El usuario debe poseer numero y letras.',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Aceptar'
            });
          });
            </script>";
          }

          
        
        else {
          $result = $usuariosObj->agregar();  
          if ($result === false) {
            // Display warning alert for existing user
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'warning',
              title: '¡Alerta!',
              text: 'El usuario ya Esta Utilizado.',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Aceptar'
            }); });
            </script>";
          } else if ($result === true) {
            // Display success alert for successful submission
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'success',
              title: '¡Exito!',
              text: 'El Usuario fue Guardado Exitosamente .',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Aceptar'
            });
        });
            </script>";
          }
        }
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Registrar Usuario</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel="stylesheet" href="../../assets/css/estilos.css">
</head>
<body>

<?php
require_once "menu.php";
?>

<div class="card text-center" style="padding:15px;">
  <h4>Registrar Usuarios</h4>
</div><br> 
<div class="container">
  <form action="crear_usuarios.php" onsubmit="return validarFormulario();" method="POST">

    <center><label for="selector">Selecciona un Empleado:</label></center>
    <select class="form-control" id="selector" name="roles" required >
      <option selected disabled>Seleccione una Opción</option>
      <?php
        $query = $usuariosObj->personas();
        foreach ($query as $fila) {
          echo "<option value='".$fila['cedula']."'>" . $fila['nombre']." ".$fila['apellido']."</option>";
        }
      ?>
    </select>
    <br>

    <center><label for="usuario">Usuario:</label></center> 
    <input class="form-control" onkeyup="letras(this)" type="text" id="usuario" name="usuario" ><br>

    <center><label for="clave">Contraseña</label></center>
    <input class="form-control" onkeyup="letras(this)" type="password" name="clave" id="clave" ><br>

    <center><label for="selector">Selecciona un Rol:</label></center>
    <select class="form-control" id="rol" name="rol">
      <option selected disabled>Seleccione una Opción</option>
      <?php
        $query = $usuariosObj->rol();
        foreach ($query as $fila) {
          echo "<option value='".$fila['id_rol']."'>" . $fila['nombre_rol']."</option>";
        }
      ?>
    </select>
     
    <div class="form-group">
      <br>
      <center><input type="submit" name="update" class="btn btn-primary" style="float:right;" value="Registrar"></center>
    </div>
  </form>
</div>

<script>
  function letras(input) { 
    var regex = /[^a-zA-Z0-9!@#.$_-]/gi;
    input.value = input.value.replace(regex, "");
  }

  

  function validarFormulario() {
    var roles = document.getElementById('selector').value;
    var usuario = document.getElementById('usuario').value;
    var clave = document.getElementById('clave').value;
    var rol = document.getElementById('rol').value;

    if (roles.trim() === "") {
        Swal.fire("Por favor, seleccione un usuario.");
        return false;
    } 
    if (rol.trim() === "") {
        Swal.fire("Por favor, seleccione un usuario.");
        return false;
    }
    else if (!/^[0-9]+$/.test(roles)) {
        Swal.fire("Debe seleccionar una opción válida para el usuario.");
        return false;
    }

    else if (!/^[0-9]+$/.test(rol)) {
        Swal.fire("Debe seleccionar una opción válida para el Rol.");
        return false;
    }
    
    else if (usuario.trim() === "") {
        Swal.fire("El campo de usuario no puede estar vacío.");
        return false;
    } else if (clave.trim() === "") {
        Swal.fire("El campo de clave no puede estar vacío.");
        return false;
    } else if (!/^[a-zA-Z0-9!@#.$_-]+$/.test(usuario)) {
        Swal.fire("El usuario solo puede contener letras, números y los caracteres especiales: !@#.$_-");
        return false;
    } else if (!/^[a-zA-Z0-9!@#.$_-]+$/.test(clave)) {
        Swal.fire("La clave solo puede contener letras, números y los caracteres especiales: !@#.$_-");
        return false;
    }

    return true;
}


</script>

</body>
</html>
