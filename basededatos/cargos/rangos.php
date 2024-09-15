<?php
class cargos
{

    private $conexion;
    private $conn; 

    public function __construct()
    {
        $this->conexion = new conexion();
    }


    public function delete($id)
    {
        try {
            $conn = $this->conexion->conectar();
         
            // Preparar la consulta SQL para eliminar el registro
            $query = "DELETE FROM cargos WHERE id_cargos = ?";
            
            // Preparar la declaración
            $stmt = $conn->prepare($query);
            
            // Vincular parámetros
            $stmt->bind_param("i", $id);
            
            // Ejecutar la consulta
            if ($stmt->execute()) {
                // La eliminación fue exitosa
                return true;
            } else {
                // La eliminación falló
                return false;
            }
        } catch (Exception $e) {
            // Capturar y manejar cualquier excepción que ocurra
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function delete_departamento($id)
    {
        try {
            $conn = $this->conexion->conectar();
         
            // Preparar la consulta SQL para eliminar el registro
            $query = "DELETE FROM departamentos WHERE id_departament = ?";
            
            // Preparar la declaración
            $stmt = $conn->prepare($query);
            
            // Vincular parámetros
            $stmt->bind_param("i", $id);
            
            // Ejecutar la consulta
            if ($stmt->execute()) {
                // La eliminación fue exitosa
                return true;
            } else {
                // La eliminación falló
                return false;
            }
        } catch (Exception $e) {
            // Capturar y manejar cualquier excepción que ocurra
            echo "Error: " . $e->getMessage();
            return false;
        }
    }



    public function cargos()
{
    $conn = $this->conexion->conectar();
    $query = "SELECT a.*, b.* FROM cargos AS a INNER JOIN departamentos AS b ON a.id_departamento = b.id_departament";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $this->conexion->desconectar($conn); 
        return $data;
    } else {
        // No hay registros encontrados
        $this->conexion->desconectar($conn); 
        return array();
    }
}

public function departamento()
{
    $conn = $this->conexion->conectar();
    $query = "SELECT * FROM departamentos";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $this->conexion->desconectar($conn); 
        return $data;
    } else {
        // No hay registros encontrados
        $this->conexion->desconectar($conn); 
        return array();
    }
}

public function busqueda_departamento($id)
{
    $conn = $this->conexion->conectar();
    
    // Prepare and bind the statement
    $query = "SELECT * FROM departamentos WHERE id_departament=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    
    // Execute the statement
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Fetch data
        $data = $result->fetch_assoc();
        $stmt->close();
        $this->conexion->desconectar($conn);
        return $data;
    } else {
        // No records found
        $stmt->close();
        $this->conexion->desconectar($conn);
        return array();
    }
}




// Incluye el script de SweetAlert al principio del archivo


public function cargoExiste()
{
    // Verificar si se ha enviado la solicitud POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $conn = $this->conexion->conectar();
        $cargo = $conn->real_escape_string($_POST['cargo']);
        $departamento = $conn->real_escape_string($_POST['departamento']);
        $monto = $conn->real_escape_string($_POST['monto']);

        // Consultar si el cargo ya existe en la base de datos
        $query = "SELECT * FROM cargos WHERE nombre_cargos=?";
        $statement = $conn->prepare($query);
        
        if ($statement) {
            $statement->bind_param("s", $cargo);
            $statement->execute();
            $result = $statement->get_result();
            
            // Verificar si el cargo ya existe
            if ($result->num_rows > 0) {
                // El cargo ya existe en la base de datos, no es necesario insertarlo
                return false;
            } else {
                // El cargo no existe, proceder con la inserción
                $insertQuery = "INSERT INTO cargos (nombre_cargos, id_departamento, monto_a_gana) VALUES (?, ?, ?)";
                $insertStatement = $conn->prepare($insertQuery);
                if ($insertStatement) {
                    $insertStatement->bind_param("sii", $cargo, $departamento, $monto);
                    if ($insertStatement->execute()) {
                        // La inserción fue exitosa
                        return true;
                    } else {
                        // Error al insertar el cargo
                        throw new Exception('Error al insertar el cargo en la base de datos');
                    }
                } else {
                    // Error al preparar la consulta de inserción
                    throw new Exception('Error al preparar la consulta de inserción');
                }
            }
        } else {
            // Error al preparar la consulta de verificación de existencia del cargo
            throw new Exception('Error al verificar la existencia del cargo');
        }
    } else {
        // La solicitud no es de tipo POST
        throw new Exception('La solicitud no es de tipo POST');
    }
}


