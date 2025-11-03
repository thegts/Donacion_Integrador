<?php
include("conexion/conexion-crud.php");
$con = connection();

// 1. Total de donaciones
$sqlTotalDonaciones = "SELECT COUNT(*) as total FROM donaciones";
$totalDonaciones = mysqli_fetch_assoc(mysqli_query($con, $sqlTotalDonaciones))['total'];

// 2. Monto total donado
$sqlMontoTotal = "SELECT SUM(monto) as total FROM donaciones";
$montoTotal = mysqli_fetch_assoc(mysqli_query($con, $sqlMontoTotal))['total'] ?: 0;

// 3. Donaciones por tipo
$sqlPorTipo = "SELECT donacion, COUNT(*) as cantidad FROM donaciones GROUP BY donacion";
$resPorTipo = mysqli_query($con, $sqlPorTipo);
$tipos = [];
$cantidadesPorTipo = [];
while($row = mysqli_fetch_assoc($resPorTipo)){
    $tipos[] = $row['donacion'];
    $cantidadesPorTipo[] = $row['cantidad'];
}

// 4. Donaciones por zona
$sqlPorZona = "SELECT zona, COUNT(*) as cantidad FROM donaciones GROUP BY zona";
$resPorZona = mysqli_query($con, $sqlPorZona);
$zonas = [];
$cantidadesPorZona = [];
while($row = mysqli_fetch_assoc($resPorZona)){
    $zonas[] = $row['zona'];
    $cantidadesPorZona[] = $row['cantidad'];
}

// 5. Donadores únicos (por nombre)
$sqlUnicos = "SELECT COUNT(DISTINCT name) as unicos FROM donaciones";
$donadoresUnicos = mysqli_fetch_assoc(mysqli_query($con, $sqlUnicos))['unicos'];

// 6. Top 3 zonas más apoyadas
$sqlRankingZonas = "SELECT zona, COUNT(*) as cantidad FROM donaciones GROUP BY zona ORDER BY cantidad DESC LIMIT 3";
$resRankingZonas = mysqli_query($con, $sqlRankingZonas);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estadísticas de Donaciones</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/crud.css">
    <link rel="stylesheet" href="estilos/sidebar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Solo visible en PDF, nunca en la web */
        .solo-pdf { display: none; }
    </style>
</head>
<body>
<?php include('layout/sidebar.php'); ?>

<div class="main-content">
    <div class="container mt-4">
        <h1 class="mb-4 text-center">Estadísticas de Donaciones</h1>
        <div class="mb-4 text-end">
            <button id="btnPDF" class="btn btn-danger">
                Descargar Reporte en PDF <i class="bi bi-file-earmark-pdf"></i>
            </button>
        </div>

        <!-- INICIO DE CONTENIDO A EXPORTAR (DIV PDF) -->
        <div id="reportePDF">
            <!-- Cabecera solo para el PDF (oculta en web) -->
            <div class="solo-pdf" style="text-align:center; margin-bottom:30px; display:none;">
                <img src="imagenes/logod.png" alt="Logo DonaFacil" style="height:80px; margin-bottom:10px;">
                <h1 style="font-size:2.5rem; font-weight:bold; color:#8d6e51; margin-bottom:10px;">
                  Reporte Estadístico de Donaciones
                </h1>
                <h5 style="color:#ad8864; font-weight:500;">
                  Plataforma DonaFacil
                </h5>
                <p style="margin-bottom:0; color:#555;">
                  Fecha de generación: <b><?= date('d/m/Y') ?></b>
                </p>
                <hr style="border-top:2px solid #ad8864; margin-top:18px;">
            </div>

            <!-- MÉTRICAS PRINCIPALES -->
            <div class="row text-center mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm p-3">
                        <h6 class="text-secondary">Donaciones Totales</h6>
                        <h2 class="text-primary"><?= $totalDonaciones ?></h2>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm p-3">
                        <h6 class="text-secondary">Monto Total</h6>
                        <h2 class="text-success">S/ <?= number_format($montoTotal, 2) ?></h2>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm p-3">
                        <h6 class="text-secondary">Donadores Únicos</h6>
                        <h2 class="text-warning"><?= $donadoresUnicos ?></h2>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm p-3">
                        <h6 class="text-secondary">Zonas Beneficiadas</h6>
                        <h2 class="text-info"><?= count($zonas) ?></h2>
                    </div>
                </div>
            </div>

            <!-- GRÁFICAS -->
            <div class="row mt-5">
                <div class="col-lg-6 mb-4">
                    <div class="card p-3 shadow-sm">
                        <h5 class="text-center mb-3">Donaciones por Tipo</h5>
                        <canvas id="graficoTipo"></canvas>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card p-3 shadow-sm">
                        <h5 class="text-center mb-3">Donaciones por Zona</h5>
                        <canvas id="graficoZona"></canvas>
                    </div>
                </div>
            </div>

            <!-- TOP 3 ZONAS MÁS APOYADAS -->
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8">
                    <div class="card p-3 shadow-sm">
                        <h5 class="text-center mb-3">Top 3 Zonas Más Apoyadas</h5>
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th>Posición</th>
                                    <th>Zona</th>
                                    <th>Donaciones Recibidas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $medallas = ['🥇','🥈','🥉'];
                                $i = 0; 
                                while($row = mysqli_fetch_assoc($resRankingZonas)): ?>
                                <tr>
                                    <td><?= $medallas[$i] ?? ($i+1) ?></td>
                                    <td><?= htmlspecialchars($row['zona']) ?></td>
                                    <td><?= $row['cantidad'] ?></td>
                                </tr>
                                <?php $i++; endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIN DE CONTENIDO A EXPORTAR -->
        
    </div>
