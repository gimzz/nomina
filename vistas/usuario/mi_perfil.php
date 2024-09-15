<?php

require "../../basededatos/base.php";
require "../../basededatos/personal/empleados.php";
session_start();
if (isset($_SESSION['user'])) {
    $cedula = $_SESSION['user']['cedula'];
    $empleado = new trabajador();
    $persona = $empleado->consultar_datos($cedula);
    $query = $empleado ->estados();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{  
    
    if (isset($_POST['update'])) 
    {
        $errors = [];
    $cedula = isset($_POST['cedula']) ? htmlspecialchars($_POST['cedula']) : '';
    $p_nombre = isset($_POST['p_nombre']) ? htmlspecialchars($_POST['p_nombre']) : '';
    $s_n = isset($_POST['s_n']) ? htmlspecialchars($_POST['s_n']) : '';
    $p_a = isset($_POST['p_a']) ? htmlspecialchars($_POST['p_a']) : '';
    $s_a = isset($_POST['s_a']) ? htmlspecialchars($_POST['s_a']) : '';
    $d = isset($_POST['d']) ? htmlspecialchars($_POST['d']) : '';
    $t_f = isset($_POST['t_f']) ? htmlspecialchars($_POST['t_f']) : '';
    $t_p = isset($_POST['t_p']) ? htmlspecialchars($_POST['t_p']) : '';
    $n_c = isset($_POST['n_c']) ? htmlspecialchars($_POST['n_c']) : '';
    $estados = isset($_POST['estados']) ? htmlspecialchars($_POST['estados']) : '';
    $municipio = isset($_POST['municipios']) ? htmlspecialchars($_POST['municipios']) : '';
    $usuario = isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : '';
    $clave = isset($_POST['clave']) ? htmlspecialchars($_POST['clave']) : '';

    if (empty($cedula) && empty($p_nombre) && empty($p_a) && empty($d) && empty($t_f) && 
        empty($t_p) && empty($n_c) && empty($estados) && empty($municipios) && 
        empty($usuario) && empty($clave)) 
        {
            $errors[] = "Todos los campos tienen que ser llenados.";
        }
      

        if (!preg_match('/^[0-9]+$/', $cedula)) {
            $errors[] = "La cédula solo debe contener números.";
        }

        if (!preg_match('/^[a-zA-ZÁÉÍÓÚáéíóúüÜñÑ]+$/', $p_nombre)) {
            $errors[] = "El nombre tiene que ser de solo letras";
        }

        if (!empty($s_n)) {
            if (!preg_match('/^[a-zA-ZÁÉÍÓÚáéíóúüÜñÑ]+$/', $s_n)) {
                $errors[] = "El segundo nombre tiene que ser de solo letras";
            }
        }

            if (!preg_match('/^[a-zA-ZÁÉÍÓÚáéíóúüÜñÑ]+$/', $p_a)) {
                $errors[] = "El primer apellido tiene que ser de solo letras";
            }


        

        if (!empty($s_a)) {
            if (!preg_match('/^[a-zA-ZÁÉÍÓÚáéíóúüÜñÑ]+$/', $s_a)) {
               $errors[] = "El segundo apellido tiene que ser de solo letras";
            }
        }


        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $d)) {
            $errors[] = "la direccion puede llevar numero letras y espacios";
        }

        if (!preg_match('/^[0-9]+$/', $t_f)) {
            $errors[] = "El telefono fijo debe llevar solo numeros";
        }

        if (!preg_match('/^[0-9]+$/', $t_p)) {
            $errors[] = "El telefono personal debe llevar solo numeros";
        }

        if (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[.!@#$%_-])[a-zA-Z0-9.!@#$%_-]+$/', $clave)) {
            $errors[] = "La contraseña debe tener numero simbolos y letras";
        }

        if (!preg_match('/^[a-zA-Z0-9.!@#$%_-]+$/', $usuario)) {
            $errors[] = "el usuario puede tener numero simbolos y letras";
    }

    if (empty($errors)) {
        $registro = new trabajador();
        $user = $registro->update_empleado();
        if ($user=== false) {
            echo'<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'warning',
                title: '¡Alerta!',
                text: 'Error al actualizar.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar'
            });
        });
            </script>";
          }
          else if ($user===true) {
            echo'<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
            icon: 'success',
            title: '¡Alerta!',
            text: 'El usuario fue Actualizado Exitosamente .',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Aceptar'
        });
    });
        </script>";
          }
        } 

        
      
        
    } 
    else 
    {
        echo'<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo "<script>";
        echo "function mostrarError(mensaje) {";
        echo "  Swal.fire({";
        echo "      icon: 'error',";
        echo "      title: '¡Error!',";
        echo "      html: mensaje,";
        echo "      confirmButtonColor: '#3085d6',";
        echo "      confirmButtonText: 'Aceptar'";
        echo "  });";
        echo "}";
        echo "mostrarError('" . implode("<br>", $errors) . "');"; // Muestra todos los errores juntos
        echo "</script>";
    }

} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel="stylesheet" href="../../assets/css/estilos.css">
    <title>Perfil del Usuario</title>
