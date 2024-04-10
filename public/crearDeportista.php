<?php

session_start(); // inicio sesion
// si no existe la variable de session que crea Validar significa que el login ha fallado te redirige otra vez a login
if(!isset($_SESSION['usuario'])){
    header('Location:login.php');
    die();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Deportista</title>
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


<h1>Crear Nuevo Deportista</h1>

<form action="../src/procesarFormularios.php" method="post">
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required><br><br>

    <label for="apellido1">Apellido 1:</label>
    <input type="text" id="apellido1" name="apellido1" required><br><br>

    <label for="apellido2">Apellido 2:</label>
    <input type="text" id="apellido2" name="apellido2"><br><br>

    <label for="fechanacimiento">Fecha de Nacimiento:</label>
    <input type="date" id="fechanacimiento" name="fechanacimiento" required><br><br>

    <label for="deporte">Deporte:</label>
    <input type="text" id="deporte" name="deporte" required><br><br>

    <label for="club">Club:</label>
    <input type="text" id="club" name="club"><br><br>

    <input type="submit" value="Crear Deportista">
</form>
<a href="deportistas.php">Volver</a>

<?php
require_once '../src/Footer.php';
$footer = new Footer();
echo $footer->generateFooter();
?>
</body>
</html>

