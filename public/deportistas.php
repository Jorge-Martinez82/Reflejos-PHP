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

$controller = new DeportistasController();
$html = $controller->getDeportistas();

if (isset($_POST['deportistaId'])) {
    // Obtén el ID del deportista de la solicitud
    $deportistaId = $_POST['deportistaId'];
    // Llama al método deleteUser del controlador para eliminar el deportista
    $controller->deleteDeportista($deportistaId);

    // Recarga la página para reflejar los cambios (opcional)
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
            margin-top: 100px; /* Ajusta el valor según sea necesario */
        }
    </style>
</head>
<body>
<div class="d-flex justify-content-between fixed-top" style="background-color: #d7d7d7">
    <?php echo $htmlHeader ?>
</div>

<div class="container">
    <h4 class="text-center mt-3">Lista de deportistas</h4>
    <a class="btn btn-outline-primary btn-sm btn-block" href="crearDeportista.php">Crear deportista</a>
    <?php echo $html; ?>
</div>

<?php echo $htmlFooter ?>
</body>
</html>
