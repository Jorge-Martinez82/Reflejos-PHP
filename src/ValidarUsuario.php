<?php

require_once '../vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

class ValidarUsuario {
    public function __construct() {
        // Inicializa Firebase
        $factory = (new Factory)->withServiceAccount('../key.json');
        $this->auth = $factory->createAuth();
    }

    public function login($email, $password) {
        try {
            // Autentica al usuario con correo electrónico y contraseña
            $user = $this->auth->signInWithEmailAndPassword($email, $password);
            session_start();
            $_SESSION['usuario'] = $user->data()['email']; // creo la variable de sesión con el nombre del usuario
            // El inicio de sesión fue exitoso, redirige a una página protegida
            header("Location: prueba.php");
            exit();
        } catch (\Kreait\Firebase\Auth\SignIn\FailedToSignIn $e) {
            // Ocurrió un error al iniciar sesión
            return "Este usuario o contraseña no está autorizado o la contraseña no es correcta";
        }
    }
}

?>
