<?php

session_start(); // inicio sesion
require_once '../src/HeaderFooter.php';

// si no existe la variable de session que crea Validar significa que el login ha fallado te redirige otra vez a login
if(!isset($_SESSION['usuario'])){
    header('Location:login.php');
    die();
}

$header = new HeaderFooter();
$htmlHeader= $header->generarMenu();
$htmlFooter = $header->generarFooter();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>About</title>
    <style>
        .container {
            margin-top: 100px;
        }
    </style>
</head>
<body>

<div class="d-flex justify-content-between fixed-top" style="background-color: #d7d7d7">
    <?php echo $htmlHeader ?>
</div>
<div class="container">
    <h4 class="text-center mt-3">About</h4>
    <p>El proyecto REFLEJOS es una iniciativa colaborativa que se desarrollará en varios módulos de los ciclos formativos de Desarrollo de Aplicaciones Web, Desarrollo de Aplicaciones Multimedia y Administración de Sistemas Informáticos. Este proyecto implica una colaboración estrecha con los departamentos de Electricidad, Mecatrónica, Mecatrónica Industrial e Informática, con el fin de crear un producto deportivo real.</p>
    <p>Esta aplicación permite al usuario logueado visualizar, crear, eliminar y modificar tanto deportistas como programas.</p>
    <p>Tech stack:</p>
</div>
<div class="d-flex justify-content-around px-5">
    <img style=" height: 100px;" src="../src/images/firestore.png" alt="">
    <img style=" height: 100px;" src="../src/images/Apache_Software_Foundation_Logo_(2016).svg.png" alt="">
    <img style=" height: 100px;" src="../src/images/PHP-logo.svg.png" alt="">
    <img style=" height: 100px;" src="../src/images/Bootstrap_logo.svg.png" alt="">
    <img style="width: 100px; height: 100px;" src="../src/images/PhpStorm_Icon.svg.png" alt="">
</div>
<div class="footer fixed-bottom bg-dark text-white text-center d-flex justify-content-between p-1" style="height: 30px">
    <?php echo $htmlFooter ?>
</div>
</body>
</html>
