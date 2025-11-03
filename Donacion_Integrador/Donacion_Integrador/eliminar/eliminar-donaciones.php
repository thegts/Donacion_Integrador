<?php

    include("../conexion/conexion-crud.php");
    $con = connection();

    $id=$_GET["id"];

    $sql="DELETE FROM donaciones WHERE id='$id'";
    $query = mysqli_query($con, $sql);

    if($query){
        Header("Location: /Donacion_Integrador/donaciones.php");
    }else{

    }

?>