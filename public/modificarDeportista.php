<?php
require_once '../vendor/autoload.php';
require_once '../src/Footer.php';
require_once '../src/Header.php';
use Jorgem\ProyectoReflejos\DeportistasController;

session_start(); // inicio sesion
// si no existe la variable de session que crea Validar significa que el login ha fallado te redirige otra vez a login
if(!isset($_SESSION['usuario'])){
    header('Location:login.php');
    die();
}

$header = new Header();
$htmlHeader= $header->generateMenu();

$footer = new Footer();
$htmlFooter = $footer->generateFooter();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los datos del formulario
    $jsonDeportista = $_POST['deportista'];

    // Decodifica la cadena JSON en un array PHP
    $deportista = json_decode($jsonDeportista, true);
    // Accede a los datos del deportista como lo harías con cualquier otro array
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
</head>
<body>
<div class="d-flex justify-content-between">
    <h1>Reflejos</h1>
    <div class="float float-right d-inline-flex mt-2 align-items-baseline">
        <input type="text" size='10px' value="<?php echo $_SESSION['usuario']; ?>" class="form-control
    mr-2 bg-transparent text-info font-weight-bold" disabled>
        <!--boton que ejecuta cerrar.php-->
        <a href="../src/cerrar.php" class="btn btn-warning mr-2">Salir</a>
    </div>
</div>
<div class="d-flex justify-content-between fixed-top" style="background-color: #d7d7d7">
    <?php echo $htmlHeader ?>
</div>

<div class="container mt-4">
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
<?php echo $htmlFooter ?>
</body>
</html>


