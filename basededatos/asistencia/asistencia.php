<?php
class asistencia_persona
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
               $query = "DELETE FROM asistencia WHERE id_asistencia = ?";
               
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


       public function busqueda()
       {
           try {
               $conn = $this->conn->conectar();
               
               // Preparar la consulta SQL para buscar los reposos
               $query = "SELECT a.*, b.*, c.* FROM empleado AS a 
                         INNER JOIN asistencia AS b ON a.cedula = b.cedula_empleado 
                         INNER JOIN cargos AS c ON c.id_cargos = a.id_cargos WHERE b.estado = 'Activo'";
               
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


       public function busqueda1($id)
       {
           try {
               $conn = $this->conn->conectar();
               
               // Preparar la consulta SQL para buscar los reposos
               $query = "SELECT a.*, b.*, c.* FROM empleado AS a 
                         INNER JOIN asistencia AS b ON a.cedula = b.cedula_empleado 
                         INNER JOIN cargos AS c ON c.id_cargos = a.id_cargos WHERE b.id_asistencia= '$id' AND b.estado = 'Activo'";
               
               // Ejecutar la consulta
               $result = $conn->query($query);
           
               // Verificar si la consulta se ejecutó correctamente
               if ($result && $result->num_rows > 0) {
                   // Inicializar un arreglo para almacenar los resultados
                   
                   // Recorrer todas las filas de resultados
                   $row = $result->fetch_assoc(); 
                     
                   // Devolver el arreglo de reposos
                   return $row;
               } else {
                   // No se encontraron resultados, devolver un arreglo vacío
                   return false;
               }
           } catch (Exception $e) {
               // Capturar y manejar cualquier excepción que ocurra
               echo "Error: " . $e->getMessage();
               return false;
           }
       }

       public function personas()
       {
             $con = $this->conn->conectar();
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

       public function registrar()
       {
           $roles = isset($_POST['roles']) ? $_POST['roles'] : '';
           $horaLlegada = isset($_POST['nombre']) ? $_POST['nombre'] : '';
           $horaSalida = isset($_POST['password']) ? $_POST['password'] : '';
           $fecha = isset($_POST['password1']) ? $_POST['password1'] : '';
       
           if (empty($roles) || empty($horaLlegada) || empty($horaSalida) || empty($fecha)) 
           {
               echo "<script>alert('Ups, ha ocurrido un error.');</script>";
               return false;
           }
       
           $con = $this->conn->conectar();
           $verifacion = "SELECT * FROM asistencia WHERE cedula_empleado='$roles' AND fecha_ingreso = '$fecha'";
           $consulta = $con->query($verifacion);
           if ($consulta->num_rows > 0) 
           {
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Ups',
                        text: 'El trabajador ya fue registrado el dia de hoy.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar'
                    });
                });
            </script>";
            return false;
           }
           else 
           {
               $insertar_data = "INSERT INTO asistencia(cedula_empleado, hora_llegada, hora_salida, fecha_ingreso)
               VALUES ('$roles','$horaLlegada','$horaSalida','$fecha')";
               $query = $con->query($insertar_data);
               if($query)
               {
                   echo "
                   <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                   <script>
                       document.addEventListener('DOMContentLoaded', function() {
                           Swal.fire({
                               icon: 'success',
                               title: 'Success',
                               text: 'Se ha registrado exitosamente.',
                               confirmButtonColor: '#3085d6',
                               confirmButtonText: 'Aceptar'
                           });
                       });
                   </script>";
                   return true;
               }
               else 
               {
                   echo "
                   <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                   <script>
                       document.addEventListener('DOMContentLoaded', function() {
                           Swal.fire({
                               icon: 'error',
                               title: 'Error',
                               text: 'Hubo un problema al registrar.',
                               confirmButtonColor: '#3085d6',
                               confirmButtonText: 'Aceptar'
                           });
                       });
                   </script>";
                   return false;
               }
           }
       }



       public function update()
       {
           $this->conn = $this->conn->conectar();
       
           // Validar y limpiar los datos de entrada
           $cedula = isset($_POST['nombre']) ? $this->conn->real_escape_string($_POST['nombre']) : '';
           $hora_salida = isset($_POST['password']) ? $this->conn->real_escape_string($_POST['password']) : '';
           $fecha_ingreso = isset($_POST['password1']) ? $this->conn->real_escape_string($_POST['password1']) : '';
           $id_asistencia = isset($_POST['id']) ? $this->conn->real_escape_string($_POST['id']) : '';
       
           // Verificar si se proporcionaron todos los datos necesarios
           if (!empty($cedula) && !empty($hora_salida) && !empty($fecha_ingreso) && !empty($id_asistencia)) {
               try {
                   // Actualizar la asistencia
                   $query1 = "UPDATE asistencia SET hora_llegada='$cedula', hora_salida='$hora_salida', fecha_ingreso='$fecha_ingreso' WHERE id_asistencia='$id_asistencia'";
                   $sql1 = $this->conn->query($query1);
       
                   // Verificar si la consulta se ejecutó correctamente y si se afectaron filas
                   if ($sql1 && $this->conn->affected_rows > 0) {
                       header("Location: editar_asistencia.php?msg=update&editId=$id_asistencia");
                      
                       exit();
                   } else {
                       // Redireccionar con un mensaje de error si no se actualizó ninguna fila
                       header("Location: editar_asistencia.php?msg=update_failed&editId=$id_asistencia");
                       exit();
                   }
               } catch (Exception $e) {
                   // Manejar cualquier excepción que ocurra
                   echo "Error: " . $e->getMessage();
                   return false;
               }
           } else {
               // Redireccionar con un mensaje de error si faltan datos
               header("Location: editar_asistencia.php?msg=missing_data&editId=$id_asistencia");
               exit();
           }
       }
       





       
      




}







?>