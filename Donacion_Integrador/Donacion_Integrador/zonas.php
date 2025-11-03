<?php
include("conexion/conexion-crud.php");
$con = connection();

$sql = "SELECT * FROM zonas";
$query = mysqli_query($con,$sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="estilos/crud.css" rel="stylesheet">
    <link rel="stylesheet" href="estilos/sidebar.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>CRUD ZONAS</title>
</head>

<body>
    <?php include('layout/sidebar.php'); ?>

    <div class="main-content">
        <!-- Título grande y centrado -->
        <h1 class="text-center mb-4 titulo-especial">
            TABLA ZONAS
        </h1>
        <!-- Fila de botones alineados -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <!-- Botón Agregar Zona a la izquierda -->
            <button class="btn-agregar" type="button" data-bs-toggle="collapse" data-bs-target="#formZona" aria-expanded="false" aria-controls="formZona">
                <i class="bx bx-plus-circle"></i> Agregar
            </button>
            <!-- Botón Descargar PDF a la derecha -->
            <button id="pdfZonas" class="btn btn-danger" type="button">
                Descargar Reporte <i class="bi bi-file-earmark-pdf"></i>
            </button>
        </div>

        <!-- Formulario colapsable -->
        <div class="collapse mb-4" id="formZona">
            <div class="users-form">
                <form action="insert/insert_zonas.php" method="POST">
                    <input type="text" name="name" placeholder="Nombre" required>
                    <input type="text" name="zona" placeholder="Zona" required>
                    <input type="text" name="descripcion" placeholder="Descripción" required>
                    <input type="submit" value="Agregar">
                </form>
            </div>
        </div>

        <div class="users-table">
            <h2>Zonas Registradas</h2>
            <!-- Tabla para web (con editar/eliminar) -->
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Zona</th>
                        <th>Descripción</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($query)): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['zona'] ?></td>
                            <td><?= $row['descripcion'] ?></td>
                            <td><a href="actualizar/actualizar-zonas.php?id=<?= $row['id'] ?>" class="users-table--edit"><i class="bx bx-edit"></i> Editar</a></td>
                            <td><a href="eliminar/eliminar-zonas.php?id=<?= $row['id'] ?>" class="users-table--delete"><i class="bx bx-trash"></i> Eliminar</a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- Tabla para el PDF (solo datos, oculta en web) -->
            <div id="tablaZonasPDF" style="display:none;">
                <!-- Encabezado SOLO para el PDF -->
                <div class="solo-pdf-pdf" style="text-align:center; margin-bottom:20px; display:none;">
                    <img src="imagenes/logod.png" alt="Logo DonaFacil" style="height:75px; margin-bottom:8px;">
                    <h2 style="font-size:2.1rem; color:#4F5D75; margin-bottom:6px; margin-top:5px;">Reporte de Zonas</h2>
                    <div style="color:#4F5D75; font-weight:500; margin-bottom:2px;">
                        DonaFacil - Gestión de Donaciones
                    </div>
                    <div style="color:#555; font-size:1em; margin-bottom:3px;">
                        Email: <b>contacto@donafacil.org</b> | Tel: <b>+51 983 231 838</b>
                    </div>
                    <div style="color:#888; font-size:0.98em; margin-bottom:4px;">
                        Fecha de generación: <b><?= date('d/m/Y') ?></b>
                    </div>
                    <hr style="border-top:2px solid #4F5D75; margin:10px 0 0 0;">
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Zona</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        mysqli_data_seek($query, 0);
                        while ($row = mysqli_fetch_array($query)): ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= $row['name'] ?></td>
                                <td><?= $row['zona'] ?></td>
                                <td><?= $row['descripcion'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- JS de Bootstrap, PDF y captura -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
    document.getElementById("pdfZonas").addEventListener("click", function() {
        const tabla = document.getElementById("tablaZonasPDF");
        const cabecera = tabla.querySelector('.solo-pdf-pdf');
        cabecera.style.display = 'block';
        tabla.style.display = 'block';

        html2canvas(tabla, { scale: 2 }).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const pdf = new window.jspdf.jsPDF('l', 'mm', 'a4');
            const pageWidth = pdf.internal.pageSize.getWidth();
            const pageHeight = pdf.internal.pageSize.getHeight();
            const imgProps = pdf.getImageProperties(imgData);
            const pdfWidth = pageWidth;
            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
            pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight > pageHeight ? pageHeight : pdfHeight);
            pdf.save("zonas.pdf");
            cabecera.style.display = 'none';
            tabla.style.display = 'none';
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
