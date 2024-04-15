<?php
require_once '../vendor/autoload.php';
require_once '../src/HeaderFooter.php';
use Jorgem\ProyectoReflejos\DeportistasController;

session_start(); // inicio sesion
// si no existe la variable de session que crea Validar significa que el login ha fallado te redirige otra vez a login
if(!isset($_SESSION['usuario'])){
    header('Location:login.php');
    die();
}

$header = new HeaderFooter();
$htmlHeader= $header->generarMenu();
$htmlFooter = $header->generarFooter();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los datos del formulario
    $jsonPrograma = $_POST['programa'];

    // Decodifica la cadena JSON en un array PHP
    $programa = json_decode($jsonPrograma, true);
    // Accede a los datos del deportista como lo harías con cualquier otro array
    $parts = explode('/', $programa['name']);
    $programaId = end($parts);
    $descripcion = $programa['fields']['descripcion']['stringValue'];
    $distancia = $programa['fields']['distancia']['integerValue'];
    $nciclos = $programa['fields']['nciclos']['integerValue'];
    $tdescanso = $programa['fields']['tdescanso']['integerValue'];
    $tejercicio = $programa['fields']['tejercicio']['integerValue'];

}




?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Modificar Programa</title>
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
    <h4 class="text-center mt-3">Modificar Programa</h4>

    <form action="../src/procesarFormProgramas.php" method="post">
        <input type="hidden" name="formulario" value="formularioModificar">
        <input type="hidden" name="idPrograma" value="<?php echo $programaId; ?>">


        <div class="row">
            <div class="col">
                <label for="descripcion">Descripcion:</label>
                <input class="form-control" type="text" id="descripcion" name="descripcion" placeholder="<?php echo $descripcion; ?>"><br>
            </div>

        </div>
        <div class="row">
            <div class="col">
                <label for="nciclos">Nciclos:</label>
                <input class="form-control" type="number" id="nciclos" name="nciclos" placeholder="<?php echo $nciclos; ?>"><br>
            </div>
            <div class="col">
                <label for="distancia">Distancia:</label>
                <input class="form-control" type="number" id="distancia" name="distancia" placeholder="<?php echo $distancia; ?>"><br>
            </div>

        </div>
        <div class="row">
            <div class="col">
                <label for="tdescanso">Tdescanso:</label>
                <input class="form-control" type="number" id="tdescanso" name="tdescanso" placeholder="<?php echo $tdescanso; ?>"><br>
            </div>
            <div class="col">
                <label for="tejercicio">Tejercicio:</label>
                <input class="form-control" type="number" id="tejercicio" name="tejercicio" placeholder="<?php echo $tejercicio; ?>"><br>
            </div>
        </div>
        <div>
            <input class="btn btn-outline-warning" type="submit" value="Modificar Programa">
            <a  href="programas.php">Volver</a>
        </div>
    </form>

</div>
<div class="footer fixed-bottom bg-dark text-white text-center d-flex justify-content-between p-1" style="height: 30px">
    <?php echo $htmlFooter ?>
</div>
</body>
</html>



