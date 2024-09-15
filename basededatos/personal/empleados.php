<?php
class trabajador
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new conexion();
    }

    public function consultar_datos($cedula)
    {
        $conn = $this->conexion->conectar();
    
        $sql = "SELECT a.*, b.*, c.* FROM empleado AS a INNER JOIN usuario AS b ON b.cedula = a.cedula   
                INNER JOIN municipio  AS c ON c.id_municipio = a.municipio WHERE a.cedula = '$cedula'";
    
        $results = $conn->query($sql);
        if (!$results) {
          header('Location: inicio.php?msg2=danger');
          exit;
        }
    
        if ($results->num_rows === 0) {
          header('Location: inicio.php?msg1=danger');
          exit;
        }
    
        $user = $results->fetch_assoc();

        $this->conexion->desconectar($conn);
        return $user;
    }

    public function estados()
    {
      $conn = $this->conexion->conectar();
        $query = "SELECT * FROM estado WHERE Estatus = 'Activo' ";
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

    public function deduccion1()
{
    $conn = $this->conexion->conectar();
    $query = "SELECT * FROM deducciones";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        $data = $result->fetch_all(MYSQLI_ASSOC);
        return $data;
    } else {
        echo "No hay registros encontrados";
        return null;
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
          {  
            echo" ";
          }
      }

      public function obtenerEmpleadoPorCedula($cedula, $fechaInicio, $fechaFin)
      {
          $con = $this->conexion->conectar();
          $query = "SELECT 
          e.*, 
          c.nombre_cargos, 
          c.monto_a_gana, 
          GROUP_CONCAT(DISTINCT a.valor_asignacion ORDER BY a.valor_asignacion DESC) AS valores_asignacion,
          GROUP_CONCAT(DISTINCT a.tipo_asignacion ORDER BY a.valor_asignacion DESC) AS tipos_asignacion,
          COUNT(DISTINCT asistencia.fecha_ingreso) AS asistencias_mes
      FROM 
          empleado e
      INNER JOIN 
          cargos c ON e.id_cargos = c.id_cargos
      INNER JOIN 
          asignaciones a ON c.id_cargos = a.id_cargos
      LEFT JOIN 
          asistencia ON e.cedula = asistencia.cedula_empleado
      WHERE 
          e.cedula = '$cedula'
          AND asistencia.fecha_ingreso BETWEEN '$fechaInicio' AND '$fechaFin'
      GROUP BY 
          e.id_empleado, c.id_cargos
      ";
      
          $result = $con->query($query);
      
          if ($result->num_rows > 0) {
              $data = array();
              while ($row = $result->fetch_assoc()) {
                  $data[] = $row;
              }
              return $data;
          } else {
              return null;
          }
      }

      public function insertarDatosEnTabla()
{
    $con = $this->conexion->conectar();
    extract($_POST);
    // Consulta para obtener el último ID de la tabla nomina
    $verifi = "SELECT MAX(id_nomina) AS max_id FROM nomina";
    $result = $con->query($verifi);

    if ($result->num_rows > 0) {
        // Si hay filas en el resultado, obtenemos el valor de id_nomina
        $row = $result->fetch_assoc();
        $id_nomina = $row['max_id'] + 1; // Incrementamos el ID en 1 para obtener el siguiente
    } else {
        // Si no hay filas, asignamos 1 como el primer ID
        $id_nomina = 1;
    }

    $insertar = "INSERT INTO nomina(id_nomina,cedula_empleado,fecha_inicio,fecha_fin,total_pago)
     VALUES('$id_nomina','$cedula','$fecha_inicio','$fecha_fin','$sueldo_neto');";
      $query = $con->query($insertar);
      $fecha = date('Y-m-d');
      $asignacion = "INSERT INTO asignaciones_empleados(valor_asignacion, cedula_empleado, fecha_asignacion, id_nomina) 
      VALUES('$asignacion_total','$cedula','$fecha','$id_nomina')";
      $query1 = $con->query($asignacion);

      $deduccion="INSERT INTO deducciones_empleado(cedula_empleado,valor_de_deduccion,id_nomina) VALUES('$cedula','$total_deducir','$id_nomina')";
      $query2 =$con->query($deduccion);

        if ($query && $query1 && $query2) 
        {
          return true;
        }
        else 
        {
          return false; 
        }


    // Aquí puedes usar el $id_nomina para insertar el nuevo registro en la tabla
}

      
      
      


      public function departament()
      {
            $con = $this->conexion->conectar();
          $query = "SELECT * FROM departamentos";
          $result = $con->query($query);
        if ($result->num_rows > 0) {
          $data = array();
          while ($row = $result->fetch_assoc()) {
                 $data[] = $row;
          }
         return $data;
          }else
          {  
            echo" ";
          }
      }

      public function busqueda_empleado($id)
      {
            $con = $this->conexion->conectar();
          $query = "SELECT a.*, b.*, c.* FROM empleado AS a INNER JOIN cargos AS b ON b.id_cargos=a.id_cargos
          INNER JOIN departamentos AS c ON b.id_departamento=c.id_departament WHERE a.id_empleado='$id'";
          $result = $con->query($query);
        if ($result->num_rows > 0) {
          $data = array();
          while ($row = $result->fetch_assoc()) {
                 $data[] = $row;
          }
         return $data;
          }else
          {  
            echo" ";
          }
      }

      public function cargos()
{
    $conn = $this->conexion->conectar();
    $query = "SELECT * FROM cargos";
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



      public function busqueda_personas()
      {
            $con = $this->conexion->conectar();
          $query = "SELECT a.*, b.*, c.* FROM empleado AS a INNER JOIN cargos AS b ON b.id_cargos=a.id_cargos
          INNER JOIN departamentos AS c ON b.id_departamento=c.id_departament";
          $result = $con->query($query);
        if ($result->num_rows > 0) {
          $data = array();
          while ($row = $result->fetch_assoc()) {
                 $data[] = $row;
          }
         return $data;
          }else
          {  
            echo" ";
          }
      }


      public function busqueda_nomina()
      {
          $con = $this->conexion->conectar();
          $query ="SELECT a.*, b.*, c.*, d.* FROM nomina AS a 
                   INNER JOIN empleado AS b ON a.cedula_empleado = b.cedula
                   INNER JOIN cargos AS c ON b.id_cargos=c.id_cargos 
                   INNER JOIN departamentos AS d ON d.id_departament = c.id_departamento";
          $result = $con->query($query);
          if ($result->num_rows > 0) 
          {
              $data = array();
              while ($row = $result->fetch_assoc()) {
                  $data[] = $row;
              }
              return $data;
          }
          else
          {  
              echo " ";
          }
      }
      
      public function update_empleados()
      {
          try {
              $conn = $this->conexion->conectar();
              extract($_POST);
              $errors = [];
      
              // Verificar si el usuario o la cédula ya existen en la base de datos
      
              $query1 = "SELECT * FROM empleado WHERE cedula = '$cedula'";
              $result1 = $conn->query($query1);
      
              if (!preg_match('/^[0-9]+$/', $cedula)) {
                $errors[] = "La cédula solo debe contener números.";
            }
    
            if (!preg_match('/^[a-zA-ZÁÉÍÓÚáéíóúüÜñÑ]+$/', $p_nombre)) {
                $errors[] = "El nombre tiene que ser de solo letras";
            }
    
            if (!empty($s_n)) {
                if (!preg_match('/^[a-zA-ZÁÉÍÓÚáéíóúüÜñÑ]+$/', $s_n)) {
                    $errors[] = "El segundo nombre tiene que ser de solo letras";
                }
            }
    
                if (!preg_match('/^[a-zA-ZÁÉÍÓÚáéíóúüÜñÑ]+$/', $p_a)) {
                    $errors[] = "El primer apellido tiene que ser de solo letras";
                }
    
    
            
    
            if (!empty($s_a)) {
                if (!preg_match('/^[a-zA-ZÁÉÍÓÚáéíóúüÜñÑ]+$/', $s_a)) {
                   $errors[] = "El segundo apellido tiene que ser de solo letras";
                }
            }
    
    
            if (!preg_match('/^[a-zA-Z0-9\s]+$/', $d)) {
                $errors[] = "la direccion puede llevar numero letras y espacios";
            }
    
            if (!preg_match('/^[0-9]+$/', $t_f)) {
                $errors[] = "El telefono fijo debe llevar solo numeros";
            }
    
            if (!preg_match('/^[0-9]+$/', $t_p)) {
                $errors[] = "El telefono personal debe llevar solo numeros";
            }
    
        if (empty($errors)) {
          
       
            if ($result1->num_rows > 0 ) 
              {
              $query_empleado = "UPDATE empleado SET nombre='$p_nombre', segundo_n = '$s_n', apellido = '$p_a',
              segundo_a ='$s_a', direccion = '$d', telefono_fijo = '$t_f', telefono_personal = '$t_p', num_cuenta = '$n_c',
              estados= '$estados', municipio= '$municipios', id_cargos ='$cargos', id_departamento='$departamento', fecha_nacimiento='$nacimiento',
              fecha_ingreso='$ingreso'
              WHERE  id_empleado= '$id_empleado' ";
              $result_empleado = $conn->query($query_empleado);
              }
  
              
              $query_empleado = "UPDATE empleado SET cedula='$cedula', nombre='$p_nombre', segundo_n = '$s_n', apellido = '$p_a',
              segundo_a ='$s_a', direccion = '$d', telefono_fijo = '$t_f', telefono_personal = '$t_p', num_cuenta = '$n_c',
              estados= '$estados', municipio= '$municipios', id_cargos ='$cargos', id_departamento='$departamento', fecha_nacimiento='$nacimiento',
              fecha_ingreso='$ingreso'
              WHERE  id_empleado= '$id_empleado' ";
              $result_empleado = $conn->query($query_empleado);
  
              if ($result_empleado) {
                // Volver a cargar los datos del usuario de la base de datos
               header("Location:editar_empleados.php?mgs=insert_exito&editId=$id_empleado");
               exit;
  
            }
          }
          else
          {
            foreach ($errors as $error) {
              echo "<p>Error: $error</p>";
              return false;
          }
          }
  
              
      
              // Si el usuario o la cédula no existen, procede con la actualización
              // Aquí puedes agregar el código para actualizar el empleado en la base de datos
      
          } catch (Exception $e) {
              echo "Error: " . $e->getMessage();
          }
      }

    public function update_empleado()
    {
        try {
            $conn = $this->conexion->conectar();
            extract($_POST);
            $errors = [];
    
            // Verificar si el usuario o la cédula ya existen en la base de datos
            $query = "SELECT * FROM usuario WHERE usuario = '$usuario' AND cedula = '$cedula' AND estatus ='Activo'";
            $result = $conn->query($query);
    
            $query1 = "SELECT * FROM empleado WHERE cedula = '$cedula'";
            $result1 = $conn->query($query1);
    
            if (!preg_match('/^[0-9]+$/', $cedula)) {
              $errors[] = "La cédula solo debe contener números.";
          }
  
          if (!preg_match('/^[a-zA-ZÁÉÍÓÚáéíóúüÜñÑ]+$/', $p_nombre)) {
              $errors[] = "El nombre tiene que ser de solo letras";
          }
  
          if (!empty($s_n)) {
              if (!preg_match('/^[a-zA-ZÁÉÍÓÚáéíóúüÜñÑ]+$/', $s_n)) {
                  $errors[] = "El segundo nombre tiene que ser de solo letras";
              }
          }
  
              if (!preg_match('/^[a-zA-ZÁÉÍÓÚáéíóúüÜñÑ]+$/', $p_a)) {
                  $errors[] = "El primer apellido tiene que ser de solo letras";
              }
  
  
          
  
          if (!empty($s_a)) {
              if (!preg_match('/^[a-zA-ZÁÉÍÓÚáéíóúüÜñÑ]+$/', $s_a)) {
                 $errors[] = "El segundo apellido tiene que ser de solo letras";
              }
          }
  
  
          if (!preg_match('/^[a-zA-Z0-9\s]+$/', $d)) {
              $errors[] = "la direccion puede llevar numero letras y espacios";
          }
  
          if (!preg_match('/^[0-9]+$/', $t_f)) {
              $errors[] = "El telefono fijo debe llevar solo numeros";
          }
  
          if (!preg_match('/^[0-9]+$/', $t_p)) {
              $errors[] = "El telefono personal debe llevar solo numeros";
          }
  
          if (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[.!@#$%_-])[a-zA-Z0-9.!@#$%_-]+$/', $clave)) {
              $errors[] = "La contraseña debe tener numero simbolos y letras";
          }
  
          if (!preg_match('/^[a-zA-Z0-9.!@#$%_-]+$/', $usuario)) {
              $errors[] = "el usuario puede tener numero simbolos y letras";
      }
      if (empty($errors)) {
        
     
          if ($result->num_rows > 0 && $result1->num_rows > 0 ) 
            {
              $query_usuario = "UPDATE usuario SET clave = '$clave' WHERE id_usuario ='$id_usuario'";
              $result_usuario = $conn->query($query_usuario);

            $query_empleado = "UPDATE empleado SET nombre='$p_nombre', segundo_n = '$s_n', apellido = '$p_a',
            segundo_a ='$s_a', direccion = '$d', telefono_fijo = '$t_f', telefono_personal = '$t_p', num_cuenta = '$n_c',
            estados= '$estados', municipio= '$municipios' WHERE  id_empleado= '$id_empleado' ";
            $result_empleado = $conn->query($query_empleado);
              return true;
            }

            $query_usuario = "UPDATE usuario SET cedula ='$cedula', usuario='$usuario', clave = '$clave' WHERE id_usuario ='$id_usuario'";
            $result_usuario = $conn->query($query_usuario);

            $query_empleado = "UPDATE empleado SET cedula ='$cedula', nombre='$p_nombre', segundo_n = '$s_n', apellido = '$p_a',
            segundo_a ='$s_a', direccion = '$d', telefono_fijo = '$t_f', telefono_personal = '$t_p', num_cuenta = '$n_c',
            estados= '$estados', municipio= '$municipios' WHERE  id_empleado= '$id_empleado' ";
            $result_empleado = $conn->query($query_empleado);

            if ($result_usuario && $result_empleado) {
              // Volver a cargar los datos del usuario de la base de datos
              $user = $this->getUser($usuario);
              $_SESSION['user'] = $user;
             return true;

          }
        }
        else
        {
          foreach ($errors as $error) {
            echo "<p>Error: $error</p>";
            return false;
        }
        }

            
    
            // Si el usuario o la cédula no existen, procede con la actualización
            // Aquí puedes agregar el código para actualizar el empleado en la base de datos
    
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getUser($username,$password='')
    {

      $conn = $this->conexion->conectar();
      if($password === ''){
        $sql = "SELECT * FROM usuario WHERE usuario = '$username' OR id_usuario='$username'";
      }
      # If user not exist return false
      $results = $conn->query($sql);
      if ($results == false){
        return false;
      }
      
      $user = $results->fetch_assoc();
      if(isset($user['rol'])){
      $user['rolName'] = $user['rol'];
      }

      return $user;
    }


    public function delete($id)
       {
           try {
               $conn = $this->conexion->conectar();
            
               // Preparar la consulta SQL para eliminar el registro
               $query = "DELETE FROM usuario WHERE id_usuario = ?";
               
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





       public function delete_nomina($id)
       {
           try {
               $conn = $this->conexion->conectar();
            
               // Preparar la consulta SQL para eliminar el registro
               $query = "DELETE FROM asignaciones_empleados WHERE id_nomina = ?";
               $query1 = "DELETE FROM deducciones_empleado WHERE id_nomina = ?";
               $query2 =  "DELETE FROM nomina WHERE id_nomina = ?";
               // Preparar la declaración
               $stmt = $conn->prepare($query);
               $stmt1 = $conn->prepare($query1);
               $stmt2 = $conn->prepare($query2);
               // Vincular parámetros
               $stmt->bind_param("i", $id);
               $stmt1->bind_param("i", $id);
               $stmt2->bind_param("i", $id);
               
               // Ejecutar la consulta
               if ($stmt->execute() && $stmt1->execute() && $stmt2->execute() ) {
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

       public function delete_empleado($id)
       {
           try {
               $conn = $this->conexion->conectar();
            
               // Preparar la consulta SQL para eliminar el registro
               $query = "DELETE FROM asignaciones_empleados WHERE cedula_empleado = ?";
               $query1 = "DELETE FROM asistencia WHERE cedula_empleado = ?";
               $query2 = "DELETE FROM deducciones_empleado WHERE cedula_empleado = ?";
               $query3 = "DELETE FROM nomina WHERE cedula_empleado = ?";
               $query4 = "DELETE FROM reposo_empleado WHERE cedula_reposo = ?";
               $query5 = "DELETE FROM empleado WHERE cedula = ?";
              
               
               // Preparar la declaración
               $stmt = $conn->prepare($query);
               $stmt1 = $conn->prepare($query1);
               $stmt2 = $conn->prepare($query2);
               $stmt3 = $conn->prepare($query3);
               $stmt4 = $conn->prepare($query4);
               $stmt5 = $conn->prepare($query5); 
               // Vincular parámetros
               $stmt->bind_param("i", $id);
               $stmt1->bind_param("i", $id);
               $stmt2->bind_param("i", $id);
               $stmt3->bind_param("i", $id);
               $stmt4->bind_param("i", $id);
               $stmt5->bind_param("i", $id);
               
               // Ejecutar la consulta
               if ($stmt->execute() &&
                   $stmt1->execute() &&
                    $stmt2->execute() &&
                     $stmt3->execute() && 
                     $stmt4->execute() && 
                     $stmt5->execute()) {
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


       public function busqueda_usuario()
    {
      $conn = $this->conexion->conectar();
        $query = "SELECT a.*, b.nombre, b.apellido, c.nombre_cargos FROM usuario AS a 
        INNER JOIN empleado AS b ON a.cedula = b.cedula  
        INNER JOIN cargos AS c ON b.id_cargos = c.id_cargos ";
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

    public function agregar()
    {    
        $con = $this->conexion->conectar();
        extract($_POST);
    
        // Validar y sanitizar los datos de entrada si es necesario
    
        // Verificar si ya existe un reposo para la cédula y la fecha final proporcionadas
        $verificar = "SELECT * FROM usuario WHERE  usuario = '$usuario'";
        $result = $con->query($verificar);
        
        if ($result && $result->num_rows > 0) {
            // Ya existe un reposo para la cédula y la fecha final, devolver false
            return false;
        }

        if (empty($roles) && empty($usuario) && empty($clave)) 
        {
          echo "
          <script>
          document.addEventListener('DOMContentLoaded', function() {
          
          Swal.fire({
          icon: 'warning',
          title: '¡Alerta!',
          text: 'Debes llenar todos los Campos.',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Aceptar'
        });
      });
        </script>";
          return false;
        }
        if (!empty($roles) && !empty($usuario) && !empty($clave)) {
          if (!preg_match("/^[0-9]+$/", $roles)) {
            // Display warning alert using Sweet Alert
            echo "
              <script>
              document.addEventListener('DOMContentLoaded', function() {
              
              Swal.fire({
              icon: 'warning',
              title: '¡Alerta!',
              text: 'Debes seleccionar un empleado.',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Aceptar'
            });
          });
            </script>";
          } 
  
          if (!preg_match("/^[a-zA-Z0-9]+$/", $clave)) {
              // Display warning alert using Sweet Alert
              echo "
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                
                Swal.fire({
                icon: 'warning',
                title: '¡Alerta!',
                text: 'Debes seleccionar un empleado.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar'
              });
            });
              </script>";
            }
  
            if (!preg_match("/^[a-zA-Z0-9]+$/", $usuario)) {
              // Display warning alert using Sweet Alert
              echo "
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                
                Swal.fire({
                icon: 'warning',
                title: '¡Alerta!',
                text: 'El usuario debe poseer numero y letras.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar'
              });
            });
              </script>";
            }

        // Intentar insertar el nuevo reposo
        $usuarios = "INSERT INTO usuario (cedula, usuario, clave, rol) VALUES ('$roles', '$usuario', '$clave', '$rol')";
        $smt = $con->query($usuarios);
        
        // Verificar si la inserción fue exitosa
        if ($smt) {
            // Inserción exitosa, devolver true
            return true;
        } else {
            // Fallo en la inserción, manejar el error apropiadamente
            // También podrías registrar el error para futuras referencias
            echo "
            <script>
            document.addEventListener('DOMContentLoaded', function() {
            
            Swal.fire({
            icon: 'warning',
            title: '¡Alerta!',
            text: 'Fallo El Registro.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Aceptar'
          });
        });
          </script>";
        }
    }
  }

  public function Editar_usuario()
{
    $con = $this->conexion->conectar();
    extract($_POST);

    // Validar y sanitizar los datos de entrada si es necesario

    // Verificar si el usuario existe en la base de datos
    $verificar = "SELECT * FROM usuario WHERE usuario ='$usuario' AND cedula='$roles'";
    $resultados = $con->query($verificar);

    if ($resultados->num_rows > 0) {
        // El usuario existe, solo actualiza la clave y el rol
        $actualizar = "UPDATE usuario SET clave='$clave', rol='$rol', estatus='$estatus' WHERE id_usuario='$id'";
    } else {
        // El usuario no existe, actualiza todos los campos
        $actualizar = "UPDATE usuario SET cedula='$roles', usuario='$usuario', clave='$clave', rol='$rol', estatus='$estatus' WHERE id_usuario='$id'";
    }

    // Ejecutar la consulta de actualización
    $smt = $con->query($actualizar);

    // Verificar si la actualización fue exitosa
    if ($smt) {
        // Redirigir con un mensaje de éxito
        header("Location: editar_usuario.php?mgs=update&editId=$id");
        exit;
    } else {
        // Redirigir con un mensaje de error
        header("Location: editar_usuario.php?mgs=error_al_actualizar&editId=$id");
        exit;
    }
}


  public function busqueda_usuarios($id)
  {
    $conn = $this->conexion->conectar();
      $sql = "SELECT * FROM usuario WHERE id_usuario = '$id'";
    
    # If user not exist return false
    $results = $conn->query($sql);
    if ($results == false){
      return false;
    }
    
    $user = $results->fetch_assoc();
  
    return $user;
  }

  public function rol()
  {
    $conn = $this->conexion->conectar();
      $query = "SELECT * FROM rol ";
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

  public function crear_empleado()
{
    $conn = $this->conexion->conectar();
    extract($_POST);
    $verifi = "SELECT * FROM empleado WHERE cedula=?";
    $stmt = $conn->prepare($verifi);
    $stmt->bind_param("s", $cedula);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return false;
    } else {
        try {
            $empleado = "INSERT INTO empleado(cedula, nombre, segundo_n, apellido,
                        segundo_a, direccion, telefono_fijo, telefono_personal, 
                        id_cargos, num_cuenta, fecha_nacimiento, fecha_ingreso, estados, municipio) 
                        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($empleado);
            $stmt->bind_param("ssssssssssssss", $cedula, $p_nombre, $s_n, $p_a, $s_a, $d, $t_f, $t_p, $cargos, $n_c, $nacimiento, $ingreso, $estados, $municipios);
            $stmt->execute();
            
            if ($stmt->affected_rows > 0) {
                return true;
            } else {
                echo "<script> document.addEventListener('DOMContentLoaded', function() { Swal.fire({icon: 'error', title: 'Error', text: 'Ups, hubo un error al Registrar'}); });</script>";
            }
        } catch (Exception $e) {
            // Manejo de la excepción
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }
    }
}









}
?>