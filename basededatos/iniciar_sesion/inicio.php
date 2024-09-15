<?php
require_once '../basededatos/base.php';
class iniciar
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new conexion();
    }

    public function ingresar_dato($usuario, $password)
    {
        try {
            // Conectar a la base de datos
            $conn = $this->conexion->conectar();
            
            // Preparar la consulta con parámetros seguros para evitar inyección de SQL
            $sql = "SELECT * FROM usuario WHERE usuario = ? AND clave = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $usuario, $password); // "ss" indica que ambos parámetros son strings
            $stmt->execute();
            
            // Obtener el resultado de la consulta
            $result = $stmt->get_result();
            
            // Verificar si se encontraron resultados
            if ($result->num_rows > 0) {
                // Obtener el usuario como un array asociativo
                $user = $result->fetch_assoc();
                
                // Retornar el usuario encontrado
                return $user;
            } else {
                // Si no se encontraron resultados, retornar false
                return false;
            }
        } catch (Exception $e) {
            // Manejar la excepción
            echo "Error al intentar ingresar dato: " . $e->getMessage();
            return false;
        }
    }
    



}
?>