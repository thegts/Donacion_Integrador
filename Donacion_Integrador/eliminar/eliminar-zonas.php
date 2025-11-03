<?php

    include("../conexion/conexion-crud.php");
    $con = connection();

    $id=$_GET["id"];

    $sql="DELETE FROM zonas WHERE id='$id'";
    $query = mysqli_query($con, $sql);

    if($query){
        Header("Location: /Donacion_Integrador/zonas.php");
    }else{

    }

?>