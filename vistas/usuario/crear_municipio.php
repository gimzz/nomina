<script src="../../assets/js/sweetalert2@11.js"></script>
<?php
require_once "../../basededatos/base.php";
require_once "../../basededatos/estadoYmunicipio/est_muni.php";
$est_muni = new est_muni();
$query = $est_muni->estados();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST);
    if (empty($municipios) || empty($estado)) {
        echo "
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'warning',
                title: '¡Alerta!',
                text: 'Los campos están vacíos.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar'
            });
        });
        </script>";
    } else {
        // Si el campo no está vacío, realizas la validación adicional
        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $municipios)) {
            echo "
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: '¡Alerta!',
                    text: 'El campo Municipio solo debe contener letras, espacios y acentuaciones.',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar'
                });
            });
            </script>";
        } else {
            $est_muni->insert_municipio();
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
    <title>Crear Municipio</title>
</head>
<body>
    <?php require_once "menu.php"; ?>

    <div class="card text-center" style="padding:15px;">
        <h4>Registrar Municipio</h4>
    </div><br> 

    <div class="container">
        <form id="formulario" action="crear_municipio.php" method="POST">
            <center><label for="clave">Nombre del nuevo Municipio</label></center>
            <input class="form-control" type="text" onkeyup="letras(this)"  id="municipios" name="municipios" ><br>

            <select id="estados" class="form-control" name="estado">
                <option selected>Seleccione un Estado</option>
                <?php
                if (isset($query)) {
                    foreach ($query as $fila) {
                        echo "<option value='".$fila['id_estado']."'>" . $fila['nombre_estado']."</option>";
                    }
                } else {
                    echo "No se ha definido la variable \$persona.";
                }
                ?>
            </select>
            
            <div class="form-group">
                <br>
                <center><button type="button" class="btn btn-primary" style="float:right;" onclick="validarYEnviarFormulario()">Registrar</button></center>
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
