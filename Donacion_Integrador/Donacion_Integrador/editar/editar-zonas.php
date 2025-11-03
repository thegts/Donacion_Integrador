<?php
    include("../conexion/conexion-crud.php");
    $con = connection();

    $id=$_POST["id"];
    $name = $_POST['name'];
    $zona = $_POST['zona'];
    $descripcion = $_POST['descripcion'];

    $sql="UPDATE zonas SET name='$name', zona='$zona', descripcion='$descripcion' WHERE id='$id'";
    $query = mysqli_query($con, $sql);

    if($query){
        Header("Location: /Donacion_Integrador/zonas.php");
    }else{

    }
?>