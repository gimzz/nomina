<?php
class deducciones
{
   
    private $conn;
    
   
     public function __construct()
       {
        $this->conn = new conexion();
       }

       public function deducciones()
       {
         $conn = $this->conn->conectar();
           $query = "SELECT * FROM deducciones ";
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

       public function delete($id)
       {
           try {
               $conn = $this->conn->conectar();
            
               // Preparar la consulta SQL para eliminar el registro
               $query = "DELETE FROM deducciones WHERE id_deducciones = ?";
               
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

       public function agregar()
       {
        echo'<script src="../../assets/js/sweetalert2@11.js"></script>';// Include SweetAlert script
           
           $conn = $this->conn->conectar();
       
           // Sanitize input (to prevent SQL Injection)
           $deduccion = mysqli_real_escape_string($conn, $_POST['deduccion']);
           $valor_deduccion = mysqli_real_escape_string($conn, $_POST['valor_deduccion']);
       
           // Check if the deduction name already exists
           $verificacion = "SELECT * FROM deducciones WHERE nombre_deduccion = '$deduccion'";
           $check = $conn->query($verificacion);
       
           if ($check) {
               if ($check->num_rows > 0) {
                   return false; // Deduction already exists
               } else {
                   // Insert new deduction
                   $insertar = "INSERT INTO deducciones(nombre_deduccion, valor_deduccion) VALUES ('$deduccion', '$valor_deduccion')";
                   $query = $conn->query($insertar);
       
                   if ($query) {
                       return true; // Deduction added successfully
                   } else {
                       echo '<script>
                       document.addEventListener("DOMContentLoaded", function() {
                       Swal.fire("Error", "Error al insertar en la base de datos", "error"); );</script>';
                   }
               }
           } else {
               echo '<script>
               document.addEventListener("DOMContentLoaded", function() {
               Swal.fire("Error", "Error de base de datos", "error"); ); </script>';
           }
       }

       public function deduccion1()
       {
           $conn = $this->conn->conectar();
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

       public function editar()
       {
           extract($_POST);
           $conn = $this->conn->conectar();
       
           // Sanitize inputs (to prevent SQL Injection)
           $deduccion = mysqli_real_escape_string($conn, $deduccion);
           $valor_deduccion = mysqli_real_escape_string($conn, $valor_deduccion);
           $id = mysqli_real_escape_string($conn, $id);
       
           // Check if the deduction exists
           $verif = "SELECT * FROM deducciones WHERE nombre_deduccion='$deduccion'";
           $query = $conn->query($verif);
       
           if ($query->num_rows > 0) {
               // Deduction exists, update only valor_deduccion
               $actualizar = "UPDATE deducciones SET valor_deduccion = '$valor_deduccion' WHERE id_deducciones='$id'";
           } else {
               // Deduction doesn't exist, update nombre_deduccion and valor_deduccion
               $actualizar = "UPDATE deducciones SET nombre_deduccion='$deduccion', valor_deduccion = '$valor_deduccion' WHERE id_deducciones='$id'";
           }
       
           // Execute the update query
           $stm = $conn->query($actualizar);
       
           if ($stm) {
               // Redirect with success message
               header("Location: editar_deducciones.php?mgs=solo_elvalor&editId=$id");
               exit;
           } else {
               // Error handling
               header("Location: editar_deducciones.php?mgs=error&editId=$id");
               exit;
           }
       }
       
       

     



}







?>