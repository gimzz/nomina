<?php require "../basededatos/iniciar_sesion/inicio.php";?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
if (isset($_POST['ingreso'])) {
    $username = $_POST['usuario'];
    $password = $_POST['clave'];

    // Verificar si los campos de usuario y contraseña están vacíos
    if (empty($username) || empty($password)) {
        header('Location: ../index.php?msg4=danger'); // Redireccionar con mensaje de error
        exit; // Salir del script después de la redirección
    }

    // Validar el usuario y la contraseña utilizando expresiones regulares
    if (!preg_match('/^[a-zA-Z0-9!.@#$_-]{8,16}$/', $username) || !preg_match('/^[a-zA-Z0-9!.@#$_-]{8,16}$/', $password)) {
      header('Location: ../index.php?msg5=danger'); // Redireccionar con mensaje de error si los caracteres no son válidos
      exit; // Salir del script después de la redirección
  }
  
    $Model = new iniciar();
    $user = $Model->ingresar_dato($username, $password);
      var_dump($username, $password);
   /*  if ($user == false) {
        header('Location: ../index.php?msg3=danger'); // Redireccionar con mensaje de error
        exit; // Salir del script después de la redirección
    } */

    session_start();
    $_SESSION['user'] = $user;
    
    if (isset($_SESSION['user'])) {
        switch ($user['rol']) {
            case 1:
              //administrador
                header('Location: ../vistas/administrador/inicio.php');
                exit; // Salir del script después de la redirección
            case 2:
              //usuario
                 header('Location: ../vistas/usuario/inicio.php'); 
                exit;  // Salir del script después de la redirección
        }
    } else {
        header('Location: ../index.php');
        exit; // Salir del script después de la redirección
    }
} else {
    // Si no se envió el formulario correctamente, redirigir de vuelta al formulario de inicio de sesión
    header('Location: ../index.php');
    exit; // Salir del script después de la redirección
}
?>
<script>
   function funcion() {
   
   var cedula = document.forms.formulario.usuario.value;
   var pass = document.forms.formulario.clave.value;
   var final = document.forms.formulario.final.value;
   var motivo = document.forms.formulario.motivo.value;
                          // Javascript reGex for Name validation

   if (cedula == "") {
     event.preventDefault();
       swal("Por favor Escriba El Usuario.");
      cedula.focus();
       return false;
   }else if(!/[^a-zA-Z0-9!@#$_-]/.test(cedula)){
    event.preventDefault();
       swal("Solo puedes escribir números letras y simbolos en el campo de Usuario.");
      cedula.focus();
       return false;
   }else if (cedula.length>8) {
     event.preventDefault();
       swal("El número de caracteres en el campo de usuario no puede ser mayor a 13.");
      cedula.focus();
       return false;
   }  else if(cedula.length<7){
     event.preventDefault();
     swal("El número de caracteres en el campo de usuario no puede ser menor a 7.");
       cedula.focus();
       return false;
   } else if (pass == "") {
     event.preventDefault();
       swal("Por favor escriba la clave.");
      pass.focus();
       return false;
   }


   return true;
}
</script>