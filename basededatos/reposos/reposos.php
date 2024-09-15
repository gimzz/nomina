<?php
class reposo
{
    
    private $conexion;
    
   
     public function __construct()
       {
        $this->conexion = new conexion();
       }
       
       public function delete($id)
       {
           try {
               $conn = $this->conexion->conectar();
            
               // Preparar la consulta SQL para eliminar el registro
               $query = "DELETE FROM reposo_empleado WHERE id_reposo = ?";
               
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


       public function busqueda_reposo()
       {
           try {
               $conn = $this->conexion->conectar();
               
               // Preparar la consulta SQL para buscar los reposos
               $query = "SELECT a.*, b.*, c.* FROM empleado AS a 
                         INNER JOIN reposo_empleado AS b ON a.cedula = b.cedula_reposo 
                         INNER JOIN cargos AS c ON c.id_cargos = a.id_cargos WHERE b.estatus = 1";
               
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
           $con = $this->conexion->conectar();
           extract($_POST);
       
           // Validar y sanitizar los datos de entrada si es necesario
       
           // Verificar si ya existe un reposo para la cédula y la fecha final proporcionadas
           $verificar = "SELECT * FROM reposo_empleado WHERE cedula_reposo = '$roles' AND fecha_final = '$fecha_final'";
           $result = $con->query($verificar);
           
           if ($result && $result->num_rows > 0) {
               // Ya existe un reposo para la cédula y la fecha final, devolver false
               return false;
           }

           if ( !preg_match("/^[0-9]+$/", $roles)) 
           {
                header('Location: crear_reposo.php?msg4=danger');
           }
       
           // Intentar insertar el nuevo reposo
           $reposo = "INSERT INTO reposo_empleado (cedula_reposo, fecha_final, fecha_inicio) VALUES ('$roles', '$fecha_final', '$fecha_inicio')";
           $smt = $con->query($reposo);
           
           // Verificar si la inserción fue exitosa
           if ($smt) {
               // Inserción exitosa, devolver true
               return true;
           } else {
               // Fallo en la inserción, manejar el error apropiadamente
               // También podrías registrar el error para futuras referencias
              echo '<script>window.location.href = "crear_reposo.php?msg2=danger";</script>';
              exit;
           }
       }
       


       public function personas()
      {
            $con = $this->conexion->conectar();
          $query = "SELECT * FROM empleado";
          $result = $con->query($query);
        if ($result->num_rows > 0) {
          $data = array();
          while ($row = $result->fetch_assoc()) {
                 $data[] = $row;
          }
         return $data;
          }else
          {  $alerta1 = "<script>alert('No hay registros encontrados');</script>";
             echo $alerta1;
          }
      }

       
      

      



}







?>