<?php

require_once '../vendor/autoload.php';

use Symfony\Component\HttpClient\HttpClient;

session_start(); // inicio sesion
// si no existe la variable de session que crea Validar significa que el login ha fallado te redirige otra vez a login
if(!isset($_SESSION['usuario'])){
    header('Location:login.php');
    die();
}
$url = 'https://firestore.googleapis.com/v1/projects/proyectoreflejos-314e8/databases/(default)/documents/deportistas';
$key = '?key=AIzaSyAC-tLkSIq8otkvLp3mOemyelvd5QMwElo';

// Crear una instancia del cliente HTTP
$client = HttpClient::create();

// Realizar una solicitud GET a una URL
$response = $client->request('GET', $url . $key);

// Obtener el contenido de la respuesta en formato JSON
$data = $response->toArray();
$html = '';

foreach ($data['documents'] as $deportista) {
    $html .= "<div>";
    $html .= "<p><strong>Nombre:</strong> " . $deportista['fields']['nombre']['stringValue'] . "</p>";
    $html .= "<p><strong>Apellido:</strong> " . $deportista['fields']['apellido1']['stringValue'] . " " . $deportista['fields']['apellido2']['stringValue'] . "</p>";
    $html .= "<p><strong>Fecha de nacimiento:</strong> " . $deportista['fields']['fechanacimiento']['timestampValue'] . "</p>";
    $html .= "<p><strong>Deporte:</strong> " . $deportista['fields']['deporte']['stringValue'] . "</p>";
    $html .= "<p><strong>Club:</strong> " . $deportista['fields']['club']['stringValue'] . "</p>";
    // Agrega más campos aquí si es necesario
    $html .= "</div>";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deportistas</title>
</head>
<body>
<?php
// Incluir el archivo donde está definida la clase MenuHeader
require_once '../src/Header.php';

// Crear una instancia de la clase MenuHeader
$menuHeader = new Header();

// Generar el menú header y mostrarlo en la página
echo $menuHeader->generateMenu();
?>
<div>
    <p><?php echo $_SESSION['usuario']; ?></p>
    <a href="../src/cerrar.php">Salir</a>
</div>

<h1>Lista de deportistas</h1>
<?php echo $html; ?>
</body>
</html>
