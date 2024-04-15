<?php

session_start(); // inicio sesion
// si no existe la variable de session que crea Validar significa que el login ha fallado te redirige otra vez a login
require_once '../src/HeaderFooter.php';
if(!isset($_SESSION['usuario'])){
    header('Location:login.php');
    die();
}
// instancio y creo el menu y el footer
$header = new HeaderFooter();
$htmlHeader= $header->generarMenu();
$htmlFooter = $header->generarFooter();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Crear Nuevo Programa</title>
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
<h4 class="text-center mt-3">Crear Nuevo Programa</h4><br>
    <form action="../src/procesarFormProgramas.php" method="post">

        <div class="row" >
            <div class="col">
                <input class="form-control" type="text" id="descripcion" name="descripcion" placeholder="Descripcion" required><br>
            </div>

        </div>
        <div class="row" >
            <div class="col">
                <input class="form-control" type="number" id="distancia" name="distancia" placeholder="Distancia" required><br>
            </div>
            <div class="col">
                <input class="form-control" type="number" id="nciclos" name="nciclos" placeholder="Nciclos" required><br>
            </div>
        </div>

        <div class="row" >
            <div class="col">
                <input class="form-control" type="number" id="tdescanso" name="tdescanso" placeholder="Tdescanso" required><br>
            </div>
            <div class="col">
                <input class="form-control" type="number" id="tejercicio" name="tejercicio" placeholder="Tejercicio"><br>
            </div>
        </div>
        <div>
        <input class="btn btn-outline-success mr-2" type="submit" value="Crear Programa">
        <a href="programas.php">Volver</a>
        </div>
    </form>

</div>
<div class="footer fixed-bottom bg-dark text-white text-center d-flex justify-content-between p-1" style="height: 30px">
    <?php echo $htmlFooter ?>
</div>
</body>
</html>

