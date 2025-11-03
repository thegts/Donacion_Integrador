<?php
include("conexion/conexion-crud.php");
$con = connection();

// Para que Excel lea bien los acentos:
header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename=donaciones.csv');
echo "\xEF\xBB\xBF"; // BOM UTF-8 para Excel

$output = fopen('php://output', 'w');

// Encabezados
fputcsv($output, array('ID', 'Nombre', 'Tipo de Donación', 'Monto', 'Zona', 'Comentario'), ';');

// Datos
$sql = "SELECT * FROM donaciones";
$result = mysqli_query($con, $sql);

while($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, array(
        $row['id'],
        $row['name'],
        $row['donacion'],
        $row['monto'],
        $row['zona'],
        $row['comentario']
    ), ';'); // Usamos ; como separador
}
fclose($output);
exit;
?>
