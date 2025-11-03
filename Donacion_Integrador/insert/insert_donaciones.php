<?php
include("../conexion/conexion-crud.php");
$con = connection();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $donacion = $_POST['donacion'];
    $monto = $_POST['monto'];
    $zona = $_POST['zona'];
    $comentario = $_POST['comentario'];

    if (empty($name) || empty($donacion) || empty($monto) || empty($zona) || empty($comentario)) {
        die("Todos los campos son obligatorios.");
    }

    $sql = "INSERT INTO donaciones (name, donacion, monto, zona, comentario) VALUES (?, ?, ?, ?, ?)";
    
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssss", $name, $donacion, $monto, $zona, $comentario);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: /Donacion_Integrador/donaciones.php");
            exit;
        } else {
            echo "Error al insertar los datos.";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error al preparar la consulta.";
    }
}
?>