</div>

<!-- GRÁFICAS -->
<script>
// Gráfica Donaciones por Tipo
const ctxTipo = document.getElementById('graficoTipo').getContext('2d');
new Chart(ctxTipo, {
    type: 'bar',
    data: {
        labels: <?= json_encode($tipos) ?>,
        datasets: [{
            label: 'Cantidad',
            data: <?= json_encode($cantidadesPorTipo) ?>,
            backgroundColor: 'rgba(141,110,81,0.7)'
        }]
    },
    options: {
        responsive: true,
        scales: { y: { beginAtZero: true } }
    }
});

// Gráfica Donaciones por Zona
const ctxZona = document.getElementById('graficoZona').getContext('2d');
new Chart(ctxZona, {
    type: 'pie',
    data: {
        labels: <?= json_encode($zonas) ?>,
        datasets: [{
            label: 'Cantidad',
            data: <?= json_encode($cantidadesPorZona) ?>,
            backgroundColor: [
                '#8d6e51', '#bfa383', '#ffd699', '#ffb87b', '#ad8864', '#ffcf9c', '#a2805a', '#f5e3cc'
            ]
        }]
    },
    options: {
        responsive: true,
    }
});
</script>

<!-- SCRIPTS PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
document.getElementById("btnPDF").addEventListener("click", function() {
    // Mostrar el título/cabecera solo para PDF
    const cabecera = document.querySelector('.solo-pdf');
    cabecera.style.display = 'block';

    // Capturar el PDF
    const elemento = document.getElementById("reportePDF");
    html2canvas(elemento, { scale: 2 }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new window.jspdf.jsPDF('p', 'mm', 'a4');
        const pageWidth = pdf.internal.pageSize.getWidth();
        const pageHeight = pdf.internal.pageSize.getHeight();
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pageWidth;
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
        pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight > pageHeight ? pageHeight : pdfHeight);
        pdf.save("reporte-estadistico.pdf");
        cabecera.style.display = 'none';
    });
});
</script>


<!-- Lottie Player para el halcón -->
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<lottie-player
  id="halcon-lottie"
  src="animaciones/alcon.json"
  background="transparent"
  speed="1"
  style="position:fixed; left:250px; top:110px; width:150px; z-index:3000; pointer-events:none;"
  loop
  autoplay>
</lottie-player>


<script>
  function cruzarHalcon() {
    const halcon = document.getElementById('halcon-lottie');
    halcon.style.transition = 'none';
    halcon.style.left = '-180px';
    // Puedes cambiar "top:110px" si quieres otra altura
    setTimeout(() => {
      halcon.style.transition = 'left 5s linear';
      halcon.style.left = '100vw';
    }, 90);
  }
  setInterval(cruzarHalcon, 40000); // Cada 12 segundos vuelve a pasar
  cruzarHalcon();
</script>



<!-- Animación de pelea fija en la esquina derecha -->
<lottie-player
  id="pelea-lottie"
  src="animaciones/pelea.json"
  background="transparent"
  speed="1"
  style="position:fixed; right:20px; bottom:-500px; width:180px; z-index:9999; pointer-events:none;"
  loop
  autoplay>
</lottie-player>

</body>
</html>
