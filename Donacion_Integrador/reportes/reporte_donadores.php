<?php
include("conexion/conexion-crud.php");
$con = connection();

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename=donadores.csv');
echo "\xEF\xBB\xBF";

$output = fopen('php://output', 'w');
fputcsv($output, array('ID', 'Nombre', 'Apellido', 'Correo', 'Teléfono', 'Dirección'), ';');

$sql = "SELECT * FROM donadores";
$result = mysqli_query($con, $sql);

while($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, array(
        $row['id'],
        $row['name'],
        $row['lastname'],
        $row['email'],
        $row['fono'],
        $row['direccion']
    ), ';');
}
fclose($output);
exit;
?>
