<?php
require_once ('../../basededatos/base.php');
$conn = new conexion();
$con = $conn->conectar();
$fecha_ini = $_POST['fecha_ini'];
$fecha_fini  = $_POST['fecha_fini'];
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel="stylesheet" href="../../assets/css/estilos.css">
<link rel="stylesheet" href="../../assets/css/estilos.css">
<link rel="stylesheet" href="../../assets/css/estilos.css">
  <style>
    #piechart-container {
      width: 100%;
      display: flex;
      justify-content: center;
      align-items: center; /* Centra verticalmente */
      flex-direction: column; /* Alinea el contenido en columna */
    }
    #piechart {
      width: 1000px;
      height: 800px;
      margin-bottom: 20px; /* Espacio entre el gráfico y el botón */
    }
    #btnPrintPDF {
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
  <script type="text/javascript">
    
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Edad', 'Cantidad'],
        <?php
         $sqlTrabajadores = "SELECT TIMESTAMPDIFF(YEAR, a.fecha_nacimiento, CURDATE()) AS edad FROM empleado AS a 
                             INNER JOIN cargos AS b ON b.id_cargos =a.id_cargos 
                             INNER JOIN departamentos AS c ON c.id_departament = b.id_departamento 
                             WHERE a.fecha_nacimiento BETWEEN '$fecha_ini' AND '$fecha_fini'";
         $query = mysqli_query($con, $sqlTrabajadores);

         $edades = array();
         while ($resultado = mysqli_fetch_assoc($query)) {
            $edad = $resultado['edad'];
            if(isset($edades[$edad])) {
                $edades[$edad]++;
            } else {
                $edades[$edad] = 1;
            }
         }

         foreach ($edades as $edad => $cantidad) {
            echo "['$edad', $cantidad],";
         }
        ?>
      ]);

      var options = {
        title: 'Distribución de Trabajadores por Edades'
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart'));

      chart.draw(data, options);
    }
  </script>
</head>
<body>
<?php require_once('menu.php'); ?>
<div id="piechart-container">
    <div id="piechart"></div>
    <script>
    // Agregar un botón para imprimir la página
    window.onload = function() {
      var printButton = document.createElement('button');
      printButton.innerText = 'Imprimir';
      printButton.onclick = function() {
        window.print();
      };
      printButton.classList.add('btn', 'btn-primary'); // Agrega clases de Bootstrap para el estilo de botón azul
      
      // Aplicar estilos para centrar el botón
      printButton.style.display = 'block'; // Hacer que el botón sea un bloque para poder centrarlo
      printButton.style.margin = '0 auto'; // Margen automático para centrar horizontalmente
      
      document.body.appendChild(printButton);
    };
</script>
  </div>

  
</body>
</html>
