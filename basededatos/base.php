<?php
class conexion
{
    private $servidor;
    private $username;
    private $password;
    private $database;
    
   
    private $conn;
    
   
     public function __construct()
       {
        $this->servidor ='localhost';
        $this->username ='root';
        $this->password ='';
        $this->database ='nomina';
       }

       public function conectar()
      {
          $conn = new mysqli($this->servidor,$this->username,$this->password,$this->database);	
          if ($conn->connect_error) {
            die('Error de Conexión (' . $conn->connect_errno . ') '
                  . $conn->connect_error);
      }
          
          return $conn;
      }

      public function desconectar($conetion)
      {
        $conetion->close();
      }




}







?>