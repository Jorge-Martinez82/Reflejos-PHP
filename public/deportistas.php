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
$html .= "<table>"; // Inicia la tabla
$html .= "<tr><th colspan='2'>Detalles del Deportista</th></tr>"; // Agrega una fila para el encabezado

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
                        <button type='submit' onclick=\"return confirm('¿Borrar Deportista?')\">Eliminar Deportista</button>
                    </form>
              </td></tr>";
    $html .= "<tr><td>
                    <form method='POST' action='modificarDeportista.php'>
                        <input type='hidden' name='deportista' value='".$jsonDeportista."'>
                        <button type='submit'>Modificar</button>
                    </form>
              </td></tr>";
    // Agrega más filas aquí si es necesario
}

$html .= "</table>"; // Cierra la tabla


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deportistas</title>
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


<h1>Lista de deportistas</h1>
<div>
    <a href="crearDeportista.php">Crear deportista</a>
</div>
<?php echo $html; ?>

<?php
require_once '../src/Footer.php';
$footer = new Footer();
echo $footer->generateFooter();
?>
</body>
</html>
