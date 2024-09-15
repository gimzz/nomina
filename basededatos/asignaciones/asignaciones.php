<?php
class asignacion
{
    private $conn;

    public function __construct()
    {
     $this->conn = new conexion();
    }

    public function delete($id)
    {
        try {
            $conn = $this->conn->conectar();
         
            // Preparar la consulta SQL para eliminar el registro
            $query = "DELETE FROM asignaciones WHERE id_asignacion = ?";
            
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


    public function busqueda_asignaciones()
    {
        try {
            $conn = $this->conn->conectar();
            
            // Preparar la consulta SQL para buscar los reposos
            $query = "SELECT a.*, b.nombre_cargos FROM asignaciones AS a 
            INNER JOIN cargos AS b ON b.id_cargos = a.id_cargos ";
            
            // Ejecutar la consulta
            $result = $conn->query($query);
        
            // Verificar si la consulta se ejecutó correctamente
            if ($result && $result->num_rows > 0) {
                // Inicializar un arreglo para almacenar los resultados
                $reposos = array();
                
                // Recorrer todas las filas de resultados
                while ($row = $result->fetch_assoc()) {
                    // Agregar cada fila al arreglo de reposos
                    $reposos[] = $row;
                }
                
                // Devolver el arreglo de reposos
                return $reposos;
            } else {
                // No se encontraron resultados, devolver un arreglo vacío
                return array();
            }
        } catch (Exception $e) {
            // Capturar y manejar cualquier excepción que ocurra
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function busqueda_asignacion($id)
    {
        try {
            $conn = $this->conn->conectar();
            
            // Preparar la consulta SQL para buscar los reposos
            $query = "SELECT a.*, b.nombre_cargos FROM asignaciones AS a 
            INNER JOIN cargos AS b ON b.id_cargos = a.id_cargos WHERE a.id_asignacion='$id'";
            
            // Ejecutar la consulta
            $result = $conn->query($query);
        
            // Verificar si la consulta se ejecutó correctamente
            if ($result && $result->num_rows > 0) {
                // Inicializar un arreglo para almacenar los resultados
                $reposos = array();
                
                // Recorrer todas las filas de resultados
                while ($row = $result->fetch_assoc()) {
                    // Agregar cada fila al arreglo de reposos
                    $reposos[] = $row;
                }
                
                // Devolver el arreglo de reposos
                return $reposos;
            } else {
                // No se encontraron resultados, devolver un arreglo vacío
                return array();
            }
        } catch (Exception $e) {
            // Capturar y manejar cualquier excepción que ocurra
            echo "Error: " . $e->getMessage();
            return false;
        }
    }



    public function cargos()
    {
        try {
            $conn = $this->conn->conectar();
            
            // Preparar la consulta SQL para buscar los reposos
            $query = "SELECT * FROM cargos ";
            
            // Ejecutar la consulta
            $result = $conn->query($query);
        
            // Verificar si la consulta se ejecutó correctamente
            if ($result && $result->num_rows > 0) {
                // Inicializar un arreglo para almacenar los resultados
                $reposos = array();
                
                // Recorrer todas las filas de resultados
                while ($row = $result->fetch_assoc()) {
                    // Agregar cada fila al arreglo de reposos
                    $reposos[] = $row;
                }
                
                // Devolver el arreglo de reposos
                return $reposos;
            } else {
                // No se encontraron resultados, devolver un arreglo vacío
                return array();
            }
        } catch (Exception $e) {
            // Capturar y manejar cualquier excepción que ocurra
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function agregar()
    {    
        $con = $this->conn->conectar();
        extract($_POST);

        $verificar = "SELECT * FROM asignaciones WHERE tipo_asignacion = '$fecha_inicio' ";
        $result = $con->query($verificar);
        
        if ($result && $result->num_rows > 0) {
            // Ya existe un reposo para la cédula y la fecha final, devolver false
            return false;
        }

        if ( !preg_match("/^[0-9]+$/", $roles)) 
        {
             header('Location: crear_asignaciones.php?msg=danger');
        }
    
        
        $reposo = "INSERT INTO asignaciones (tipo_asignacion, valor_asignacion, id_cargos) VALUES ('$fecha_inicio','$fecha_final','$roles')";
        $smt = $con->query($reposo);
        
        // Verificar si la inserción fue exitosa
        if ($smt) {
            // Inserción exitosa, devolver true
            return true;
        } else {
            // Fallo en la inserción, manejar el error apropiadamente
            // También podrías registrar el error para futuras referencias
           echo '<script>window.location.href = "crear_asignacion.php?msg=dangerers";</script>';
           exit;
        }
    }

    public function editar()
    {    
        $con = $this->conn->conectar();
        extract($_POST);

        $verificar = "SELECT * FROM asignaciones WHERE tipo_asignacion = '$fecha_inicio' ";
        $result = $con->query($verificar);
        
        if ($result && $result->num_rows > 0) {
            // Ya existe un reposo para la cédula y la fecha final, devolver false
            $reposo = "UPDATE asignaciones SET 
            valor_asignacion='$fecha_final',id_cargos='$roles'  
            WHERE id_asignacion ='$id'";
            $smt = $con->query($reposo);
            header("Location:editar_asignaciones.php?mgs=update&editId=$id");
            exit;
        }

        if ( !preg_match("/^[0-9]+$/", $roles)) 
        {
             header('Location: editar_asignaciones.php?msg=danger');
        }
    
        
        $reposo = "UPDATE asignaciones SET 
        tipo_asignacion='$fecha_inicio', valor_asignacion='$fecha_final',id_cargos='$roles'  
        WHERE id_asignacion ='$id'";
        $smt = $con->query($reposo);
        
        // Verificar si la inserción fue exitosa
        if ($smt) {
            header("Location:editar_asignaciones.php?mgs=update&editId=$id");
            exit;
        } else {
            // Fallo en la inserción, manejar el error apropiadamente
            // También podrías registrar el error para futuras referencias
           echo '<script>window.location.href = "editar_asignacion.php?msg=dangerers";</script>';
           exit;
        }
    }




}
?>