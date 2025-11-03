<?php
    include("../conexion/conexion-crud.php");
    $con = connection();

    $id=$_POST["id"];
    $name = $_POST['name'];
    $donacion = $_POST['donacion'];
    $monto = $_POST['monto'];
    $zona = $_POST['zona'];
    $comentario = $_POST['comentario'];

    $sql="UPDATE donaciones SET name='$name', donacion='$donacion', monto='$monto', zona='$zona', comentario='$comentario' WHERE id='$id'";
    $query = mysqli_query($con, $sql);

    if($query){
        Header("Location: /Donacion_Integrador/donaciones.php");
    }else{

    }
?>