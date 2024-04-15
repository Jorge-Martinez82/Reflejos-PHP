<?php

require_once '../vendor/autoload.php'; // incluyo el autoload

// clases que necesito para utilizar las herramientas de autenticacion de Firebase
use Jorgem\ProyectoReflejos\GenerarIDToken;
use Kreait\Firebase\Auth\SignIn\FailedToSignIn;
use Kreait\Firebase\Factory;

#[AllowDynamicProperties] class ValidarUsuario {
    public function __construct() {
        // inicializo Firebase indicando la localizacion del archivo de credenciales
        $factory = (new Factory)->withServiceAccount('../key.json');
        $this->auth = $factory->createAuth();
    }

    public function login($email, $password) {
        try {
            // autentifica al usuario con correo electrónico y contraseña
            $this->auth->signInWithEmailAndPassword($email, $password);
            // si la autenticacion es exitosa
            session_start();
            $_SESSION['usuario'] = $email; // creo la variable de sesión con el email del usuario
            $_SESSION['contraseña'] = $password; // creo la variable de sesión con la contraseña
            // instancio la clase y llamo al metodo que genera el tokenId
            $generarIDToken = new GenerarIDToken();
            $generarIDToken->generarToken();
            // redirijo a la pagina de inicio
            header("Location: deportistas.php");
            exit();
        } catch (FailedToSignIn $e) {
            // si la autenticacion falla devuelvo el mensaje para mostrar en login
            return "Este usuario o contraseña no está autorizado o la contraseña no es correcta";
        }
    }
}

?>
