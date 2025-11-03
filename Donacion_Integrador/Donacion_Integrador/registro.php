<?php 
    include 'codigo-registro.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Donacion</title>
    <link rel="stylesheet" href="estilos/log.css">
     
</head>
<body>
    
    <div class="container-all">
        <div class="ctn-form">
            <img src="imagenes/logod.png" alt="" class="logo">
            <h1 class="title">Registrate</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="">Nombre de Usuario</label>
                <input type="text" name="username">
                <span class="msg-error"> <?php echo $username_err ?> </span>
                <label for="">Email</label>
                <input type="text" name="email">
                <span class="msg-error"> <?php echo $email_err ?> </span>
                <label for="">Contraseña</label>
                <input type="password" name="password">
                <span class="msg-error"> <?php echo $password_err ?> </span>

                <input type="submit" value="registrar">
            </form>

            <span class="text-footer">Ya te registraste?
                <a href="login.php">Iniciar Sesion</a>
            </span>
        </div>

        <div class="ctn-text">
            <div class="capa"></div>
            <h1 class="title-description">Únete a nuestra causa, transforma vidas</h1>
            <p class="text-description">
                Cada día, miles de personas enfrentan el dolor, el hambre y la soledad. Tú puedes ser la esperanza que necesitan. 
                Al unirte a nuestra comunidad solidaria, no solo estás ofreciendo ayuda, estás regalando una parte de tu corazón a quienes más lo necesitan. 
                Un pequeño gesto, una simple acción, puede marcar la diferencia entre la desesperanza y una nueva oportunidad. 
                Sé el cambio que el mundo necesita. Aporta tu granito de arena y juntos lograremos que ninguna alma sufra en silencio.
            </p>
        </div>

    </div>

</body>
</html>