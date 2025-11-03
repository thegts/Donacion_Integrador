<?php
include("../conexion/conexion-crud.php");
$con = connection();

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename=zonas.csv');
echo "\xEF\xBB\xBF";

$output = fopen('php://output', 'w');
fputcsv($output, array('ID', 'Nombre', 'Zona', 'Descripción'), ';');

$sql = "SELECT * FROM zonas";
$result = mysqli_query($con, $sql);

while($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, array(
        $row['id'],
        $row['name'],
        $row['zona'],
        $row['descripcion']
    ), ';');
}
fclose($output);
exit;
?>
