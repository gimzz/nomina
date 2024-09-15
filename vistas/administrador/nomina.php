
<?php
// Incluir los archivos necesarios
require_once "../../basededatos/base.php";
require_once "../../basededatos/personal/empleados.php";

// Crear una instancia del objeto de trabajador
$persona = new trabajador();

if(isset($_GET['deleteId']) && !empty($_GET['deleteId'])) {
  $deleteId = $_GET['deleteId'];
   $resultado = $persona->delete_nomina($deleteId);
   if ($resultado===false) {
    // Display warning alert for deletion error
    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'warning',
        title: '¡Alerta!',
        text: 'Error al Eliminar.',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Aceptar'
    });
  });
    </script>";
   }
   if ($resultado===true) {
    // Display success alert for successful deletion
    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'success',
        title: '¡Alerta!',
        text: 'Dato Eliminado con Exito.',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Aceptar'
    });
  });</script>";
   }
}

// Consultar la lista de empleados
$empleados = $persona->busqueda_nomina();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Registro de Empleados</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel="stylesheet" href="../../assets/css/estilos.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>

</head>
<body>

<?php require_once "menu.php"; ?>

<main>
  <div class="container">
    <br>
    <h2>Registro de Empleados
      <a href="insert_nomina.php" class="btn btn-primary" style="float:right;">Crear Nomina</a>
    </h2>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Cedula</th>
          <th>Nombre Y Apellido</th>
          <th>Cargo</th>
          <th>Departamento</th>
          <th>Monto a Pagar</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($empleados)) : ?>
          <?php foreach ($empleados as $empleado) : ?>
            <tr>
              <td><?php echo $empleado['cedula'] ?></td>
              <td><?php echo $empleado['nombre'] . " " . $empleado['apellido']; ?></td>
              <td><?php echo $empleado['nombre_cargos']; ?></td>
              <td><?php echo $empleado['nombre_departament']; ?></td>
              <td><?php echo $empleado['total_pago']; ?></td>
              <td><!-- <a href="edit_nomina.php?editId=<//?php echo $empleado['id_nomina'] ?>" style="color:green"><i class="fa fa-pencil" aria-hidden="true"></i></a> -->
              <a href="crear_nomina.php?editId=<?php echo $empleado['id_nomina'] ?>" style="color:blue"><i class="fa fa-file" aria-hidden="true"></i></a>
                <a href="#" onclick="confirmar('<?php echo $empleado['id_nomina'] ?>')" style="color:red">
                  <i class="fa fa-trash" aria-hidden="true"></i>
                </a>
          </td> 
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else : ?>
          <tr>
            <td colspan="7" class="text-center">No hay datos disponibles</td>
          </tr>
        <?php endif; ?>

        <script src="../../assets/js/sweetalert2@11.js"></script>
<script>
    function confirmar(cedula) {
        Swal.fire({
            title: "¿Estás seguro de que deseas eliminar este registro?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Confirmar"
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirigir a la página de eliminación con el ID del registro
                window.location.href = "nomina.php?deleteId=" + cedula;
            }
        });
    }
</script>
      </tbody>
    </table>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"></script>
</body>
</html>
