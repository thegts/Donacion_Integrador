<?php
include("../conexion/conexion-crud.php");
$con = connection();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $fono = $_POST['fono'];
    $direccion = $_POST['direccion'];

    if (empty($name) || empty($lastname) || empty($email) || empty($fono) || empty($direccion)) {
        die("Todos los campos son obligatorios.");
    }

    $sql = "INSERT INTO donadores (name, lastname, email, fono, direccion) VALUES (?, ?, ?, ?, ?)";
    
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssss", $name, $lastname, $email, $fono, $direccion);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: /Donacion_Integrador/crud.php");
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
