<?php

require_once '../vendor/autoload.php';
require_once '../src/HeaderFooter.php'; // incluyo la clase

use Jorgem\ProyectoReflejos\ProgramasController; // utilizare el controlador

session_start(); // inicio sesion
// si no existe la variable de session que crea Validar significa que el login ha fallado te redirige otra vez a login
if(!isset($_SESSION['usuario'])){
    header('Location:login.php');
    die();
}
// instancio y creo el menu y footer
$header = new HeaderFooter();
$htmlHeader= $header->generarMenu();
$htmlFooter = $header->generarFooter();

// instancio y creo la lista de programas
$controller = new ProgramasController();
$data = $controller->getProgramas();


if (isset($_POST['programaId'])) {
    // obtengo el ID del deportista de la solicitud
    $programaId = $_POST['programaId'];
    // llamo al método deleteUser del controlador para eliminar el deportista
    $controller->deletePrograma($programaId);

    // recargo la página para reflejar los cambios
    header('Location: programas.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Programas</title>
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
    <h4 class="text-center mt-3">Lista de programas</h4>
    <a class="btn btn-outline-primary btn-sm btn-block" href="crearPrograma.php">Crear programa</a>
    <?php echo $data; ?>
</div>

<div class="footer fixed-bottom bg-dark text-white text-center d-flex justify-content-between p-1" style="height: 30px">
    <?php echo $htmlFooter ?>
</div>
</body>
</html>
