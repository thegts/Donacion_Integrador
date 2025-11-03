<?php
    include("../conexion/conexion-crud.php");
    $con = connection();

    $id=$_POST["id"];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $fono = $_POST['fono'];
    $direccion = $_POST['direccion'];

    $sql="UPDATE donadores SET name='$name', lastname='$lastname', email='$email', fono='$fono', direccion='$direccion' WHERE id='$id'";
    $query = mysqli_query($con, $sql);

    if($query){
        Header("Location: /Donacion_Integrador/crud.php");
    }else{

    }
?>