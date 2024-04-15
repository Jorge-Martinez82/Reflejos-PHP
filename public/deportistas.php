<?php

require_once '../vendor/autoload.php';
require_once '../src/HeaderFooter.php'; // incluyo la clase HeaderFooter
use Jorgem\ProyectoReflejos\DeportistasController; // usare DeportistaController

session_start(); // inicio sesion
// si no existe la variable de session que crea Validar significa que el login ha fallado te redirige otra vez a login
if(!isset($_SESSION['usuario'])){
    header('Location:login.php');
    die();
}
// instancio las dos clases
$header = new HeaderFooter();
$controller = new DeportistasController();
// creo variables para el menu, contenedor y footer llamando a sus respectivos metodos
$htmlHeader= $header->generarMenu();
$htmlFooter = $header->generarFooter();
$htmlContenedor = $controller->getDeportistas();

// comprueba que se haya definido el id de deportista cuando se llama a getDeportista()
if (isset($_POST['deportistaId'])) {
    // guardo el ID del deportista de la solicitud
    $deportistaId = $_POST['deportistaId'];
    // llamo al método deleteUser del controlador para eliminar el deportista
    $controller->deleteDeportista($deportistaId);
    // recargo la página para reflejar los cambios
    header('Location: deportistas.php');
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
    <title>Deportistas</title>
    <style>
        .container {
            margin-top: 100px;
        }
    </style>
</head>
<body>
<!--creo tres elementos div e incluyo dentro el menu, el contenedor de deportistas y el footer-->
<div class="d-flex justify-content-between fixed-top" style="background-color: #d7d7d7">
    <?php echo $htmlHeader ?>
</div>
<div class="container">
    <h4 class="text-center mt-3">Lista de deportistas</h4>
    <a class="btn btn-outline-primary btn-sm btn-block" href="crearDeportista.php">Crear deportista</a>
    <?php echo $htmlContenedor; ?>
</div>
<div class="footer fixed-bottom bg-dark text-white text-center d-flex justify-content-between p-1" style="height: 30px">
<?php echo $htmlFooter ?>
</div>
</body>
</html>
