<?php 
    include("../conexion/conexion-crud.php");
    $con=connection();

    $id=$_GET['id'];

    $sql="SELECT * FROM donaciones WHERE id='$id'";
    $query=mysqli_query($con, $sql);

    $row=mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../estilos/crud.css" rel="stylesheet">
        <title>Editar Donaciones</title>
        
    </head>
    <body>
        <div class="users-form">
            <form action="../editar/editar-donaciones.php" method="POST">
                <input type="hidden" name="id" value="<?= $row['id']?>">
                <input type="text" name="name" placeholder="Nombre" value="<?= $row['name']?>">
                <input type="text" name="donacion" placeholder="Donacion" value="<?= $row['donacion']?>">
                <input type="text" name="monto" placeholder="Monto" value="<?= $row['monto']?>">
                <input type="text" name="zona" placeholder="Zona" value="<?= $row['zona']?>">
                <input type="text" name="comentario" placeholder="Comentario" value="<?= $row['comentario']?>">

                <input type="submit" value="Actualizar">
            </form>
        </div>
    </body>
</html>