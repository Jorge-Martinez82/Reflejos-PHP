<?php
require_once '../src/ValidarUsuario.php'; // incluyo el controlador

// creo una instancia del controlador
$validarUsuario = new ValidarUsuario();

// verifico si se ha enviado el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // obtengo las credenciales del formulario
    $email = $_POST["email"];
    $password = $_POST["password"];


    // Llama al método login del controlador y en caso de que devuelva error, lo guarda en la variable
    $mensajeError = $validarUsuario->login($email, $password);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Iniciar sesión</title>
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-center h-100">
<div class="card">
<div class="card-header">
<h2>Iniciar sesión</h2>
</div>
<!-- si hay mensjae de error el login ha fallado y muestro el mensaje-->
<?php if (isset($mensajeError)) : ?>
    <p style="color: red;"><?php echo $mensajeError; ?></p>
<?php endif; ?>
<div class="card-body">
<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
    <div class="input-group form-group">

    <input class="form-control" placeholder="usuario" type="email" id="email" name="email" required><br><br>
    </div>
    <div class="input-group form-group">

    <input class="form-control" placeholder="usuario" type="password" id="password" name="password" required><br><br>
        <div class="form-group">
            <input type="submit" value="Iniciar" class="btn float-right btn-info" name='enviar' id="enviar">
        </div>
    </div>
</form>
</div>
</div>
    </div>
</div>
</body>
</html>
