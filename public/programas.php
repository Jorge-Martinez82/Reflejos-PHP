<?php

require_once '../vendor/autoload.php';

use Jorgem\ProyectoReflejos\ProgramasController;

session_start(); // inicio sesion
// si no existe la variable de session que crea Validar significa que el login ha fallado te redirige otra vez a login
if(!isset($_SESSION['usuario'])){
    header('Location:login.php');
    die();
}
$controller = new ProgramasController();
$data = $controller->getProgramas()
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programas</title>
</head>
<body>
<div>
    <p><?php echo $_SESSION['usuario']; ?></p>
    <a href="../src/cerrar.php">Salir</a>
</div>
<?php
// Incluir el archivo donde está definida la clase MenuHeader
require_once '../src/Header.php';

// Crear una instancia de la clase MenuHeader
$menuHeader = new Header();

// Generar el menú header y mostrarlo en la página
echo $menuHeader->generateMenu();
?>


<h1>Lista de programas</h1>
<?php var_dump($data); ?>
<?php
require_once '../src/Footer.php';
$footer = new Footer();
echo $footer->generateFooter();
?>
</body>
</html>
