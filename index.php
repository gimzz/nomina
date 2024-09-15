<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link rel="stylesheet" href="assets/css/login.css">
  <title>Bienvenidos</title>

  <?php include('vistas/administrador/header.php'); ?>
</head>

<?php
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
if (isset($_GET['msg1']) == "insert") {
  echo "<div class='alert alert-success alert-dismissible'>
          <button type='button' class='close' data-dismiss='alert'>&times;</button>
          Los datos fueron actualizados exitosamente
        </div>";
} 
if (isset($_GET['msg3']) == "danger") {
  echo "<div class='alert alert-danger alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
           Usuario o contraseña Erroneo
          </div>";
} 

if (isset($_GET['msg4']) == "danger") {
  echo "<div class='alert alert-danger alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
           Usuario o Contraseña Vacio
          </div>";
} 

if (isset($_GET['msg5']) == "danger") {
  echo "<div class='alert alert-danger alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            Usuario y Clave Deben ser de 8 a 16 caracteres e numero letras y Simbolo no Aceptado solo puede colocar(!.@ #$ _-);
          </div>";
} 
?>	

<body>
  <main id="main" class=" bg-dark">
    <div id="login-left">
    </div>

    <div id="login-right">
      <div class="card col-md-8">
        <div class="card-body">
          <form action="controlador/ingresar.php" onsubmit="return funcion()" name="formulario" method="POST">
            <div class="form-group">
              <label for="username" class="control-label">Usuario</label>
              <input type="text" id="cedula" name="usuario" onkeyup="letras(this)" minlength="8" id="myInput" maxlength="16" pattern="[a-zA-Z0-9!.@#$_-]+" class="form-control">
            </div>
            <div class="form-group">
              <label for="password" class="control-label">Clave</label>
              <input type="password" id="password" name="clave" onkeyup="letras(this)" minlength="8" id="myInput" maxlength="16" pattern="[a-zA-Z0-9!.@#$%^&*()_-]+" class="form-control">
              <div class="form-group">
                <input type="checkbox" onclick="myFunction()"> Mostrar Contraseña
              </div>
            </div>
            <center><button class="btn-sm btn-block btn-wave col-md-4 btn-primary" name="ingreso">Ingresar</button></center>
          </form>
        </div>
      </div>
    </div>
  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <script>
    function letras(input) {
      var regex = /[^a-zA-Z0-9!@#.$_-]/gi;
      input.value = input.value.replace(regex, "");
    }
  </script>

  <script>
    function myFunction() {
      var myInput = document.getElementById("password");
      if (myInput.type === "password") {
        myInput.type = "text";
      } else {
        myInput.type = "password";
      }
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
   function funcion() {
      var cedula = document.getElementById('cedula').value;
      var pass = document.getElementById('password').value;

      if (cedula.trim() === "") {
         event.preventDefault();
         Swal.fire("Por favor, escribe el usuario.");
         return false;
      } else if(!/^[a-zA-Z0-9!@#$_-]+$/.test(cedula)){
         event.preventDefault();
         Swal.fire("Solo puedes escribir números, letras y los siguientes símbolos en el campo de usuario: ! @ # $ _ . -");
         return false;
      } else if (cedula.length > 13) {
         event.preventDefault();
         Swal.fire("El número de caracteres en el campo de usuario no puede ser mayor a 13.");
         return false;
      } else if (cedula.length < 7){
         event.preventDefault();
         Swal.fire("El Número de Caracteres en el Campo de Usuario no Puede Ser Menor a 7.");
         return false;
      } else if (pass.trim() === "") {
         event.preventDefault();
         Swal.fire("Por Favor, Escribe la Clave.");
         return false;
      }

      return true;
   }
</script>



</body>

</html>
