<?php
require_once '../vendor/autoload.php';
require_once '../src/HeaderFooter.php';// incluyo la clase para crear el menu y footer

session_start(); // inicio sesion
// si no existe la variable de session que crea Validar significa que el login ha fallado te redirige otra vez a login
if(!isset($_SESSION['usuario'])){
    header('Location:login.php');
    die();
}
// instancio y creo menu y footer
$header = new HeaderFooter();
$htmlHeader= $header->generarMenu();
$htmlFooter = $header->generarFooter();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // recupero los datos del formulario
    $jsonDeportista = $_POST['deportista'];

    // decodifico la cadena JSON en un array
    $deportista = json_decode($jsonDeportista, true);
    // accedo a los datos del deportista para obtener los campos que me interesan
    // y los guardo en variables que utilizare para rellenar los placeholder del formulario
    $parts = explode('/', $deportista['name']);
    $deportistaId = end($parts);
    $nombre = $deportista['fields']['nombre']['stringValue'];
    $apellido1 = $deportista['fields']['apellido1']['stringValue'];
    $apellido2 = $deportista['fields']['apellido2']['stringValue'];
    $fechanacimiento = new DateTime($deportista['fields']['fechanacimiento']['timestampValue']);
    $deporte = $deportista['fields']['deporte']['stringValue'];
    $club = $deportista['fields']['club']['stringValue'];

    $fecha_formateada = $fechanacimiento->format('Y-m-d');
}




?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Crear Nuevo Deportista</title>
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
<h4 class="text-center mt-3">Modificar Deportista</h4>

<form action="../src/procesarFormDeportistas.php" method="post">
    <input type="hidden" name="formulario" value="formularioModificar">
    <input type="hidden" name="idDeportista" value="<?php echo $deportistaId; ?>">


    <div class="row">
        <div class="col">
            <label for="nombre">Nombre:</label>
            <input class="form-control" type="text" id="nombre" name="nombre" placeholder="<?php echo $nombre; ?>"><br>
        </div>
        <div class="col">
            <label for="apellido1">Apellido 1:</label>
            <input class="form-control" type="text" id="apellido1" name="apellido1" placeholder="<?php echo $apellido1; ?>"><br>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="apellido2">Apellido 2:</label>
            <input class="form-control" type="text" id="apellido2" name="apellido2" placeholder="<?php echo $apellido2; ?>"><br>
        </div>
        <div class="col">
            <label for="fechanacimiento">Fecha de Nacimiento:</label>
            <input class="form-control" type="date" id="fechanacimiento" name="fechanacimiento" value="<?php echo $fecha_formateada; ?>"><br>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="deporte">Deporte:</label>
            <input class="form-control" type="text" id="deporte" name="deporte" placeholder="<?php echo $deporte; ?>"><br>
        </div>
        <div class="col">
            <label for="club">Club:</label>
            <input class="form-control" type="text" id="club" name="club" placeholder="<?php echo $club; ?>"><br>
        </div>
    </div>
    <div>
        <input class="btn btn-outline-warning" type="submit" value="Modificar Deportista">
        <a  href="deportistas.php">Volver</a>
    </div>
</form>

</div>
<div class="footer fixed-bottom bg-dark text-white text-center d-flex justify-content-between p-1" style="height: 30px">
    <?php echo $htmlFooter ?>
</div></body>
</html>


