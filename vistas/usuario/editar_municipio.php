<script src="../../assets/js/sweetalert2@11.js"></script>
<?php
require_once "../../basededatos/base.php";
require_once "../../basededatos/estadoYmunicipio/est_muni.php";

function mostrarAlerta($icono, $titulo, $mensaje) {
    echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: '$icono',
                    title: '$titulo',
                    text: '$mensaje',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar'
                });
            });
        </script>";
}

if(isset($_GET['mgs'])) {
    $mensaje = $_GET['mgs'];
    switch($mensaje) {
        case "campos_vacios":
            mostrarAlerta('warning', 'Error', 'Debes llenar todos los campos');
            break;
        case "municipio_existente":
            mostrarAlerta('success', 'Ups', 'El municipio ya existe solo se actualizo el estado y el estatus');
            break;
        case "actualizacion_exitosa":
            mostrarAlerta('success', '¡Éxito!', 'Actualización Exitosa');
            break;
        case "actualizacion_fallida":
            mostrarAlerta('warning', 'Ups', 'No se pudo actualizar');
            break;
        default:
            // Manejar otros casos si es necesario
            break;
    }
}

$est_muni = new est_muni();
$query = $est_muni->estados();

if(isset($_GET['editId']) && !empty($_GET['editId'])) {
    $deleteId = $_GET['editId'];
    $municipio = $est_muni->busqueda1($deleteId); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST);
    if (empty($municipios) || empty($estado) || empty($estatus)) {
        header("Location: editar_municipio.php?msg=campos_vacios&editId=$ID");
        exit;
    } else {
        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $municipios)) {
            header("Location: editar_municipio.php?msg=municipio_invalido&editId=$ID");
            exit;
        } else {
            $est_muni->update_municipio();
        }
    }
}
?>
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
    <!-- Incluir SweetAlert -->
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <title>Editar Municipio</title>
</head>
<body>
    <?php require_once "menu.php"; ?>

    <div class="card text-center" style="padding:15px;">
        <h4>Editar Municipio</h4>
    </div><br> 

    <div class="container">
        <form id="formulario" action="editar_municipio.php" method="POST">
            <center><label for="clave">Nombre del nuevo Municipio</label></center>
            <input class="form-control" type="text" onkeyup="letras(this)" id="municipios" name="municipios" value="<?php echo $municipio['nombre_municipio']; ?>">
            <br>
            <center><label for="clave">Seleccione un Estado</label></center>
            <select id="estados" class="form-control" name="estado">
                <option selected>Seleccione un Estado</option>
                <?php
                if (isset($query)) {
                    foreach ($query as $fila) {
                           // Verificar si la persona tiene este estado
                if ($municipio['id_estado'] == $fila['id_estado']) {
                    $cond = "selected=selected";
                } else {
                    $cond = "";  
                }
                        echo "<option value='".$fila['id_estado']."'$cond>" . $fila['nombre_estado']."</option>";
                    }
                } else {
                    echo "No se ha definido los estados";
                }
                ?>
            </select>

            <br>
            <center><label for="clave">Seleccione un estatus</label></center>
            <select id="estatus" class="form-control" name="estatus">
                <option disabled>Seleccione un Estatus</option>
                <option value="Activo" <?php if ($municipio['estatus'] == 'Activo') echo 'selected'; ?>>Activo</option>
                <option value="Inactivo" <?php if ($municipio['estatus'] == 'Inactivo') echo 'selected'; ?>>Inactivo</option>
            </select>
            <input type="hidden" name="id" value="<?php echo $municipio['id_municipio']; ?>">
            
            <div class="form-group">
                <br>
                <center><button type="button" class="btn btn-primary" style="float:right;" onclick="validarYEnviarFormulario()">Actualizar</button></center>
            </div>
        </form>
    </div>

    <script>
        function letras(input) {
            var regex = /[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/gi;
            input.value = input.value.replace(regex, "");
        }

        function validarFormulario() {
            var municipios = document.getElementById("municipios").value;
            var estatus = document.getElementById("estatus").value;

            // Verificar que el campo no esté vacío
            if (municipios === "") {
                Swal.fire("Debes llenar el campo del nombre del Municipio");
                return false;
            }

            // Verificar longitud del municipio
            if (municipios.length < 3 || municipios.length > 30) {
                Swal.fire("El municipio debe tener entre 3 y 30 caracteres");
                return false;
            }

            // Verificar que solo contenga letras
            if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(municipios)) {
                Swal.fire("El municipio solo debe contener letras y espacios");
                return false;
            }

            if (estatus === "") {
                Swal.fire("Debes Seleccionar una Opción");
                return false;
            }

            if (!/^[a-zA-Z]+$/.test(estatus)) {
                Swal.fire("El municipio solo debe contener letras y espacios");
                return false;
            }

            return true; // Devuelve true si la validación es exitosa
        }

        function validarYEnviarFormulario() {
            if (validarFormulario()) {
                document.getElementById("formulario").submit();
            }
        }
    </script>
</body>
</html>

