<?php 
    include("../conexion/conexion-crud.php");
    $con=connection();

    $id=$_GET['id'];

    $sql="SELECT * FROM zonas WHERE id='$id'";
    $query=mysqli_query($con, $sql);

    $row=mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../estilos/crud.css" rel="stylesheet">
        <title>Editar Zona</title>
        
    </head>
    <body>
        <div class="users-form">
            <form action="../editar/editar-zonas.php" method="POST">
                <input type="hidden" name="id" value="<?= $row['id']?>">
                <input type="text" name="name" placeholder="Nombre" value="<?= $row['name']?>">
                <input type="text" name="zona" placeholder="Zona" value="<?= $row['zona']?>">
                <input type="text" name="descripcion" placeholder="Descripcion" value="<?= $row['descripcion']?>">

                <input type="submit" value="Actualizar">
            </form>
        </div>
    </body>
</html>