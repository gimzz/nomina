<script src="../../assets/js/sweetalert2@11.js"></script>

<?php
 require_once "../../basededatos/base.php";
 require_once "../../basededatos/deducciones/deducciones.php";
 if(isset($_GET['editId']) && !empty($_GET['editId'])) 
 {
        $persona = new deducciones();
        $deleteId = $_GET['editId'];
       $resultado = $persona->deduccion1($deleteId); 
 }

 if (isset($_GET['mgs'])) 
 {
    $mensaje = $_GET['mgs'];

    if ($mensaje === "vacios") {
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
    
    else if($mensaje==="letras_numeros")
    {
      echo "
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Ups',
                    text: 'Solo puedes ingresar numeros y letras',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar'
                });
            });
        </script>";
    }
  
    else if($mensaje==="solo_numeros")
    {
      echo "
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Ups',
                    text: 'el campo Valor de Deduccion solo acepta numeros',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar'
                });
            });
        </script>";
    }
  
    else if($mensaje==="error")
    {
      echo "
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Ups',
                    text: 'Error de conexion con la base de datos',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar'
                });
            });
        </script>";
    }
    else if($mensaje==="solo_elvalor")
    {
      echo "
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Exito!',
                    text: 'Actualización Exitosa',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar'
                });
            });
        </script>";
    }
  
 }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['update'])) { // Check if 'update' button is clicked
    extract($_POST);
    if (empty($deduccion) || empty($valor_deduccion)) 
    {
        header("Location: editar_deducciones.php?mgs=vacios&editId='$id'");
        exit;
    }
    elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/",$deduccion)) {
        header("Location: editar_deducciones.php?mgs=letras_numeros&editId='$id'");
        exit;
    }
    elseif (!preg_match("/^[0-9.]+$/",$valor_deduccion)) {
        header("Location: editar_deducciones.php?mgs=solo_numeros&editId='$id'");
        exit;
    }
    $deducciones = new deducciones();
    $deducciones->editar();
    
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel="stylesheet" href="../../assets/css/estilos.css">
    <title>Editar Deduccion</title>
</head>
<body>
<?php require_once "menu.php"; ?>

<div class="card text-center" style="padding:15px;">
    <h4>Editar Deduccion</h4>
</div><br> 
<div class="container">
  <form action="editar_deducciones.php" method="POST" onsubmit="return validarFormulario()">

  <center><label for="usuario">Nombre de la Deduccion:</label></center>
      <input class="form-control" type="text" id="deduccion" name="deduccion" value="<?php echo $resultado['nombre_deduccion'];?>" maxlength="100" pattern="[a-zA-Z\s]+" title="Solo letras y espacios" ><br>
    
      <center><label for="usuario">Valor de la Deduccion:</label></center>
      <input class="form-control" type="text" id="valor_deduccion" value="<?php echo $resultado['valor_deduccion'];?>" name="valor_deduccion" maxlength="9"  ><br>
    <div class="form-group">
      <br>
      <input class="form-control" type="hidden" value="<?php echo $resultado['id_deducciones'];?>" name="id" maxlength="9" pattern="[0-9]+"><br>
      <center><input type="submit" name="update" class="btn btn-primary" style="float:right;" value="Actualizar"></center>
    </div>
  </form>

  <script>
    function validarFormulario() 
    {
            var deduccion = document.getElementById("deduccion").value;
            var valor_deduccion = document.getElementById("valor_deduccion").value;

            // Verificar que el campo no esté vacío
            if (deduccion === "") {
                Swal.fire("Debes llenar el campo del nombre del Deduccion");
                return false;
            }

            if (valor_deduccion === "") {
                Swal.fire("Debes llenar el campo del Valor de la Deduccion");
                return false;
            }

            // Verificar longitud del municipio
            if (deduccion.length < 3 || deduccion.length > 30) {
                Swal.fire("La Deduccion debe tener entre 3 y 30 caracteres");
                return false;
            }

            if (valor_deduccion.length < 1 || valor_deduccion.length > 9) {
                Swal.fire("El Valor de deduccion debe tener entre 1 y 9 caracteres");
                return false;
            }

            // Verificar que solo contenga letras
            if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(deduccion)) {
                Swal.fire("El Deduccion solo debe contener letras y espacios");
                return false;
            }

            if (!/^[0-9.]+$/.test(valor_deduccion)) {
                Swal.fire("Solo debe contener numeros");
                return false;
            }

            return true; // Devuelve true si la validación es exitosa
    }
  </script>

</div>
</body>
</html>