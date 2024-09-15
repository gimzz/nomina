<?php
sleep(1);
require_once ('../basededatos/base.php');
$conn = new conexion();
$con = $conn->conectar();
$fecha_ini = date("Y-m-d", strtotime($_POST['fecha_ini']));
$fecha_fini  = date("Y-m-d", strtotime($_POST['fecha_fini']));
$sqlTrabajadores = ("SELECT a.*, c.*, DATE_FORMAT(a.fecha_nacimiento, '%d-%m-%Y') AS fecha FROM empleado AS a 
INNER JOIN departamentos AS c ON c.cedula_empleado = a.cedula");
$query = mysqli_query($con, $sqlTrabajadores);
$total   = mysqli_num_rows($query);
echo '<strong>Total: </strong> ('. $total .')';
?>

<table class="table table-hover">
    <thead>
        <tr>
                    <th scope="col">Nº</th>
                    <th scope="col">Cedula</th>
                    <th scope="col">Nombre y Apellido</th>
                    <th scope="col">Fecha de nacimiento</th>
                    <th scope="col">Edad</th>
                    <th scope="col">Cargo</th>
                   
                  
        </tr>
    </thead>
    <?php
    $i = 1;
    while ($dataRow = mysqli_fetch_array($query)) { 
         $fecha_nacimiento = new DateTime($dataRow['fecha_nacimiento']);
                    $fecha_actual = new DateTime();
                    $diferencia = $fecha_actual->diff($fecha_nacimiento);
                    $edad = $diferencia->y;
                    ?>
                <tbody>
                  <tr>
                    <td><?php echo $i++ ; ?></td>
                    <td><?php echo $dataRow['cedula_empleado'];?></td>
                    <td><?php echo $dataRow['nombre']." ".$dataRow['apellido']; ?></td>
                    <td><?php echo $dataRow['fecha']; ?></td>
                    <td><?php echo $edad; ?></td>
                    <td><?php echo $dataRow['nom_departamento']; ?></td>
                    

                        
                </tr>
                </tbody>
    <?php } ?>
</table>