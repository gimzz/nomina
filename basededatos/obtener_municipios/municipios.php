<?php
require "../base.php";
$con = new conexion();
$conn = $con->conectar();

$estado_id = $_POST['estado_id'];

error_log("ID del estado recibido: " . $estado_id); // Agregar mensaje de log

$query = "SELECT * FROM municipio WHERE id_estado = '$estado_id' AND estatus = 'Activo'";
error_log("Consulta SQL: " . $query); // Agregar mensaje de log

$result = $conn->query($query);

if ($result) {
    if ($result->num_rows > 0) {
        $municipios = array();
        while ($row = $result->fetch_assoc()) {
            $municipios[] = $row;
        }
        // Devolver los resultados en formato JSON
        header('Content-Type: application/json');
        echo json_encode($municipios);
    } else {
        // No hay registros encontrados, devolver un array vacío en JSON
        header('Content-Type: application/json');
        echo json_encode([]);
    }
} else {
    // Error en la consulta SQL
    error_log("Error en la consulta SQL: " . $conn->error); // Agregar mensaje de log
}

// Cerrar la conexión a la base de datos
$con->desconectar($conn);
?>
