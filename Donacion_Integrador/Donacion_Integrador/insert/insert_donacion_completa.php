<?php
require_once("../conexion/conexion-crud.php");
$conexion = connection();

$name        = $_POST['name'];
$lastname    = $_POST['lastname'];
$email       = $_POST['email'];
$fono        = $_POST['fono'];
$direccion   = $_POST['direccion'];
$zona        = $_POST['zona'];
$descripcion = $_POST['descripcion'];
$donacion    = $_POST['donacion'];
$monto       = $_POST['monto'];
$comentario  = $_POST['comentario'];

$mensaje_donador = "";

// 1. Buscar si el donador ya existe
$query_check = "SELECT id FROM donadores WHERE name=? AND lastname=? AND email=? AND fono=?";
$stmt_check = mysqli_prepare($conexion, $query_check);
mysqli_stmt_bind_param($stmt_check, "ssss", $name, $lastname, $email, $fono);
mysqli_stmt_execute($stmt_check);
mysqli_stmt_store_result($stmt_check);

if (mysqli_stmt_num_rows($stmt_check) == 0) {
    // No existe, insertar nuevo donador
    $query1 = "INSERT INTO donadores (name, lastname, email, fono, direccion) VALUES (?, ?, ?, ?, ?)";
    $stmt1 = mysqli_prepare($conexion, $query1);
    mysqli_stmt_bind_param($stmt1, "sssss", $name, $lastname, $email, $fono, $direccion);
    mysqli_stmt_execute($stmt1);
    mysqli_stmt_close($stmt1);
    $mensaje_donador = "¡Donador registrado y donación realizada con éxito!";
} else {
    // Ya existe
    $mensaje_donador = "El donador ya estaba registrado, pero la donación fue realizada con éxito.";
}
mysqli_stmt_close($stmt_check);

// 2. Insertar zona (guarda el nombre del donador en el campo 'name')
$query2 = "INSERT INTO zonas (name, zona, descripcion) VALUES (?, ?, ?)";
$stmt2 = mysqli_prepare($conexion, $query2);
mysqli_stmt_bind_param($stmt2, "sss", $name, $zona, $descripcion);
mysqli_stmt_execute($stmt2);
mysqli_stmt_close($stmt2);

// 3. Insertar donación
$query3 = "INSERT INTO donaciones (name, donacion, monto, zona, comentario) VALUES (?, ?, ?, ?, ?)";
$stmt3 = mysqli_prepare($conexion, $query3);
mysqli_stmt_bind_param($stmt3, "sssss", $name, $donacion, $monto, $zona, $comentario);
mysqli_stmt_execute($stmt3);
mysqli_stmt_close($stmt3);

mysqli_close($conexion);

// Redirigir con el mensaje por la URL
header("Location: ../index.html?mensaje=" . urlencode($mensaje_donador));
exit();
?>
