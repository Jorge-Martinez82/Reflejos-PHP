<?php
session_start(); // inicio sesion
// si no existe la variable de session que crea Validar significa que el login ha fallado te redirige otra vez a login
if(!isset($_SESSION['usuario'])){
    header('Location:login.php');
    die();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>About</title>
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

<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab aut deserunt est facere laboriosam molestiae qui repudiandae. Ad architecto beatae blanditiis consequuntur corporis deleniti dolor dolore eius exercitationem harum illum in ipsam laborum minima, obcaecati omnis praesentium, quae, qui quibusdam quis repellendus reprehenderit repudiandae saepe soluta tempora tempore velit veritatis.</p>
<?php
require_once '../src/Footer.php';
$footer = new Footer();
echo $footer->generateFooter();
?>
</body>
</html>
