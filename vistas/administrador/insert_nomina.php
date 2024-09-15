<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
require_once "../../basededatos/base.php";
require_once "../../basededatos/personal/empleados.php";

// Objeto para manejar las consultas a la base de datos
$usuariosObj = new trabajador();

// Obtener la lista de empleados para el selector
$empleados = $usuariosObj->personas();
// Verificar si se ha enviado el formulario

    // Tu código aquí
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
if(isset($_GET['buscar'])) {
    $empleadoSeleccionado = $_GET['empleado'];
    $fecha_inicio = $_GET['inicio'];
    $fecha_fin = $_GET['fin'];

    $_SESSION['empleado'] = $empleadoSeleccionado;
    $_SESSION['inicio'] = $fecha_inicio;
    $_SESSION['fin'] = $fecha_fin;

    // Realizar la búsqueda del empleado en la base de datos
     $datosEmpleado = $usuariosObj->obtenerEmpleadoPorCedula($empleadoSeleccionado,$fecha_inicio,$fecha_fin);
     $deduccion = $usuariosObj->deduccion1();
    // Verificar si se encontraron datos del empleado
    // Llenar los campos del formulario con los datos del empleado
    if ($datosEmpleado) {
        $cargo = $datosEmpleado[0]['nombre_cargos']; // Utiliza la clave correcta para el cargo
        $sueldo_mensual = $datosEmpleado[0]['monto_a_gana']; // Utiliza la clave correcta para el sueldo mensual
        $asistencia_de_mes = $datosEmpleado[0]['asistencias_mes'];
        // Calcula el sueldo por día
        $sueldo_por_dia = $sueldo_mensual / date('t');
    
        // Calcula el total de días laborados en el mes actual
        $total_dias_laborados = $asistencia_de_mes;
    
        // Calcula las ganancias del mes
        $ganancias_mes = $sueldo_por_dia * $total_dias_laborados;
    
        // Inicializa el total a deducir
        $total_deducir = 0;
    
        // Calcula las deducciones
        foreach ($deduccion as $deducciones) {
            $porcentaje_deduccion = $deducciones['valor_deduccion'] / 100; // Convierte el porcentaje a decimal
            $total_deducir += $ganancias_mes * $porcentaje_deduccion;
        }
    
        // Verifica si existen las claves de las asignaciones
        if (isset($datosEmpleado[0]['valores_asignacion']) && isset($datosEmpleado[0]['tipos_asignacion'])) {
            // Dividir los valores de asignación y tipos en arrays separados
            $valores_asignacion = explode(',', $datosEmpleado[0]['valores_asignacion']);
            $tipos_asignacion = explode(',', $datosEmpleado[0]['tipos_asignacion']);
    
            // Verificar que haya al menos un valor de asignación y tipo
            if (count($valores_asignacion) > 0 && count($tipos_asignacion) > 0) {
                // Obtener el primer valor y tipo de asignación
                $valor_asignacion_1 = $valores_asignacion[0]; // Usando el primer valor de asignación
                $tipo_asignacion_1 = $tipos_asignacion[0];
    
                // Si hay más de una asignación, obtén la segunda asignación
                if (count($valores_asignacion) > 1 && count($tipos_asignacion) > 1) {
                    // Obtener el segundo valor y tipo de asignación
                    $valor_asignacion_2 = $valores_asignacion[1];
                    $tipo_asignacion_2 = $tipos_asignacion[1];
                    $asignacion_total = $valor_asignacion_2 + $valor_asignacion_1;
                } else {
                    // Si solo hay una asignación, establece el segundo valor y tipo como vacíos
                    $valor_asignacion_2 = "";
                    $tipo_asignacion_2 = "";
                    $asignacion_total = $valor_asignacion_1;
                }
            }
        } else {
            // Si no existen las claves de las asignaciones, establece los valores como vacíos
            $valor_asignacion_1 = "";
            $valor_asignacion_2 = "";
        }
    } else {
        // Si no se encuentra el empleado, mostrar un mensaje de error o redireccionar a otra página
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Ups',
                    text: 'El Empleado no ha asistido ningún día del mes',
                });
            });
        </script>";
    }
    

    } else {
        // Si no se encuentra el empleado, mostrar un mensaje de error o redireccionar a otra página
        echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'warning',
            title: 'Ups',
            text: 'No has Seleccionado un Empleado',
        });
    });
</script>";
    }
}


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

