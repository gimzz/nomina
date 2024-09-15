<?php 
require "../../basededatos/base.php";
require "../../basededatos/nomina/nomina.php";

// Crear una instancia de la clase nomina
$nomina = new nomina();

if(isset($_GET['editId']) && !empty($_GET['editId'])) {
    $id_nomina = intval($_GET['editId']);
    $datosEmpleado = $nomina->busqueda($id_nomina); 
    $deducciones = $nomina->deduccion1();
    $fecha = $nomina->fecha($id_nomina);
    $fecha_i = date('d/m/Y', strtotime($fecha['fecha_inicio']));
    $fecha_f = date('d/m/Y', strtotime($fecha['fecha_fin']));


    // Verificar si se encontraron datos del empleado
    if ($datosEmpleado) {
        $cargo = $datosEmpleado['nombre_cargos']; // Utiliza la clave correcta para el cargo
        $sueldo_mensual = $datosEmpleado['monto_a_gana']; // Utiliza la clave correcta para el sueldo mensual
        $asistencias_mes = $datosEmpleado['asistencias_mes'];

        // Calcula el sueldo por día
        $sueldo_por_dia = $sueldo_mensual / date('t');

        // Calcula el total de días laborados en el mes actual
        $total_dias_laborados = $asistencias_mes;

        // Calcula las ganancias del mes
        $ganancias_mes = $sueldo_por_dia * $total_dias_laborados;

        // Inicializa el total a deducir
        $total_deducir = 0;

        // Calcula las deducciones
        foreach ($deducciones as $deduccion) {
            $porcentaje_deduccion = $deduccion['valor_deduccion'] / 100; // Convierte el porcentaje a decimal
            $total_deducir += $ganancias_mes * $porcentaje_deduccion;
        }

        // Calcula el salario total
        $salario_total = $ganancias_mes - $total_deducir;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../assets/css/estilos.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
  <title>Detalles de Nómina</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
    }
    .container {
      max-width: 800px;
      margin: 0 auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h2, h3 {
      text-align: center;
      color: #333;
    }
    .details {
      margin-bottom: 20px;
    }
    .details p {
      margin: 5px 0;
    }
    .details ul {
      margin: 5px 0;
      padding-left: 20px;
    }
    .details ul li {
      list-style: none;
    }
    .details ul li strong {
      color: #333;
    }
    .total-salary {
      font-size: 18px;
      font-weight: bold;
      color: #1e7e34;
    }
    .print-button {
      text-align: center;
      margin-top: 20px;
    }
    .print-button button {
      padding: 10px 20px;
      background-color: #1e7e34;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .print-button button:hover {
      background-color: #145827;
    }
    /* Nueva regla CSS para la fecha */
    .fecha-nomina {
      float: right;
    }
  </style>
</head>
<body>
  <?php
  require "menu.php";
  ?>
  <br><br><br><br><br><br><br>
  <div class="container">
    <h2>Detalles de Nómina</h2>
    <div class="details">
      <?php if(isset($datosEmpleado)): ?>
        <h3>Empleado: <?php echo $datosEmpleado['nombre'] . ' ' . $datosEmpleado['apellido']; ?></h3>
        <p><strong>Cédula:</strong> <?php echo $datosEmpleado['cedula']; ?></p>
        <p><strong>Cargo:</strong> <?php echo $cargo; ?></p>
        <p><strong>Departamento:</strong> <?php echo $datosEmpleado['nombre_departament']; ?></p>
        <p><strong>Salario Base:</strong> <?php echo $sueldo_mensual; ?></p>
        <p><strong>Asistencias en el Mes:</strong> <?php echo $asistencias_mes; ?></p>
        <p><strong>Ganancias del Mes:</strong> $<?php echo $ganancias_mes; ?></p>
        <p><strong>Total a Deducir:</strong> $<?php echo $total_deducir; ?></p>
        <!-- Mover la fecha a la derecha -->
        <p class="fecha-nomina"><strong>Fecha de la Nómina:</strong> <?php echo $fecha_i." "."Hasta"." ".$fecha_f ?></p>
        <p class="total-salary"><strong>Salario Total:</strong> $<?php echo $salario_total; ?></p>
      <?php else: ?>
        <p>No se encontraron datos del empleado.</p>
      <?php endif; ?>
    </div>
    
    <div class="print-button">
      <button onclick="window.print()">Imprimir</button>
    </div>
  </div>
</body>
</html>

