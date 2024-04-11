<?php

require_once '../vendor/autoload.php';

use Jorgem\ProyectoReflejos\DeportistasController;

session_start(); // inicio sesion
// si no existe la variable de session que crea Validar significa que el login ha fallado te redirige otra vez a login
if(!isset($_SESSION['usuario'])){
    header('Location:login.php');
    die();
}

$controller = new DeportistasController();
$data = $controller->getDeportistas();

if (isset($_POST['deportistaId'])) {
    // Obtén el ID del deportista de la solicitud
    $deportistaId = $_POST['deportistaId'];
    // Llama al método deleteUser del controlador para eliminar el deportista
    $controller->deleteDeportista($deportistaId);

    // Recarga la página para reflejar los cambios (opcional)
    header('Location: deportistas.php');
    exit();
}

$html = ''; // Inicializa la variable HTML fuera del bucle
$html .= "<table class='table mt-2'>"; // Inicia la tabla

foreach ($data['documents'] as $deportista) {
    $jsonDeportista = json_encode($deportista);
    $parts = explode('/', $deportista['name']);
    $deportistaId = end($parts);
    // Agrega una fila para cada campo del deportista
    $html .= "<tr><td><strong>Nombre:</strong></td><td>" . $deportista['fields']['nombre']['stringValue'] . "</td></tr>";
    $html .= "<tr><td><strong>Apellido:</strong></td><td>" . $deportista['fields']['apellido1']['stringValue'] . " " . $deportista['fields']['apellido2']['stringValue'] . "</td></tr>";
    $html .= "<tr><td><strong>Fecha de nacimiento:</strong></td><td>" . $deportista['fields']['fechanacimiento']['timestampValue'] . "</td></tr>";
    $html .= "<tr><td><strong>Deporte:</strong></td><td>" . $deportista['fields']['deporte']['stringValue'] . "</td></tr>";
    $html .= "<tr><td><strong>Club:</strong></td><td>" . $deportista['fields']['club']['stringValue'] . "</td></tr>";
    $html .= "<tr><td>
                    <form method='POST'>
                        <input type='hidden' name='deportistaId' value='{$deportistaId}'>
                        <button class='btn btn-danger btn-sm' type='submit' onclick=\"return confirm('¿Borrar Deportista?')\">Eliminar</button>
                    </form>
                    <form method='POST' action='modificarDeportista.php'>
                        <input type='hidden' name='deportista' value='".$jsonDeportista."'>
                        <button class='btn btn-warning btn-sm' type='submit'>Modificar</button>
                    </form>
              </td></tr>";

    // Agrega más filas aquí si es necesario
}

$html .= "</table>";


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Deportistas</title>
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
    <h4 class="text-center mt-3">Lista de deportistas</h4>
    <a class="btn btn-outline-primary btn-sm btn-block" href="crearDeportista.php">Crear deportista</a>
    <?php echo $html; ?>
</div>


<?php
require_once '../src/Footer.php';
$footer = new Footer();
echo $footer->generateFooter();
?>
</body>
</html>
