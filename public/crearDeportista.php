<?php

session_start(); // inicio sesion
// si no existe la variable de session que crea Validar significa que el login ha fallado te redirige otra vez a login

require_once '../src/Footer.php';
require_once '../src/Header.php';
if(!isset($_SESSION['usuario'])){
    header('Location:login.php');
    die();
}
$header = new Header();
$htmlHeader= $header->generateMenu();

$footer = new Footer();
$htmlFooter = $footer->generateFooter();
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
<h4 class="text-center mt-3">Crear Nuevo Deportista</h4><br>
    <form action="../src/procesarFormularios.php" method="post">
        <div class="row" >
            <div class="col">
                <input class="form-control" type="text" id="nombre" name="nombre" placeholder="nombre" required><br>
            </div>
            <div class="col">
                <input class="form-control" type="text" id="apellido1" name="apellido1" placeholder="apellido1" required><br>
            </div>
        </div>
        <div class="row" >
            <div class="col">
                <input class="form-control" type="text" id="apellido2" name="apellido2" placeholder="apellido2" required><br>
            </div>
            <div class="col">
                <input class="form-control" type="date" id="fechanacimiento" name="fechanacimiento" required><br>
            </div>
        </div>

        <div class="row" >
            <div class="col">
                <input class="form-control" type="text" id="deporte" name="deporte" placeholder="deporte" required><br>
            </div>
            <div class="col">
                <input class="form-control" type="text" id="club" name="club" placeholder="club"><br>
            </div>
        </div>
        <div>
        <input class="btn btn-outline-success mr-2" type="submit" value="Crear Deportista">
        <a href="deportistas.php">Volver</a>
        </div>
    </form>

</div>
<?php echo $htmlFooter ?>
</body>
</html>

