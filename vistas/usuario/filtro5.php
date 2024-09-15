<?php
sleep(1);
require_once ('../../basededatos/base.php');
$conn = new conexion();
$con = $conn->conectar();
$fecha_ini = date("Y-m-d", strtotime($_POST['fecha_ini']));
$fecha_fini  = date("Y-m-d", strtotime($_POST['fecha_fini']));
$sqlTrabajadores = ("SELECT a.*,  DATE_FORMAT(b.fecha_inicio, '%d-%m-%Y') AS fecha, b.*
FROM empleado AS a INNER JOIN reposo_empleado AS b ON a.cedula = b.cedula_reposo");

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
                    <th scope="col">Fecha</th>
                    <th scope="col">Cargo</th>
                   
                  
        </tr>
    </thead>
    <?php
    $i = 1;
    while ($dataRow = mysqli_fetch_array($query)) { ?>
        <tbody>
            <tr>
                    <td><?php echo $i++ ; ?></td>
                    <td><?php echo $dataRow['cedula_empleado'];?></td>
                    <td><?php echo $dataRow['nombre']." ".$dataRow['apellido']; ?></td>
                    <td><?php echo $dataRow['fecha']; ?></td>
                    <td><?php echo $dataRow['nom_departamento']; ?></td>
                         
                    
            </tr>
        </tbody>
    <?php } ?>
</table>