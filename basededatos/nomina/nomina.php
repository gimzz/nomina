<?php

class nomina
{
    private $con;

    public function __construct() {
        $this->con = new conexion();
    }


    public function busqueda($id)
    {
        $conn = $this->con->conectar();
        $query = "SELECT 
        e.*, 
        c.nombre_cargos, 
        d. nombre_departament,
        c.monto_a_gana, 
        GROUP_CONCAT(DISTINCT a.valor_asignacion ORDER BY a.valor_asignacion DESC) AS valores_asignacion,
        GROUP_CONCAT(DISTINCT a.tipo_asignacion ORDER BY a.valor_asignacion DESC) AS tipos_asignacion,
        COUNT(DISTINCT asistencia.fecha_ingreso) AS asistencias_mes
    FROM 
        empleado e
    INNER JOIN 
        cargos c ON e.id_cargos = c.id_cargos
    INNER JOIN 
    departamentos d ON d.id_departament = c.id_departamento
    INNER JOIN 
        asignaciones a ON c.id_cargos = a.id_cargos
    LEFT JOIN 
        asistencia ON e.cedula = asistencia.cedula_empleado
    INNER JOIN 
        nomina n ON e.cedula = n.cedula_empleado
    WHERE 
        n.id_nomina = ?
    GROUP BY 
        e.id_empleado, c.id_cargos
    ";


        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            return $data;
        } else {
            // Lanzar una excepción o devolver null si no se encuentran registros
            throw new Exception("No hay registros encontrados");
        }
    }

    public function deduccion1()
    {
        $conn = $this->con->conectar();
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
    
    public function fecha($id)
    {
        $conn = $this->con->conectar();
        $query = "SELECT fecha_inicio, fecha_fin FROM nomina WHERE id_nomina =?";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            return $data;
        } else {
            // Lanzar una excepción o devolver null si no se encuentran registros
            throw new Exception("No hay registros encontrados");
        }

    }

    public function obtenerDetallesNomina($id)
    {
        $conn = $this->con->conectar();
        $query = "SELECT a.*, b.* FROM asignaciones_empleados AS a
        INNER JOIN deducciones_empleado AS b ON a.id_nomina =b.id_nomina WHERE a.id_nomina = ?";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            return $data;
        } else {
            // Lanzar una excepción o devolver null si no se encuentran registros
            throw new Exception("No hay registros encontrados");
        }

    }
    
    
}



?>