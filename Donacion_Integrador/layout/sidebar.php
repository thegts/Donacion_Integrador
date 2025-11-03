<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <link rel="stylesheet" href="estilos/sidebar.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="menu-btn sidebar-btn" id="sidebar-btn">
        <i class="bx bx-menu"></i>
        <i class="bx bx-x"></i>
    </div>

    <div class="sidebar" id="sidebar">
        <div class="header">
            <div class="menu-btn" id="menu-btn">
                <i class="bx bx-chevron-left"></i>
            </div>
            <div class="brand">
                <img src="imagenes/logito.png" alt="logo">
                <span>DonaFacil</span>
            </div>    
        </div>

        <div class="menu-container">
            <div class="search">
            <i class="bx bx-search"></i>
            <input type="search" placeholder="Search">
        </div>

        <ul class="menu">
            <li class="menu-item menu-item-static active">
                <a href="index.html" class="menu-link">
                    <i class="bx bx-home-alt-2"></i>
                    <span>Pagina</span>
                </a>
            </li>

        <li class="menu-item menu-item-static">
            <a href="estadistica.php" class="menu-link">
                <i class="bx bx-bar-chart-alt-2"></i>
                <span>Estadisticas</span>
            </a>
        </li>

            <li class="menu-item menu-item-dropdown">
                <a href="#" class="menu-link">
                    <i class="bx bx-file-blank"></i>
                    <span>Tablas</span>
                    <i class="bx bx-chevron-down"></i>
                </a>
                <ul class="sub-menu">
                    <li><a href="crud.php" class="sub-menu-link">Donadores</a></li>
                    <li><a href="zonas.php" class="sub-menu-link">Zonas</a></li>
                    <li><a href="donaciones.php" class="sub-menu-link">Donaciones</a></li>
                </ul>
            </li>
        </ul>
        </div>
        
        <div class="footer">
            <ul class="menu">
            <li class="menu-item menu-item-static">
                <a href="#" class="menu-link" id="notificacionesBtn" style="position:relative;">
                    <i class="bx bx-bell"></i>
                    <span>Notificaciones</span>
                    <span id="notiPunto" style="display:none;position:absolute;top:7px;left:20px;width:11px;height:11px;background:#e74c3c;border-radius:50%;"></span>
                </a>
            </li>
                <li class="menu-item menu-item-static">
                    <a href="#" class="menu-link">
                        <i class="bx bx-cog"></i>
                        <span>Configuracion</span>
                    </a>
                </li>
            </ul>
            <div class="user">
                <div class="user-img">
                    <img src="imagenes/perfil.jpg" alt="">
                </div>
                <div class="user-data">
                    <span class="name">MarcoDiaz</span>
                    <span class="email">marcostone999@gmail.com</span>
                </div>
<div class="user-icon">
    <a href="cerrar-sesion.php" class="bx bx-exit logout-icon"></a>
</div>

            </div>
        </div>

    </div>

    <script src="script/script.js"></script>
</body>
</html>