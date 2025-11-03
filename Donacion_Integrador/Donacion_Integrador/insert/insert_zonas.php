<?php
include("../conexion/conexion-crud.php");
$con = connection();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $zona = $_POST['zona'];
    $descripcion = $_POST['descripcion'];

    if (empty($name) || empty($zona) || empty($descripcion)) {
        die("Todos los campos son obligatorios.");
    }

    $sql = "INSERT INTO zonas (name, zona, descripcion) VALUES (?, ?, ?)";
    
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, "sss", $name, $zona, $descripcion);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: /Donacion_Integrador/zonas.php");
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