// Verificar si se ha enviado el formulario para registrar los datos en la tabla
if(isset($_POST['insertar'])) {
    if(empty($_POST['cargo']) && empty($_POST['sueldo_bruto']) && empty($_POST['asignacion_total']) && empty($_POST['deducciones']) && empty($_POST['total_deducir']) && empty($_POST['sueldo_neto']) && empty($_POST['cedula'])) 
    {
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'warning',
                title: 'Ups',
                text: 'Los campos Estan vacios',
            });
        });
    </script>";
    }
    // Verificar que los campos no estén vacíos
    if(!empty($_POST['cargo']) && !empty($_POST['sueldo_bruto']) && !empty($_POST['asignacion_total']) && !empty($_POST['deducciones']) && !empty($_POST['total_deducir']) && !empty($_POST['sueldo_neto']) && !empty($_POST['cedula'])) {
        // Verificar que los campos numéricos contengan valores numéricos
        if(is_numeric($_POST['sueldo_bruto']) && is_numeric($_POST['asignacion_total']) && is_numeric($_POST['deducciones']) && is_numeric($_POST['total_deducir']) && is_numeric($_POST['sueldo_neto']) && is_numeric($_POST['cedula'])) {
            extract($_POST);
            $resultado = $usuariosObj->insertarDatosEnTabla();
            if ($resultado===true) 
            {
                echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Exito!',
                        text: 'Se a Registrado Con Exito',
                    });
                });
                </script>";
            }
            if ($resultado===false) 
            {
                echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se a podido insertar',
                    });
                });
                </script>";
            }

            $cargo = "";
            $asignacion_total="";
            $total_deducir="";
            

        } else {
            // Si algún campo numérico no contiene un valor numérico, mostrar un mensaje de error
            echo "<script>alert('Los campos numéricos deben contener valores numéricos');</script>";
        }
    } else {
        // Si algún campo está vacío, mostrar un mensaje de error
        echo "<script>alert('Todos los campos son obligatorios');</script>";
    }
}


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Registrar Nomina</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <link rel="stylesheet" href="../../assets/css/estilos.css">
</head>
<body>

<?php
require_once "menu.php";
?>
<div class="card text-center" style="padding:15px;">
    <h4>Registrar Nomina</h4>
</div><br>
<div class="container">
    <form action="insert_nomina.php" method="GET">
        <center><label>Empleados</label></center>
        <select class="form-control" id="empleado" name="empleado">
    <option value="" disabled>Seleccione un Empleado</option>
    <?php
    if (isset($empleados)) {
        foreach ($empleados as $empleado) {
            $selected = isset($_SESSION['empleado']) && $_SESSION['empleado'] == $empleado['cedula'] ? 'selected' : '';
            echo "<option value='".$empleado['cedula']."' $selected>" . $empleado['nombre']." ".$empleado['apellido']."</option>";
        }
    } else {
        echo "<option>No se ha encontrado Datos.</option>";
    }
    ?>
</select>

        <br>
        <div class="row">
    <div class="col-md-6">
        <label class="form-label">Desde</label>
        <input name="inicio" value="<?php echo isset($_SESSION['inicio']) ? $_SESSION['inicio'] : date('Y-m-d'); ?>" type="date" value="<?php echo date('Y-m-d')?>" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Hasta</label>
        <input name="fin" type="Date" value="<?php echo isset($_SESSION['fin']) ? $_SESSION['fin'] : date('Y-m-d'); ?>" class="form-control"required>
    </div>
</div>
        <div class="form-group">
            <br>
            <center><input type="submit" name="buscar" class="btn btn-primary" style="float:right;" value="Buscar"></center><br><br>
        </div>
    </form>

    <form action="" method="POST">
        <!-- Campos del formulario para mostrar los datos del empleado -->
        <center><label for="usuario">Cargo:</label></center>
        <input class="form-control" type="text" id="cargo" name="cargo" value="<?php echo $cargo ?? ""; ?>" maxlength="100" readonly><br>

        <center><label for="usuario">Sueldo Mensual</label></center>
        <input class="form-control" type="text" id="sueldo_bruto" name="sueldo_bruto" value="<?php echo $sueldo_mensual ?? ""; ?>" maxlength="10" readonly><br>

        <center><label for="usuario">Asignacion de Bonos Total:</label></center>
        <input class="form-control" type="text" id="asignacion_total" name="asignacion_total" value="<?php echo $asignacion_total ?? ""; ?>" maxlength="10" readonly><br>

        <center><label for="usuario">Deducciones:</label></center>
        <input class="form-control" type="text" id="deducciones" name="deducciones" value="<?php echo $porcentaje_deduccion ?? ""; ?>" maxlength="10" readonly><br>

        <center><label for="usuario">Total a Deducir:</label></center>
        <input class="form-control" type="text" id="total_deducir" name="total_deducir" value="<?php echo $total_deducir ?? ""; ?>" maxlength="10" readonly><br>

        <?php
        if (isset($datosEmpleado)) {
            $gananciames = $asignacion_total + $ganancias_mes - $total_deducir ;
        }
         
        ?>
        <center><label for="usuario">Sueldo Neto:</label></center>
        <input class="form-control" type="text" id="sueldo_neto" name="sueldo_neto" value="<?php echo $gananciames ?? ""; ?>" maxlength="10" readonly><br>

        <div class="form-group">
            <br>
        <input class="form-control" type="hidden" id="cedula" name="cedula" value="<?php echo $empleado['cedula'] ?? ""; ?>" maxlength="10" readonly><br>
        <input type="hidden" name="fecha_inicio" value="<?php echo $fecha_inicio ?? "";; ?>">
        <input type="hidden" name="fecha_fin" value="<?php echo $fecha_fin ?? ""; ?>">
            <center><input type="submit" name="insertar" class="btn btn-primary" style="float:right;" value="Registrar"></center>
        </div>
    </form>
</div>

</body>
</html>
