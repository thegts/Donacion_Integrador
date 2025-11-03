<?php
include("conexion/conexion-crud.php");
$con = connection();

$sql = "SELECT * FROM donadores";
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
    <title>CRUD DONACION</title>
</head>
<body>

    <?php include('layout/sidebar.php'); ?>

    <div class="main-content">

        <!-- Título grande y centrado -->
        <h1 class="text-center mb-4 titulo-especial">
            TABLA DONADORES
        </h1>

        <!-- Fila de botones alineados -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <!-- Botón Agregar Donador a la izquierda -->
            <button class="btn-agregar" type="button" data-bs-toggle="collapse" data-bs-target="#formDonador" aria-expanded="false" aria-controls="formDonador">
                <i class="bx bx-plus-circle"></i> Agregar
            </button>
            <!-- Botón Descargar PDF a la derecha -->
            <button id="pdfDonadores" class="btn btn-danger" type="button">
                Descargar Reporte <i class="bi bi-file-earmark-pdf"></i>
            </button>
        </div>

        <!-- Formulario colapsable -->
        <div class="collapse mb-4" id="formDonador">
            <div class="users-form">
                <form action="insert/insert_user.php" method="POST">
                    <input type="text" name="name" placeholder="Nombre" required>
                    <input type="text" name="lastname" placeholder="Apellidos" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="tel" name="fono" placeholder="Teléfono" required>
                    <input type="text" name="direccion" placeholder="Dirección" required>
                    <input type="submit" value="Agregar">
                </form>
            </div>
        </div>

        <div class="users-table">
            <h2>Donadores Registrados</h2>
            <!-- Tabla para web (con editar/eliminar) -->
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($query)): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['lastname'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= $row['fono'] ?></td>
                            <td><?= $row['direccion'] ?></td>
                            <td><a href="actualizar/actualizar-donadores.php?id=<?= $row['id'] ?>" class="users-table--edit"><i class="bx bx-edit"></i> Editar</a></td>
                            <td><a href="eliminar/eliminar-donadores.php?id=<?= $row['id'] ?>" class="users-table--delete"><i class="bx bx-trash"></i> Eliminar</a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- Tabla para el PDF (solo datos, oculta en web) -->
            <div id="tablaDonadoresPDF" style="display:none;">
                <!-- Encabezado SOLO para el PDF -->
                <div class="solo-pdf-pdf" style="text-align:center; margin-bottom:20px; display:none;">
                    <img src="imagenes/logod.png" alt="Logo DonaFacil" style="height:75px; margin-bottom:8px;">
                    <h2 style="font-size:2.1rem; color:#8d6e51; margin-bottom:6px; margin-top:5px;">Reporte de Donadores</h2>
                    <div style="color:#ad8864; font-weight:500; margin-bottom:2px;">
                        DonaFacil - Gestión de Donaciones
                    </div>
                    <div style="color:#555; font-size:1em; margin-bottom:3px;">
                        Email: <b>contacto@donafacil.org</b> | Tel: <b>+51 983 231 838</b>
                    </div>
                    <div style="color:#888; font-size:0.98em; margin-bottom:4px;">
                        Fecha de generación: <b><?= date('d/m/Y') ?></b>
                    </div>
                    <hr style="border-top:2px solid #ad8864; margin:10px 0 0 0;">
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        mysqli_data_seek($query, 0); // Volver al inicio del resultado
                        while ($row = mysqli_fetch_array($query)): ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= $row['name'] ?></td>
                                <td><?= $row['lastname'] ?></td>
                                <td><?= $row['email'] ?></td>
                                <td><?= $row['fono'] ?></td>
                                <td><?= $row['direccion'] ?></td>
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
    document.getElementById("pdfDonadores").addEventListener("click", function() {
        // Mostrar la cabecera SOLO para PDF
        const tabla = document.getElementById("tablaDonadoresPDF");
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
            pdf.save("donadores.pdf");
            // Ocultar de nuevo en la web
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