</head>
<body>
<?php require_once "menu.php"?>                     
<br>
<center><h1>Perfil del Usuario</h1></center>
<br>
<form method="POST" action="mi_perfil.php" onsubmit="funcion()" id="formulario" name="formulario">
<div class="row justify-content-center">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Cedula</label></center>
                        <input type="text" id="cedula" value="<?php echo $cedula?>" name="cedula" class="form-control">
                        <br>
                    </div>
                </div>

                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Primer Nombre</label></center>
                        <input type="text" id="p_nombre" name="p_nombre" value="<?php echo $persona['nombre']?>" class="form-control">
                        <br>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Segundo Nombre</label></center>
                        <input type="text" id="s_n" value="<?php echo $persona['segundo_n']?>" name="s_n" class="form-control">
                        <br>
                    </div>
                </div>

                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Primer Apellido</label></center>
                        <input type="text" id="p_a" name="p_a" value="<?php echo $persona['apellido']?>" class="form-control">
                        <br>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Segundo Apellido</label></center>
                        <input type="text" id="s_a" value="<?php echo $persona['segundo_a']?>"  name="s_a" class="form-control">
                        <br>
                    </div>
                </div>

                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Direccion</label></center>
                        <input type="text" id="d" name="d" value="<?php echo $persona['direccion']?>" class="form-control">
                        <br>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Telefono Fijo</label></center>
                        <input type="text"  id="t_f" value="<?php echo $persona['telefono_fijo']?>"  name="t_f" class="form-control">
                        <br>
                    </div>
                </div>

                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Telefono Personal</label></center>
                        <input type="text" id="t_p" name="t_p" value="<?php echo $persona['telefono_personal']?>" class="form-control">
                        <br>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Numero de Cuenta</label></center>
                        <input type="text"  id="n_c" value="<?php echo $persona['num_cuenta']?>" name="n_c" class="form-control">
                        <br>
                    </div>
                </div>

                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Estado</label></center>
                        <select class="form-control" id="estado" name="estados" >
                        <?php
        // Asegurarse de que $persona esté definido antes de usarlo
        if (isset($persona)) {
            foreach ($query as $fila) {
                // Verificar si la persona tiene este estado
                if ($persona['estado'] == $fila['id_estado']) {
                    $cond = "selected=selected";
                } else {
                    $cond = "";  
                }
                echo "<option value='".$fila['id_estado']."' $cond>" . $fila['nombre_estado']."</option>";
            }
        } else {
            echo "No se ha definido la variable \$persona.";
        }
        ?>
                    </select>
                        <br>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Municipio</label></center>
                        <select class="form-control" id="municipios" name="municipios">
                        <option value="<?php echo $persona['municipio']; ?>" selected><?php echo $persona['nombre_municipio']; ?></option>
                        </select>
                        
                        <br>
                    </div>
                </div>

                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Usuario</label></center>
                        <input type="text" id="usuario" name="usuario" value="<?php echo $persona['usuario']?>" class="form-control">
                        <br>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Contraseña</label></center>
                        <input type="password"  id="clave" value="<?php echo $persona['clave']?>" name="clave" class="form-control">
                        <br>
                    </div>
                </div>

                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Confirmacion de Contraseña</label></center>
                        <input type="password" id="confirmacion"   class="form-control">
                        <br>
                    </div>
                </div>
            </div>
            <input type="hidden" name="id_empleado" value="<?php echo $persona['id_empleado']?>" >
            <input type="hidden" name="id_usuario" value="<?php echo $persona['id_usuario']?>" >
            <br>

            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><button class="btn btn-primary"  name="update">Actualizar</button></center>
                        <br>
                    </div>
                </div>
            </div> 
            
            </form>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function() {
    // Verificar si se activa correctamente el evento ready
    console.log("El documento está listo");

    // Manejar el evento de cambio en el selector de estado
    $("#estado").change(function() {
        // Verificar si se activa correctamente el evento de cambio
        console.log("Se activó el evento de cambio en el selector de estado");

        var estadoSeleccionado = $(this).val();
        // Verificar el valor seleccionado
        console.log("Estado seleccionado:", estadoSeleccionado);

        // Guardar el municipio seleccionado actualmente
        var municipioSeleccionado = $("#municipios").val();

        // Realizar la consulta AJAX para obtener los municipios
        $.ajax({
            url: "../../basededatos/obtener_municipios/municipios.php", // Archivo PHP que manejará la consulta
            method: "POST",
            data: { estado_id: estadoSeleccionado }, // Enviar el ID del estado seleccionado al servidor
            dataType: "json",
            success: function(data) {
                // Verificar la respuesta del servidor
                console.log("Respuesta del servidor:", data);

                // Limpiar el selector de municipio
                $("#municipios").empty();
                
                // Verificar si hay datos de municipios en la respuesta
                if (data.length > 0) {
                    // Agregar las nuevas opciones al selector de municipio
                    $.each(data, function(key, municipio) {
                        $("#municipios").append("<option value='" + municipio.id_municipio + "'>" + municipio.nombre_municipio + "</option>");
                    });
                } else {
                    // Mostrar un mensaje si no se encontraron municipios
                    console.log("No se encontraron municipios para el estado seleccionado.");
                }

                // Restablecer el municipio seleccionado
                $("#municipios").val(municipioSeleccionado);
            },
        
            error: function(xhr, status, error) {
                // Mostrar información detallada sobre el error
                console.error("Error al obtener municipios: " + status + " - " + error);
            }
        });
    });

    // Al cargar la página, cargar los municipios correspondientes al estado seleccionado (si hay uno seleccionado)
    $("#estado").trigger("change");
});

 </script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
   function funcion() {
    console.log("La función funcion() se está ejecutando.");

      var usuario = document.getElementById('usuario').value;
      var pass = document.getElementById('clave').value;
      var cedula = document.getElementById('cedula').value;
      var nombre = document.getElementById('p_nombre').value;
      var s_n = document.getElementById('s_n').value;
      var p_a = document.getElementById('p_a').value;
      var s_a = document.getElementById('s_a').value;
      var t_f = document.getElementById('t_f').value;
      var d = document.getElementById('d').value;
      var t_p = document.getElementById('t_p').value;
      var n_c = document.getElementById('n_c').value;
      var estados = document.getElementById('estado').value;
      var municipios = document.getElementById('municipios').value;
      var clave2 = document.getElementById('confirmacion').value;

      if (usuario.trim() === "") {
         event.preventDefault();
         Swal.fire("Por favor, escribe el usuario.");
         return false;
      } 
      
      else if(!/^[a-zA-Z0-9!@#$_-]+$/.test(usuario)){
         event.preventDefault();
         Swal.fire("Solo puedes escribir números, letras y los siguientes símbolos en el campo de usuario: ! @ # $ _ . -");
         return false;
      } 
      
      else if (usuario.length > 13) {
         event.preventDefault();
         Swal.fire("El número de caracteres en el campo de usuario no puede ser mayor a 13.");
         return false;
      }

       else if (usuario.length < 7){
         event.preventDefault();
         Swal.fire("El Número de Caracteres en el Campo de Usuario no Puede Ser Menor a 7.");
         return false;
      }
      
      else if (pass.trim() === "") {
         event.preventDefault();
         Swal.fire("Por Favor, Escribe la Clave.");
         return false;
      }

      else if(!/^[a-zA-Z0-9.!@#$_-]+$/.test(pass)){
         event.preventDefault();
         Swal.fire("Solo puedes escribir números, letras y los siguientes símbolos en el campo de usuario: ! @ # $ _ . -");
         return false;
      } 

      else if (pass.length > 12) {
         event.preventDefault();
         Swal.fire("El número de caracteres en el campo de Clave no puede ser mayor a 8.");
         return false;
      }

       else if (pass.length < 7){
         event.preventDefault();
         Swal.fire("El Número de Caracteres en el Campo de Clave no Puede Ser Menor a 7.");
         return false;
      }

      else if(clave2.trim()=== "")
      {
        event.preventDefault();
        Swal.fire("Por favor confirme la Contraseña para Actualizar");
        return false;
      }
      
      else if (pass !== clave2) {
                    Swal.fire("Las contraseñas no coinciden");
                    return false; // Evita que el formulario se envíe
                 }

      if (cedula.trim() === "") {
         event.preventDefault();
         Swal.fire("Por favor, escribe la Cedula.");
         return false;
      } 
      
      else if(!/^[0-9]+$/.test(cedula)){
         event.preventDefault();
         Swal.fire("Solo puedes escribir números en el campo cedula. ");
         return false;
      } 
      
      else if (cedula.length > 8) {
         event.preventDefault();
         Swal.fire("El número de caracteres en el campo de cedula no puede ser mayor a 8.");
         return false;
      }

       else if (cedula.length < 6){
         event.preventDefault();
         Swal.fire("El Número de Caracteres en el Campo de cedula no Puede Ser Menor a 6.");
         return false;
      }

      if (nombre.trim() === "") {
         event.preventDefault();
         Swal.fire("Por favor, escriba su nombre.");
         return false;
      } 
      
      else if(!/^[a-zA-ZáéíóúÁÉÍÓÚ]+$/.test(nombre)){
         event.preventDefault();
         Swal.fire("Solo puedes escribir letras en el campo nombre. ");
         return false;
      } 
      
      else if (nombre.length > 23) {
         event.preventDefault();
         Swal.fire("El número de caracteres en el campo de Nombre no puede ser mayor a 23.");
         return false;
      }

       else if (nombre.length < 3){
         event.preventDefault();
         Swal.fire("El Número de Caracteres en el Campo de nombre no Puede Ser Menor a 3.");
         return false;
      }
      if (p_a.trim() === "") {
         event.preventDefault();
         Swal.fire("Por favor, escriba su apellido.");
         return false;
      } 
      
      else if(!/^[a-zA-ZáéíóúÁÉÍÓÚ]+$/.test(p_a)){
         event.preventDefault();
         Swal.fire("Solo puedes escribir letras en el campo apellido. ");
         return false;
      } 
      
      else if (p_a.length > 23) {
         event.preventDefault();
         Swal.fire("El número de caracteres en el campo de Segundo Nombre no puede ser mayor a 23.");
         return false;
      }

       else if (p_a.length < 3){
         event.preventDefault();
         Swal.fire("El Número de Caracteres en el Campo de Segundo Nombre no Puede Ser Menor a 3.");
         return false;
      }

      if (d.trim() === "") {
         event.preventDefault();
         Swal.fire("Por favor, escriba su Direccin.");
         return false;
      } 
      
      else if(!/^[a-zA-Z-0-9-áéíóúÁÉÍÓÚ\s]+$/.test(d)){
         event.preventDefault();
         Swal.fire("Solo puedes escribir letras en el campo apellido. ");
         return false;
      } 
      
      else if (d.length > 100) {
         event.preventDefault();
         Swal.fire("El número de caracteres en el campo de Segundo Nombre no puede ser mayor a 23.");
         return false;
      }

       else if (d.length < 3){
         event.preventDefault();
         Swal.fire("El Número de Caracteres en el Campo de Segundo Nombre no Puede Ser Menor a 3.");
         return false;
      }

      if (t_f.trim() === "") {
         event.preventDefault();
         Swal.fire("Por favor, escribe el telefono fijo.");
         return false;
      } 
      
      else if(!/^[0-9]+$/.test(t_f)){
         event.preventDefault();
         Swal.fire("Solo puedes escribir números en el telefono fijo. ");
         return false;
      } 
      
      else if (t_f.length > 11) {
         event.preventDefault();
         Swal.fire("El número de caracteres en el campo de telefono fijo no puede ser mayor a 11.");
         return false;
      }

       else if (t_f.length < 10){
         event.preventDefault();
         Swal.fire("El Número de Caracteres en el Campo de telefono fijo no Puede Ser Menor a 11.");
         return false;
      }

      if (t_p.trim() === "") {
         event.preventDefault();
         Swal.fire("Por favor, escribe el telefono personal.");
         return false;
      } 
      
      else if(!/^[0-9]+$/.test(t_p)){
         event.preventDefault();
         Swal.fire("Solo puedes escribir números en el telefono personal. ");
         return false;
      } 
      
      else if (t_p.length > 11) {
         event.preventDefault();
         Swal.fire("El número de caracteres en el campo de telefono personal no puede ser mayor a 11.");
         return false;
      }

       else if (t_p.length < 10){
         event.preventDefault();
         Swal.fire("El Número de Caracteres en el Campo de telefono personal no Puede Ser Menor a 11.");
         return false;
      }

      if (n_c.trim() === "") {
         event.preventDefault();
         Swal.fire("Por favor, escribe el Numero de Cuenta.");
         return false;
      } 
      
      else if(!/^[0-9]+$/.test(n_c)){
         event.preventDefault();
         Swal.fire("Solo puedes escribir números en el numero de cuenta. ");
         return false;
      } 
      
      else if (n_c.length > 20) {
         event.preventDefault();
         Swal.fire("El número de caracteres en el campo de numero de cuenta no puede ser mayor a 20.");
         return false;
      }

       else if (n_c.length < 19){
         event.preventDefault();
         Swal.fire("El Número de Caracteres en el Campo de numero de cuenta no Puede Ser Menor a 20.");
         return false;
      }

      else if(!/^[0-9]+$/.test(estados)){
         event.preventDefault();
         Swal.fire("Selecciona  un estado ");
         return false;
      } 
      
      else if (estados.length > 24) {
         event.preventDefault();
         Swal.fire("El número de caracteres en el campo de estados no puede ser mayor a 24.");
         return false;
      }

       else if (estados.length < 1){
         event.preventDefault();
         Swal.fire("El Número de Caracteres en el Campo de estados no Puede Ser Menor a 1.");
         return false;
      }

      else if(!/^[0-9]+$/.test(municipios)){
         event.preventDefault();
         Swal.fire("Seleccione un municipio ");
         return false;
      } 
      
      else if (municipios.length > 154) {
         event.preventDefault();
         Swal.fire("El número de caracteres en el campo de municipios no puede ser mayor a 154.");
         return false;
      }

       else if (municipios.length < 1){
         event.preventDefault();
         Swal.fire("El Número de Caracteres en el municipio no Puede Ser Menor a 1.");
         return false;
      }



      return true;
   }
</script>

</body>
</html>