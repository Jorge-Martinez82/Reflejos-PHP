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
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab aut deserunt est facere laboriosam molestiae qui repudiandae. Ad architecto beatae blanditiis consequuntur corporis deleniti dolor dolore eius exercitationem harum illum in ipsam laborum minima, obcaecati omnis praesentium, quae, qui quibusdam quis repellendus reprehenderit repudiandae saepe soluta tempora tempore velit veritatis.</p>
</div>
<div class="footer fixed-bottom bg-dark text-white text-center d-flex justify-content-between p-1" style="height: 30px">
    <?php echo $htmlFooter ?>
</div>
</body>
</html>
