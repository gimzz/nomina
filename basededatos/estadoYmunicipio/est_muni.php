<?php
class est_muni
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
               $query = "DELETE FROM estado WHERE id_estado = ?";
               
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


       public function delete_municipio($id)
       {
           try {
               $conn = $this->conexion->conectar();
            
               // Preparar la consulta SQL para eliminar el registro
               $query = "DELETE FROM municipio WHERE id_municipio = ?";
               
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

       public function estados()
       {
         $conn = $this->conexion->conectar();
           $query = "SELECT * FROM estado ";
           $result = $conn->query($query);
       if ($result->num_rows > 0) {
           $data = array();
           while ($row = $result->fetch_assoc()) {
                  $data[] = $row;
           }
          return $data;
           }else{
          echo "No hay registros encontrados";
           }
       }

       public function insert_estado()
       {
           // Establecer la conexión
           $conn = $this->conexion->conectar();
       
           // Extraer el valor del campo 'estado' del formulario
           $estado = isset($_POST['estado']) ? $conn->real_escape_string($_POST['estado']) : '';
       
           // Verificar si el campo está vacío
           if (empty($estado)) 
           {
               echo "
               <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
               <script>
               document.addEventListener('DOMContentLoaded', function() {
                   Swal.fire({
                       icon: 'warning',
                       title: '¡Alerta!',
                       text: 'El campo Estado está vacío.',
                       confirmButtonColor: '#3085d6',
                       confirmButtonText: 'Aceptar'
                   });
               });
               </script>";
               return false;
           } 
           else 
           {
               // Si el campo no está vacío, realizar la validación adicional
               if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $estado)) 
               {
                   echo "
                   <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                   <script>
                   document.addEventListener('DOMContentLoaded', function() {
                       Swal.fire({
                           icon: 'warning',
                           title: '¡Alerta!',
                           text: 'El campo Estado solo debe contener letras y espacios.',
                           confirmButtonColor: '#3085d6',
                           confirmButtonText: 'Aceptar'
                       });
                   });
                   </script>";
               } 
               else 
               {
                   // Realizar la consulta para verificar si el estado ya existe en la base de datos
                   $verifi = "SELECT * FROM estado WHERE nombre_estado ='$estado'";
                   $result = $conn->query($verifi);
       
                   // Verificar si hubo algún resultado (si ya existe el estado en la base de datos)
                   if ($result && $result->num_rows > 0) 
                   {
                       echo "
                       <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                       <script>
                       document.addEventListener('DOMContentLoaded', function() {
                           Swal.fire({
                               icon: 'warning',
                               title: '¡Alerta!',
                               text: 'El Estado ya Existe en la Base de Datos.',
                               confirmButtonColor: '#3085d6',
                               confirmButtonText: 'Aceptar'
                           });
                       });
                       </script>";
                   } 
                   else 
                   {
                       // Si no existe, insertar el estado en la base de datos
                       $insert_query = "INSERT INTO estado (nombre_estado) VALUES ('$estado')";
                       $insert_result = $conn->query($insert_query);
       
                       if ($insert_result) 
                       {
                           echo "
                           <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                           <script> 
                           document.addEventListener('DOMContentLoaded', function() {
                               Swal.fire({
                                   icon: 'success',
                                   title: 'Éxito',
                                   text: 'Estado insertado correctamente.',
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
                                   title: '¡Error!',
                                   text: 'Ocurrió un error al insertar el estado en la base de datos.',
                                   confirmButtonColor: '#3085d6',
                                   confirmButtonText: 'Aceptar'
                               });
                           });
                           </script>";
                           return false;
                       }
                   }
               }
           }
       }



       public function busqueda($id) {
        $conn = $this->conexion->conectar();
        
        // Consulta preparada para evitar inyección SQL
        $query = "SELECT * FROM estado WHERE id_estado = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Verificar si se encontraron registros
        if ($result->num_rows > 0) {
            // Retornar el estado encontrado
            return $result->fetch_assoc();
        } else {
            // Lanzar una excepción si no se encontraron registros
            throw new Exception("No se encontraron registros para el ID proporcionado");
        }
    }

    public function busqueda1($id) {
        $conn = $this->conexion->conectar();
        
        // Consulta preparada para evitar inyección SQL
        $query = "SELECT * FROM municipio WHERE id_municipio = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Verificar si se encontraron registros
        if ($result->num_rows > 0) {
            // Retornar el estado encontrado
            return $result->fetch_assoc();
        } else {
            // Lanzar una excepción si no se encontraron registros
            throw new Exception("No se encontraron registros para el ID proporcionado");
        }
    }


    public function update_estado() {
        $conn = $this->conexion->conectar();
        
        // Obtener los valores del formulario y validarlos
        $estado = isset($_POST['estado']) ? $_POST['estado'] : '';
        $ID = isset($_POST['estado1']) ? $_POST['estado1'] : '';
    
        // Verificar si los valores están vacíos
        if (empty($estado) || empty($ID)) {
            // Manejar el error y redirigir al usuario a algún lugar apropiado
            header("Location: editar_estado.php?msg=campos_vacios&editId=$ID");
            exit;
        }
    
        // Consulta preparada para verificar la existencia del estado
        $verificacion = "SELECT * FROM estado WHERE nombre_estado = ?";
        $stmt_verificacion = $conn->prepare($verificacion);
        $stmt_verificacion->bind_param("s", $estado);
        $stmt_verificacion->execute();
        $result_verificacion = $stmt_verificacion->get_result();
    
        // Verificar si el estado ya existe
        if ($result_verificacion->num_rows > 0) {
            // Manejar el caso de que el estado ya existe y redirigir al usuario
            header("Location: editar_estado.php?mgs=estado_existente&editId=$ID");
            exit;
        }
    
        // Consulta preparada para actualizar el estado
        $update_query = "UPDATE estado SET nombre_estado = ? WHERE id_estado = ?";
        $stmt_update = $conn->prepare($update_query);
        $stmt_update->bind_param("si", $estado, $ID);
        $stmt_update->execute();
    
        // Verificar si la actualización fue exitosa
        if ($stmt_update->affected_rows > 0) {
            // Redirigir al usuario con un mensaje de éxito
            header("Location: editar_estado.php?mgs=actualizacion_exitosa&editId=$ID");
            exit;
        } else {
            // Manejar el caso en que la actualización no tuvo ningún efecto
            header("Location: editar_estado.php?mgs=actualizacion_fallida&editId=$ID");
            exit;
        }
    }

    public function municipio()
    {
      $conn = $this->conexion->conectar();
        $query = "SELECT a.*, b.* FROM municipio AS a INNER JOIN estado AS b ON a.id_estado =b.id_estado ";
        $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
               $data[] = $row;
        }
       return $data;
        }else{
       echo "No hay registros encontrados";
        }
    }



    public function insert_municipio()
    {
        // Establecer la conexión
        $conn = $this->conexion->conectar();
    
        // Extraer el valor del campo 'estado' del formulario
        $municipio = isset($_POST['municipios']) ? $conn->real_escape_string($_POST['municipios']) : '';
        $estado = isset($_POST['estado']) ? $conn->real_escape_string($_POST['estado']) : '';
    
        // Verificar si el campo está vacío
        if (empty($estado)) 
        {
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: '¡Alerta!',
                    text: 'El campo estado está vacío Seleccione una opción .',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar'
                });
            });
            </script>";
            return false;
        } 
        else 
        {
            // Si el campo no está vacío, realizar la validación adicional
            if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $municipio)) 
            {
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'warning',
                        title: '¡Alerta!',
                        text: 'El campo Municipio solo debe contener letras y espacios.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar'
                    });
                });
                </script>";
            } 

            if (!preg_match('/^[0-9]+$/', $estado)) 
            {
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'warning',
                        title: '¡Alerta!',
                        text: 'El campo Estado esta vacio Seleccione una opcion.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar'
                    });
                });
                </script>";
            } 
            else 
            {
                // Realizar la consulta para verificar si el estado ya existe en la base de datos
                $verifi = "SELECT * FROM municipio WHERE nombre_municipio ='$municipio'";
                $result = $conn->query($verifi);
    
                // Verificar si hubo algún resultado (si ya existe el estado en la base de datos)
                if ($result && $result->num_rows > 0) 
                {
                    echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'warning',
                            title: '¡Alerta!',
                            text: 'El Municipio ya Existe en la Base de Datos.',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Aceptar'
                        });
                    });
                    </script>";
                } 
                else 
                {
                    // Si no existe, insertar el estado en la base de datos
                    $insert_query = "INSERT INTO municipio (id_estado,nombre_municipio) VALUES ('$estado','$municipio')";
                    $insert_result = $conn->query($insert_query);
    
                    if ($insert_result) 
                    {
                        echo "
                        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                        <script> 
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Éxito',
                                text: 'Municipio insertado correctamente.',
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
                                title: '¡Error!',
                                text: 'Ocurrió un error al insertar el municipio en la base de datos.',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Aceptar'
                            });
                        });
                        </script>";
                        return false;
                    }
                }
            }
        }
    }
    
    public function update_municipio() {
        $conn = $this->conexion->conectar();
        
        // Obtener los valores del formulario y validarlos
        $municipio = isset($_POST['municipios']) ? $_POST['municipios'] : '';
        $ID = isset($_POST['id']) ? $_POST['id'] : '';
        $estatus = isset($_POST['estatus']) ? $_POST['estatus'] : '';
        $estado = isset($_POST['estado']) ? $_POST['estado'] : '';
        
        // Verificar si los valores están vacíos
        if (empty($estado) || empty($ID) || empty($estatus) || empty($municipio)) {
            // Manejar el error y redirigir al usuario a algún lugar apropiado
            header("Location: editar_municipio.php?msg=campos_vacios&editId=$ID");
            exit;
        }
        
        // Consulta preparada para verificar la existencia del estado
        $verificacion = "SELECT * FROM municipio WHERE nombre_municipio = ?";
        $stmt_verificacion = $conn->prepare($verificacion);
        $stmt_verificacion->bind_param("s", $municipio);
        $stmt_verificacion->execute();
        $result_verificacion = $stmt_verificacion->get_result();
        
        // Verificar si el municipio ya existe
        if ($result_verificacion->num_rows > 0) {
            // Manejar el caso de que el municipio ya existe y redirigir al usuario
            $update_query = "UPDATE municipio SET id_estado = ?, estatus = ? WHERE id_municipio = ?";
            $stmt_update = $conn->prepare($update_query);
            $stmt_update->bind_param("isi", $estado, $estatus, $ID);
            $stmt_update->execute();
            header("Location: editar_municipio.php?mgs=municipio_existente&editId=$ID");
            exit;
        }
        
        // Consulta preparada para actualizar el municipio
        $update_query = "UPDATE municipio SET id_estado = ?, nombre_municipio = ?, estatus = ? WHERE id_municipio = ?";
        $stmt_update = $conn->prepare($update_query);
        $stmt_update->bind_param("issi", $estado, $municipio, $estatus, $ID);
        $stmt_update->execute();
        
        // Verificar si la actualización fue exitosa
        if ($stmt_update->affected_rows > 0) {
            // Redirigir al usuario con un mensaje de éxito
            header("Location: editar_municipio.php?mgs=actualizacion_exitosa&editId=$ID");
            exit;
        } else {
            // Manejar el caso en que la actualización no tuvo ningún efecto
            header("Location: editar_municipio.php?mgs=actualizacion_fallida&editId=$ID");
            exit;
        }
    }
    
    




}
?>