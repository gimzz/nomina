<?php
  // Include database file
  require_once "../../basededatos/base.php";
  require_once "../../basededatos/personal/empleados.php";
?>

<!-- Include Sweet Alert script -->
<script src="../../assets/js/sweetalert2@11.js"></script>

<?php
  $usuariosObj = new trabajador();


  if(isset($_GET['editId']) && !empty($_GET['editId'])) {
    $deleteId = $_GET['editId'];
    $persona = $usuariosObj->busqueda_usuarios($deleteId); 
  }


  if(isset($_GET['mgs'])) {
    $mensaje = $_GET['mgs'];
    if ($mensaje === "camposvacios") {
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
    

    if ($mensaje === "roles_no_cumple") {
      // Mostrar el mensaje de éxito utilizando SweetAlert2
      echo "
      <script>
          document.addEventListener('DOMContentLoaded', function() {
              Swal.fire({
                  icon: 'warning',
                  title: 'Error',
                  text: 'Debes Seleccionar un Usuario',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'Aceptar'
              });
          });
      </script>";
  }

  if ($mensaje === "rol_no_cumple") {
    // Mostrar el mensaje de éxito utilizando SweetAlert2
    echo "
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'warning',
                title: 'Error',
                text: 'Debes Seleccionar un Rol',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar'
            });
        });
    </script>";
}

  if ($mensaje === "clave_nocumple") {
    // Mostrar el mensaje de éxito utilizando SweetAlert2
    echo "
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'warning',
                title: 'Error',
                text: 'La Clave solo puede contener numeros letras y estos simbolos !@#.$ _- ',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar'
            });
        });
    </script>";
}

if ($mensaje === "usuario_nocumple") {
  // Mostrar el mensaje de éxito utilizando SweetAlert2
  echo "
  <script>
      document.addEventListener('DOMContentLoaded', function() {
          Swal.fire({
              icon: 'warning',
              title: 'Error',
              text: 'El Usuario solo puede contener numeros letras y estos simbolos !@#.$ _- ',
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
  
    else if($mensaje==="error_al_actualizar")
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

  }







  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
      extract($_POST);
      if (empty($roles) && empty($usuario) && empty($clave)) 
      {
        header("Location: editar_usuario.php?mgs=camposvacios&editId=$id");
        exit;
        return false;
      }
      if (!empty($roles) && !empty($usuario) && !empty($clave)) {
        if (!preg_match("/^[0-9]+$/", $roles)) {
          // Display warning alert using Sweet Alert
          header("Location: editar_usuario.php?mgs=roles_no_cumple&editId=$id");
          exit;
        } 

        if (!preg_match("/^[0-9]+$/", $rol)) {
          // Display warning alert using Sweet Alert
          header("Location: editar_usuario.php?mgs=rol_no_cumple&editId=$id");
          exit;
        } 

        if (!preg_match("/^[a-zA-Z]+$/", $estatus)) {
          // Display warning alert using Sweet Alert
          header("Location: editar_usuario.php?mgs=estatus_no_cumple&editId=$id");
          exit;
      }
        if (!preg_match("/^[a-zA-Z0-9!@#.$ _-]+$/", $clave)) {
          // Display warning alert using Sweet Alert
          header("Location: editar_usuario.php?mgs=clave_nocumple&editId=$id");
          exit;
      }
      
      if (!preg_match("/^[a-zA-Z0-9!@#.$ _-]+$/", $usuario)) {
          // Display warning alert using Sweet Alert
          header("Location: editar_usuario.php?mgs=usuario_nocumple&editId=$id");
          exit;
      }
      

          
        
        else {
          $result = $usuariosObj->Editar_usuario();  
        
          }
        }
      }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Editar Usuario</title>
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
  <h4>Editar Usuarios</h4>
</div><br> 
<div class="container">
  <form action="editar_usuario.php" onsubmit="return validarFormulario();" method="POST">

    <center><label for="selector">Selecciona un Empleado:</label></center>
    <select class="form-control" id="selector" name="roles" >
      <option selected disabled>Seleccione una Opción</option>
      <?php
        $query = $usuariosObj->personas();
        foreach ($query as $fila) {
            if ($persona['cedula'] == $fila['cedula']) {
                $cond = "selected=selected";
            } else {
                $cond = "";  
            }
          echo "<option value='".$fila['cedula']."'$cond>" . $fila['nombre']." ".$fila['apellido']."</option>";
        }
      ?>
    </select>
    <br>

    <center><label for="usuario">Usuario:</label></center> 
    <input class="form-control" onkeyup="letras(this)" type="text" value="<?php echo $persona['usuario'];?>" id="usuario" name="usuario" required><br>

    <center><label for="clave">Contraseña</label></center>
    <input class="form-control" onkeyup="letras(this)" type="text" value="<?php echo $persona['clave'];?>" name="clave" id="clave" required><br>
     
    <center><label for="selector">Selecciona un Empleado:</label></center>
    <select class="form-control" id="rol" name="rol" >
      <option selected disabled>Seleccione una Opción</option>
      <?php
        $query = $usuariosObj->rol();
        foreach ($query as $fila) {
            if ($persona['rol'] == $fila['id_rol']) {
                $cond = "selected=selected";
            } else {
                $cond = "";  
            }
          echo "<option value='".$fila['id_rol']."'$cond>" . $fila['nombre_rol']."</option>";
        }
      ?>
    </select>
<br>
    <center><label for="selector">Selecciona un Estatus:</label></center>
    <select name="estatus" class="form-control" id="estatus">
    <option value="Activo" <?php if($persona['estatus'] === 'Activo') echo 'selected'; ?>>
        Activo
    </option>
    <option value="Inactivo" <?php if($persona['estatus'] === 'Inactivo') echo 'selected'; ?>>
        Inactivo
    </option>
</select>



<input type="hidden" name="id" value="<?php echo $persona['id_usuario'];?>">

    <div class="form-group">
      <br>
      <center><input type="submit" name="update" class="btn btn-primary" style="float:right;" value="Actualizar"></center>
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
    var estatus = document.getElementById('estatus').value;
    
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

     else if (!/^[a-z-A-Z]+$/.test(estatus)) {
        Swal.fire("Debe seleccionar una opción válida para el Estatus.");
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
