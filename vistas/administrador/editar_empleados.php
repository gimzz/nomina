<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <?php

require "../../basededatos/base.php";
require "../../basededatos/personal/empleados.php";


$empleado = new trabajador();
$persona = $empleado->personas();
$query = $empleado->estados();
$querys = $empleado->departament();
$quer = $empleado->cargos();
if (isset($_GET['mgs'])&& !empty($_GET['mgs'])) 
{
   $m = $_GET['mgs'];

   if ($m==='insert_exito') 
   {
        echo "<script>document.addEventListener('DOMContentLoaded', function() {
        Swal.fire('¡Exito!', 'Editado Con Exito', 'success');
        });</script>";
   }
}

if(isset($_GET['editId']) && !empty($_GET['editId'])) {
    $deleteId = $_GET['editId'];
     $resultado = $empleado->busqueda_empleado($deleteId);
    }

$cedula = isset($resultado[0]['cedula']) ? $resultado[0]['cedula'] : '';
$nombre = isset($resultado[0]['nombre']) ? $resultado[0]['nombre'] : '';
$segundo_n = isset($resultado[0]['segundo_n']) ? $resultado[0]['segundo_n'] : '';
$apellido = isset($resultado[0]['apellido']) ? $resultado[0]['apellido'] : '';
$segundo_a = isset($resultado[0]['segundo_a']) ? $resultado[0]['segundo_a'] : '';
$direccion = isset($resultado[0]['direccion']) ? $resultado[0]['direccion'] : '';
$telefono_fijo = isset($resultado[0]['telefono_fijo']) ? $resultado[0]['telefono_fijo'] : '';
$telefono_personal = isset($resultado[0]['telefono_personal']) ? $resultado[0]['telefono_personal'] : '';
$fecha_nacimiento = isset($resultado[0]['fecha_nacimiento']) ? $resultado[0]['fecha_nacimiento'] : '';
$fecha_ingreso = isset($resultado[0]['fecha_ingreso']) ? $resultado[0]['fecha_ingreso'] : '';
$num_cuenta = isset($resultado[0]['num_cuenta']) ? $resultado[0]['num_cuenta'] : '';
$estado = isset($resultado[0]['estados']) ? $resultado[0]['estados'] : '';
$municipio = isset($resultado[0]['municipio']) ? $resultado[0]['municipio'] : '';
$departamento = isset($resultado[0]['id_departament']) ? $resultado[0]['id_departament'] : '';
$cargos = isset($resultado[0]['cargos']) ? $resultado[0]['cargos'] : '';
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
            $user = $registro->update_empleados();
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
<center><h1>Editar USuario</h1></center>
<br>
<form method="POST" action="editar_empleados.php"  id="formulario" name="formulario">
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
                        <input type="text" id="p_nombre" value="<?php echo $nombre ?>" name="p_nombre"  class="form-control">
                        <br>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Segundo Nombre</label></center>
                        <input type="text" id="s_n" value="<?php echo $segundo_n?>"  name="s_n" class="form-control">
                        <br>
                    </div>
                </div>

                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Primer Apellido</label></center>
                        <input type="text" id="p_a" value="<?php echo $apellido?>" name="p_a"  class="form-control">
                        <br>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Segundo Apellido</label></center>
                        <input type="text" id="s_a" value="<?php echo $segundo_a?>"  name="s_a" class="form-control">
                        <br>
                    </div>
                </div>

                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Direccion</label></center>
                        <input type="text" id="d"  value="<?php echo $direccion?>" name="d"  class="form-control">
                        <br>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Telefono Fijo</label></center>
                        <input type="text" value="<?php echo $telefono_fijo?>"  id="t_f"   name="t_f" class="form-control">
                        <br>
                    </div>
                </div>

                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Telefono Personal</label></center>
                        <input type="text" value="<?php echo $telefono_personal?>" id="t_p" name="t_p"  class="form-control">
                        <br>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Fecha de nacimiento</label></center>
                        <input type="date" value="<?php echo $fecha_nacimiento?>" id="nacimiento" name="nacimiento" class="form-control">
                        <br>
                    </div>
                </div>

                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Fecha de Ingreso</label></center>
                        <input type="date" id="ingreso" value="<?php echo $fecha_ingreso?>" name="ingreso"  class="form-control">
                        <br>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                    <div class="peticiones">
                        <center><label>Numero de Cuenta</label></center>
                        <input type="text" value="<?php echo $num_cuenta?>"  id="n_c" max="20" name="n_c" class="form-control">
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
            $cond = ($estado == $fila['id_estado']) ? "selected='selected'" : "";
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
                         <option value="<?php echo $municipio; ?>" selected><?php echo $persona['nombre_municipio']; ?></option>
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
                 if ($departamento == $fila['id_departament']) {
                    $cond = "selected=selected";
                } else {
                    $cond = "";  
                } 
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
                        <select class="form-control" id="cargosSelect" name="cargos" data-cargo-actual="<?php echo $cargos; ?>">
                        <?php
            foreach ($quer as $fila) {
                // Verificar si la persona tiene este estado
                 if ($cargos == $fila['id_cargos']) {
                    $cond = "selected=selected";
                } else {
                    $cond = "";  
                } 
                echo "<option value='".$fila['id_cargos']."' $cond>" . $fila['nombre_cargos']."</option>";
            }
        ?>
                        
                        </select>
                        <br>
                    </div>
                </div>
            </div>

               <input type="hidden"  name="id_empleado" value="<?php echo $persona[0]['id_empleado']?>">

            
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
    // Verificar si se activa correctamente el evento ready
    console.log("El documento está listo");

    // Manejar el evento de cambio en el selector de estado
    $("#estado").change(function() {
        // Verificar si se activa correctamente el evento de cambio
       /*  console.log("Se activó el evento de cambio en el selector de estado"); */

        var estadoSeleccionado = $(this).val();
        // Verificar el valor seleccionado
       /*  console.log("Estado seleccionado:", estadoSeleccionado); */

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
      

</body>
</html>