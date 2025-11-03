<?php
require_once "conexion.php";
$username = $email = $password = "";
$username_err = $email_err = $password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // NOMBRE DE USUARIO
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor ingresar el nombre de usuario";
    }else{
        $sql = "SELECT id FROM usuarios WHERE usuario = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = trim($_POST["username"]);

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Este nombre de usuario ya existe";
                }else{
                    $username = trim($_POST["username"]);
                }
            }else{
                echo "Ups, algo salio mal";
            }
        }
    }

    // EMAIL
    if(empty(trim($_POST["email"]))){
            $email_err = "Por favor ingresar un correo";
        }else{
            $sql = "SELECT id FROM usuarios WHERE email = ?";

            if($stmt = mysqli_prepare($link, $sql)){
                mysqli_stmt_bind_param($stmt, "s", $param_email);

                $param_email = trim($_POST["email"]);

                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_store_result($stmt);

                    if(mysqli_stmt_num_rows($stmt) == 1){
                        $email_err = "Este correo ya existe";
                    }else{
                        $email = trim($_POST["email"]);
                    }
                }else{
                    echo "Ups, algo salio mal";
                }
            }
        }
    
    // CONTRASEÑA
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor, ingrese una contraseña";
    }elseif(strlen(trim($_POST["password"])) < 4){
        $password_err = "La contraseña tiene que tener al menos 4 caracteres";
    }else{
        $password = trim($_POST["password"]);
    }


    if (empty($username_err) && empty($email_err) && empty($password_err)){
    $sql = "INSERT INTO usuarios (usuario, email, clave) VALUES (?, ?, ?)";
    if ($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_email, $param_password);
        
        $param_username = $username;
        $param_email = $email;
        $param_password = password_hash($password, PASSWORD_DEFAULT);

        if(mysqli_stmt_execute($stmt)){
            header("location:login.php");
        }else{
            echo "Algo salio mal, vuelva a intentar";
        }
    }
}

mysqli_close($link);

}
?>