public function departamentoExiste()
{
    // Verificar si se ha enviado la solicitud POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $conn = $this->conexion->conectar();
        $cargo = $conn->real_escape_string($_POST['cargo']);

        // Consultar si el cargo ya existe en la base de datos
        $query = "SELECT * FROM departamentos WHERE nombre_departament=?";
        $statement = $conn->prepare($query);
        
        if ($statement) {
            $statement->bind_param("s", $cargo);
            $statement->execute();
            $result = $statement->get_result();
            
            // Verificar si el cargo ya existe
            if ($result->num_rows > 0) {
                // El cargo ya existe en la base de datos, no es necesario insertarlo
                return false;
            } else {
                // El cargo no existe, proceder con la inserción
                $insertQuery = "INSERT INTO departamentos (nombre_departament) VALUES (?)";
                $insertStatement = $conn->prepare($insertQuery);
                if ($insertStatement) {
                    $insertStatement->bind_param("s", $cargo);
                    if ($insertStatement->execute()) {
                        // La inserción fue exitosa
                        return true;
                    } else {
                        // Error al insertar el cargo
                        throw new Exception('Error al insertar el cargo en la base de datos');
                    }
                } else {
                    // Error al preparar la consulta de inserción
                    throw new Exception('Error al preparar la consulta de inserción');
                }
            }
        } else {
            // Error al preparar la consulta de verificación de existencia del cargo
            throw new Exception('Error al verificar la existencia del cargo');
        }
    } else {
        // La solicitud no es de tipo POST
        throw new Exception('La solicitud no es de tipo POST');
    }
}


public function actualizarDepartamento()

{  
    $conn = $this->conexion->conectar();
    $id = $conn->real_escape_string($_POST['id']);
    // Verificar si se ha enviado la solicitud POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $conn = $this->conexion->conectar();
        $id = $conn->real_escape_string($_POST['id']);
        $cargo = $conn->real_escape_string($_POST['cargo']);

        // Consultar si el cargo ya existe en la base de datos
        $query = "SELECT * FROM departamentos WHERE nombre_departament=? AND id_departament != ?";
        $statement = $conn->prepare($query);
        
        if ($statement) {
            $statement->bind_param("si", $cargo, $id);
            $statement->execute();
            $result = $statement->get_result();
            
            // Verificar si el cargo ya existe
            if ($result->num_rows > 0) {
                // El cargo ya existe en la base de datos, no es posible actualizar
                header("Location: editar_departamento.php?mensaje=cargoyaexiste&editId=$id");
                exit();
            } else {
                // El cargo no existe, proceder con la actualización
                $updateQuery = "UPDATE departamentos SET nombre_departament=? WHERE id_departament=?";
                $updateStatement = $conn->prepare($updateQuery);
                if ($updateStatement) {
                    $updateStatement->bind_param("si", $cargo, $id);
                    if ($updateStatement->execute()) {
                        // La actualización fue exitosa
                        header("Location: editar_departamento.php?mensaje=correcto&editId=$id");
                        exit();
                    } else {
                        // Error al actualizar el departamento
                        header("Location: editar_departamento.php?mensaje=Erroralactualizar&editId=$id");
                        exit();
                    }
                } else {
                    // Error al preparar la consulta de actualización
                    header("Location: editar_departamento.php?mensaje=Error al preparar la consulta de actualización&editId=$id");
                    exit();
                }
            }
        } else {
            // Error al preparar la consulta de verificación de existencia del cargo
            header("Location: editar_departamento.php?mensaje=Error al verificar la existencia del departamento&editId=$id");
            exit();
        }
    } else {
        // La solicitud no es de tipo POST
        header("Location: editar_departamento.php?mensaje=post&editId=$id");
        exit();
    }
}





public function busqueda_cargos($id)
{
    $conn = $this->conexion->conectar();
    $query = "SELECT * FROM cargos WHERE id_cargos = '$id' "; // Agregamos la cláusula LIMIT 1
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc(); // En lugar de iterar sobre los resultados, obtenemos solo el primer resultado
        $this->conexion->desconectar($conn); 
        return $data;
    } else {
        // No hay registros encontrados
        $this->conexion->desconectar($conn); 
        return array();
    }
}


public function editarcargo()
{
    // Extraer variables POST
    extract($_POST);

    // Verificar si los campos necesarios están presentes
    if (empty($cargo) || empty($id) || empty($departamento) || empty($monto)) {
        header("Location: edit_cargos.php?msg=error_missing_fields&editId=$id");
        exit(); // Terminar la ejecución del script
    }

    // Conexión a la base de datos
    $conn = $this->conexion->conectar();

    // Verificar la conexión
    if (!$conn) {
        header("Location: edit_cargos.php?msg=error_database_connection&editId=$id");
        exit(); // Terminar la ejecución del script
    }

    // Consulta SQL para verificar si el cargo ya existe
    $veri = "SELECT * FROM cargos WHERE nombre_cargos = '$cargo'";
    $resul = $conn->query($veri);
    if ($resul->num_rows > 0) {
        $query = "UPDATE cargos SET id_departamento = ?, monto_a_gana = ?, estado = ? WHERE id_cargos = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iisi", $departamento, $monto, $estatus, $id);
    } else {
        $query = "UPDATE cargos SET nombre_cargos = ?, id_departamento = ?, monto_a_gana = ?, estado = ? WHERE id_cargos = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("siisi", $cargo, $departamento, $monto, $estatus, $id);
    }

    // Ejecutar la consulta preparada
    if ($stmt->execute()) {
        // Redireccionar con mensaje de éxito
        header("Location: edit_cargos.php?msg=update&editId=$id");
        exit(); // Terminar la ejecución del script
    } else {
        // Redireccionar con mensaje de error
        header("Location: edit_cargos.php?msg=error_update&editId=$id");
        exit(); // Terminar la ejecución del script
    }

    // Cerrar la conexión y liberar recursos
    $stmt->close();
    $conn->close();
}












}

?>