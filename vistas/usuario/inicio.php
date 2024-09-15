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
  <title>Inicio</title>
</head>
<body style="background-color: lightblue;">
  <?php require_once "menu.php";?>
  <?php require_once "header.php";?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <?php
if (isset($_GET['msg1']) && $_GET['msg1'] === "danger") {
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'No hay usuario a consultar con esa Cedula',
                showConfirmButton: false,
                timer: 3000
            });
          </script>";
}
if (isset($_GET['msg2']) && $_GET['msg2'] === "danger") {
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error al ejecutar la consulta',
                showConfirmButton: false,
                timer: 3000
            });
          </script>";
}

if (isset($_GET['msg3']) && $_GET['msg3'] === "success") {
  echo'<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
  echo "<script>Swal.fire({
      icon: 'warning',
      title: '¡Alerta!',
      text: 'el Usuario debe poseer letras numeros y simbolos .',
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Aceptar'
  })</script>";
}
?>
  <main class="container">
    <div class="text-center">
      <img src="../../assets/img/gpg.png" class="img-fluid" style="max-width: 800px; max-height: 800px;" alt="Logo">
    </div>
  </main>
</body>
</html>
