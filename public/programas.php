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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Programas</title>
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
<?php
// Incluir el archivo donde está definida la clase MenuHeader
require_once '../src/Header.php';
// Crear una instancia de la clase MenuHeader
$menuHeader = new Header();
// Generar el menú header y mostrarlo en la página
echo $menuHeader->generateMenu();
?>

<div class="container mt-4">
    <h4 class="text-center mt-3">Lista de programas</h4>
    <?php var_dump($data); ?>
</div>

<?php
require_once '../src/Footer.php';
$footer = new Footer();
echo $footer->generateFooter();
?>
</body>
</html>
