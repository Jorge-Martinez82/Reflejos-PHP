<?php
require_once '../vendor/autoload.php';

use Jorgem\ProyectoReflejos\DeportistasController;

session_start(); // inicio sesion
// si no existe la variable de session que crea Validar significa que el login ha fallado te redirige otra vez a login
if(!isset($_SESSION['usuario'])){
    header('Location:login.php');
    die();
}

// Verifica si se han enviado datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $fechanacimiento = date('Y-m-d\TH:i:s\Z', strtotime($_POST['fechanacimiento']));
    $deporte = $_POST['deporte'];
    $club = $_POST['club'];

    // Instancia el controlador de deportistas
    $deportistasController = new DeportistasController();

    // Llama al método para crear un nuevo deportista
    $resultado = $deportistasController->createDeportista([
        'nombre' => $nombre,
        'apellido1' => $apellido1,
        'apellido2' => $apellido2,
        'fechanacimiento' => $fechanacimiento,
        'deporte' => $deporte,
        'club' => $club
    ]);

    // Verifica si la operación fue exitosa
    if ($resultado) {
        // Redirige a una página de éxito o muestra un mensaje de éxito
        header('Location: deportistas.php');
        exit();
    } else {
        // Muestra un mensaje de error
        echo "Error al crear el deportista.";
    }
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

<form action="crearDeportista.php" method="post">
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

