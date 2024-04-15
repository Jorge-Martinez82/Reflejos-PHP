<?php
// cuando pulse el boton 'Salir' eliminare las variables de sesion y redirigire a la pagina de login
session_start();
if(isset($_SESSION['usuario'])) unset($_SESSION['usuario']);
if(isset($_SESSION['contraseña'])) unset($_SESSION['contraseña']);
if(isset($_SESSION['idToken'])) unset($_SESSION['idToken']);
header('Location:../public/login.php');
