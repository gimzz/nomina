<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
  require_once "../../basededatos/base.php";
  require_once "../../basededatos/asignaciones/asignaciones.php";
  $persona = new asignacion();
  // Delete record from table
  if(isset($_GET['deleteId']) && !empty($_GET['deleteId'])) {
      $deleteId = $_GET['deleteId'];
       $resultado = $persona->delete($deleteId); 
       if ($resultado===false) {
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'warning',
            title: '¡Alerta!',
            text: 'Error al Eliminar.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Aceptar'
        }) });
        </script>";
       }
       if ($resultado===true) {
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: '¡Alerta!',
            text: 'Dato Eliminado con Exito.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Aceptar'
        }) });
        </script>";
       }
      
  }
?> 
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Asignaciones de Empleados</title>
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

<script>
  let dropdowns = document.querySelectorAll('.dropdown-toggle')
dropdowns.forEach((dd)=>{
    dd.addEventListener('click', function (e) {
        var el = this.nextElementSibling
        el.style.display = el.style.display==='block'?'none':'block'
    })
})
</script>



<main>

<div class="container">
  <br>
  <h2> Asignaciones de Empleados
    <a href="crear_asignaciones.php" class="btn btn-primary" style="float:right;">Añadir una Asignacion</a>
  </h2>
  <table class="table table-hover">
    <thead>
      <tr>
        
        <th>Numero</th>
        <th>Nombre de la Bonificacion</th>
        <th>Valor</th>
        <th>Cargos</th>
        <!-- <th>Acción</th> -->
      </tr>
    </thead>
    <tbody>
    <?php
$deliverys = $persona->busqueda_asignaciones();
$i=1;
if (!empty($deliverys)) {
    foreach ($deliverys as $delivery) {
        // Resto del código dentro del bucle
        ?>
        <tr>
          <td><?php echo $i++?></td>
          <td><?php echo $delivery['tipo_asignacion'];?></td>
          <td><?php echo $delivery['valor_asignacion'] ?></td>
          <td><?php echo $delivery['nombre_cargos'] ?></td>

          
        <!-- <td><a href="editar_asignaciones.php?editId=<?php echo $delivery['id_asignacion'] ?>" style="color:green"><i class="fa fa-pencil" aria-hidden="true"></i></a>
              <a href="#" onclick="confirmar('<?php echo $delivery['id_asignacion'] ?>')" style="color:red">
                <i class="fa fa-trash" aria-hidden="true"></i>
             </a>
          </td> -->
        </tr>
        <?php
    }
} else {
    // Código alternativo cuando no hay datos
     echo "No hay datos disponibles"; 
}
?>
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
                window.location.href = "asignaciones.php?deleteId=" + cedula;
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