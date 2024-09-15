<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <?php

require "../../basededatos/base.php";
require "../../basededatos/personal/empleados.php";
session_start();

$empleado = new trabajador();
$persona = $empleado->personas();
$query = $empleado->estados();
$querys = $empleado->departament();

if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
    $errors = [];
    extract($_POST);
  

    // Validaciones de los datos...
    if (empty($cedula)) {
        $errors[] = "Cedula Esta Vacia."; 
    }

    if (empty($p_nombre)) {
        $errors[] = "Primer nombre Esta Vacio."; 
    }


    if (empty($p_a)) {
        $errors[] = "Primer Apellido Esta Vacio."; 
    }

    if (empty($d)) {
        $errors[] = "Direccion esta Vacia"; 
    }

    if (empty($t_f)) {
        $errors[] = "El Campo telefono Esta Vacio."; 
    }

    if (empty($t_p)) {
        $errors[] = "el campo telefono Esta Vacio."; 
    }

    if (empty($nacimiento)) {
        $errors[] = "fecha de nacimiento esta Vacia."; 
    }

    if (empty($ingreso)) {
        $errors[] = "fecha de Ingreso esta Vacia."; 
    }

    if (empty($estados)) {
        $errors[] = "Debes seleccionar un estado."; 
    }

    if (empty($municipios)) {
        $errors[] = "Debes seleccionar un Municipio."; 
    }

    if (empty($departamento)) {
        $errors[] = "Debes seleccionar un Departamento."; 
    }

    if (empty($cargos)) {
        $errors[] = "Debes seleccionar un Cargo."; 
    }

    else
    {
        // Realizar otras validaciones si es necesario...
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

        if (empty($errors)) 
        {
            $registro = new trabajador();
            $user = $registro->crear_empleado();
            if ($user === false) {
                echo "<script> document.addEventListener('DOMContentLoaded', function() { Swal.fire({icon: 'error', title: 'Error', text: 'La cedula ya existe'}); });</script>";
            } else if ($user === true) {
                echo "<script>document.addEventListener('DOMContentLoaded', function() { Swal.fire({icon: 'success', title: 'Éxito', text: 'El empleado ha sido registrado correctamente.',}); });
             </script>";
            }
        } 
    }

    if (!empty($errors)) {
        echo "<script> document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({icon: 'error', title: 'Oops...', html: '" . implode("<br>", $errors) . "'}); });</script>";
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
    <title>Registrar Usuario</title>
</head>
<body>
<?php require_once "menu.php"?>                     
<br>
<center><h1>Registrar Usuario</h1></center>
<br>
<form method="POST" action="crear_empleado.php"  id="formulario" name="formulario">
<div class="row justify-content-center">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Cedula</label></center>
                        <input type="text" id="cedula" name="cedula" class="form-control">
                        <br>
                    </div>
                </div>

                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Primer Nombre</label></center>
                        <input type="text" id="p_nombre" name="p_nombre"  class="form-control">
                        <br>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Segundo Nombre</label></center>
                        <input type="text" id="s_n"  name="s_n" class="form-control">
                        <br>
                    </div>
                </div>

                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Primer Apellido</label></center>
                        <input type="text" id="p_a" name="p_a"  class="form-control">
                        <br>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Segundo Apellido</label></center>
                        <input type="text" id="s_a"   name="s_a" class="form-control">
                        <br>
                    </div>
                </div>

                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Direccion</label></center>
                        <input type="text" id="d" name="d"  class="form-control">
                        <br>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Telefono Fijo</label></center>
                        <input type="text"  id="t_f"   name="t_f" class="form-control">
                        <br>
                    </div>
                </div>

                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Telefono Personal</label></center>
                        <input type="text" id="t_p" name="t_p"  class="form-control">
                        <br>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Fecha de nacimiento</label></center>
                        <input type="date" value="<?php echo date('Y-m-d')?>" id="nacimiento" name="nacimiento" class="form-control">
                        <br>
                    </div>
                </div>

                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Fecha de Ingreso</label></center>
                        <input type="date" id="ingreso" value="<?php echo date('Y-m-d')?>" name="ingreso"  class="form-control">
                        <br>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Numero de Cuenta</label></center>
                        <input type="text"  id="n_c" max="20" name="n_c" class="form-control">
                        <br>
                    </div>
                </div>

                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Estado</label></center>
                        <select class="form-control" id="estado" name="estados" >
                            <option salected>Seleccione un Estado</option>
                        <?php
        // Asegurarse de que $persona esté definido antes de usarlo
            foreach ($query as $fila) {
                // Verificar si la persona tiene este estado
                /* if ($persona['estado'] == $fila['id_estado']) {
                    $cond = "selected=selected";
                } else {
                    $cond = "";  
                } */
                echo "<option value='".$fila['id_estado']."' $cond>" . $fila['nombre_estado']."</option>";
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
                        <!-- <option value="<//?php echo $persona['municipio']; ?>" selected><//?php echo $persona['nombre_municipio']; ?></option> -->
                        </select>
                        
                        <br>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                <center><label>Departamentos</label></center>
                        <select class="form-control"  id="departamentoSelect" name="departamento" >
                            <option selected>Seleccione un departamento</option>
                        <?php
            foreach ($querys as $fila) {
                // Verificar si la persona tiene este estado
                /* if ($persona['estado'] == $fila['id_estado']) {
                    $cond = "selected=selected";
                } else {
                    $cond = "";  
                } */
                echo "<option value='".$fila['id_departament']."' $cond>" . $fila['nombre_departament']."</option>";
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
                        <center><label>Cargos</label></center>
                        <select class="form-control" id="cargosSelect" name="cargos">
                        
                        </select>
                        <br>
                    </div>
                </div>
            </div>

               

            
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                    <center><button class="btn btn-primary" onclick="validarfuncion()" name="update">Registrar</button></center>
                        <br>
                    </div>
                </div>
            </div> 
            
            </form>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <script>
// Función para establecer automáticamente la fecha de ingreso 18 años después de la fecha de nacimiento
function establecerFechaIngreso() {
    var fechaNacimiento = new Date(document.getElementById("nacimiento").value);
    var fechaActual = new Date();
    var fechaIngreso = new Date(fechaNacimiento);
    fechaIngreso.setFullYear(fechaIngreso.getFullYear() + 18);

    // Verificar si la fecha de ingreso calculada es después de la fecha actual
    if (fechaIngreso > fechaActual) {
        fechaIngreso = fechaActual;
    }

    // Convertir la fecha de ingreso a formato de fecha válido para el input de tipo date
    var dia = ("0" + fechaIngreso.getDate()).slice(-2);
    var mes = ("0" + (fechaIngreso.getMonth() + 1)).slice(-2);
    var año = fechaIngreso.getFullYear();
    var fechaFormateada = año + "-" + mes + "-" + dia;

    // Establecer la fecha de ingreso automáticamente
    document.getElementById("ingreso").value = fechaFormateada;
}

// Agregar un evento de cambio a la fecha de nacimiento para llamar a la función que establece automáticamente la fecha de ingreso
document.getElementById("nacimiento").addEventListener("change", establecerFechaIngreso);

// Llamar a la función una vez para establecer la fecha de ingreso inicialmente
establecerFechaIngreso();
</script>
            <script>
document.addEventListener("DOMContentLoaded", function() {
  // Obtener referencias a los selectores de departamentos y cargos
  var departamentoSelect = document.getElementById("departamentoSelect");
  var cargosSelect = document.getElementById("cargosSelect");

  // Evento de cambio en el selector de departamentos
  departamentoSelect.addEventListener("change", function() {
    var departamentoId = this.value; // Obtener el ID del departamento seleccionado

    // Realizar una solicitud AJAX al servidor para obtener los cargos asociados al departamento seleccionado
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../../basededatos/obtener_cargos/cargos.php", true); // Archivo PHP que manejará la solicitud
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        // Limpiar el selector de cargos
        cargosSelect.innerHTML = "<option value=''>Seleccione un cargo</option>";
        
        // Procesar la respuesta del servidor y actualizar el selector de cargos
        var cargos = JSON.parse(xhr.responseText);
        cargos.forEach(function(cargo) {
          var option = document.createElement("option");
          option.value = cargo.id_cargos; // Asignar el ID del cargo como valor
          option.textContent = cargo.nombre_cargos; // Asignar el nombre del cargo como texto
          cargosSelect.appendChild(option);
        });
      }
    };
    // Enviar el ID del departamento seleccionado al servidor
    xhr.send("departamento_id=" + departamentoId);
  });

  // Agregar la opción "Seleccione un cargo" al cargar la página
  cargosSelect.innerHTML = "<option value=''>Seleccione un cargo</option>";
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
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
                
                // Agregar la opción "Seleccione un municipio"
                $("#municipios").append("<option value=''>Seleccione un municipio</option>");
                
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
      var ingreso = document.getElementById('ingreso').value;
      var cargos = document.getElementById('cargos').value;
      var departamento = document.getElementById('departamento').value;
      var nacimiento = document.getElementById('nacimiento').value;
      
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

      else if(!/^[0-9]+$/.test(departamento)){
         event.preventDefault();
         Swal.fire("Seleccione un Departamento ");
         return false;
      } 

      

      else if(!/^[0-9]+$/.test(cargos)){
         event.preventDefault();
         Swal.fire("Seleccione un Cargo");
         return false;
      } 

      if (nacimiento.trim() === "") {
         event.preventDefault();
         Swal.fire("Por favor, escribe el Numero de Cuenta.");
         return false;
      } 

      if (ingreso.trim() === "") {
         event.preventDefault();
         Swal.fire("Por favor, escribe el Numero de Cuenta.");
         return false;
      } 



      return true;
   }

   function validarfuncion() {
    if (funcion()) {
        document.getElementById("formulario").submit();
    }
}
</script>

</body>
</html>