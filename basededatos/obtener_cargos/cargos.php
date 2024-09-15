<?php
require "../base.php";
$con = new conexion();
$conn = $con->conectar();

// Verificar si se recibió el ID del departamento por POST
// Verificar si se recibió el ID del departamento por POST
// Verificar si se recibió el ID del departamento por POST
if(isset($_POST['departamento_id'])) { // Cambiar estado_id por departamento_id
    $departamento_id = $_POST['departamento_id']; // Cambiar estado_id por departamento_id

    // Consulta preparada para obtener los cargos del departamento seleccionado
    $query = "SELECT * FROM cargos WHERE id_departamento = ? AND estado = 'Activo'";
    $statement = $conn->prepare($query);
    $statement->bind_param("i", $departamento_id); // Cambiar estado_id por departamento_id
    $statement->execute();
    $result = $statement->get_result();

    // Verificar si se obtuvieron resultados de la consulta
    if ($result) {
        if ($result->num_rows > 0) {
            $cargos = array();
            while ($row = $result->fetch_assoc()) {
                $cargos[] = $row;
            }
            // Devolver los resultados en formato JSON
            header('Content-Type: application/json');
            echo json_encode($cargos);
        } else {
            // No se encontraron registros, devolver un array vacío en JSON
            header('Content-Type: application/json');
            echo json_encode([]);
        }
    } else {
        // Error en la consulta SQL, devolver un mensaje de error en JSON
        header('Content-Type: application/json');
        echo json_encode(["error" => "Error en la consulta SQL"]);
    }

    // Cerrar la declaración y la conexión a la base de datos
    $statement->close();
    $con->desconectar($conn);
} else {
    // Si no se recibió el ID del departamento, devolver un mensaje de error en JSON
    header('Content-Type: application/json');
    echo json_encode(["error" => "ID de departamento no recibido"]);
}

?>
