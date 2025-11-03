<?php 
    include("../conexion/conexion-crud.php");
    $con=connection();

    $id=$_GET['id'];

    $sql="SELECT * FROM donadores WHERE id='$id'";
    $query=mysqli_query($con, $sql);

    $row=mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../estilos/crud.css" rel="stylesheet">
        <title>Editar donadores</title>
        
    </head>
    <body>
        <div class="users-form">
            <form action="../editar/editar-donadores.php" method="POST">
                <input type="hidden" name="id" value="<?= $row['id']?>">
                <input type="text" name="name" placeholder="Nombre" value="<?= $row['name']?>">
                <input type="text" name="lastname" placeholder="Apellidos" value="<?= $row['lastname']?>">
                <input type="text" name="email" placeholder="Email" value="<?= $row['email']?>">
                <input type="text" name="fono" placeholder="Telefono" value="<?= $row['fono']?>">
                <input type="text" name="direccion" placeholder="Direccion" value="<?= $row['direccion']?>">

                <input type="submit" value="Actualizar">
            </form>
        </div>
    </body>
</html>