<?php
require_once '../src/ValidarUsuario.php'; // Incluye el controlador

// Crea una instancia del controlador
$validarUsuario = new ValidarUsuario();

// Verifica si se ha enviado el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene las credenciales del formulario
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Llama al método login del controlador
    $errorMessage = $validarUsuario->login($email, $password);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
</head>
<body>
<h2>Iniciar sesión</h2>
<?php if (isset($errorMessage)) : ?>
    <p style="color: red;"><?php echo $errorMessage; ?></p>
<?php endif; ?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="email">Correo electrónico:</label>
    <input type="email" id="email" name="email" required><br><br>
    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required><br><br>
    <button type="submit">Iniciar sesión</button>
</form>
</body>
</html>
