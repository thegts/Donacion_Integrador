<?php

    include("../conexion/conexion-crud.php");
    $con = connection();

    $id=$_GET["id"];

    $sql="DELETE FROM donadores WHERE id='$id'";
    $query = mysqli_query($con, $sql);

    if($query){
        Header("Location: /Donacion_Integrador/crud.php");
    }else{

    }

?>