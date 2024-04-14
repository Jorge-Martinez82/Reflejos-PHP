<?php
// cuando pulse el boton 'Salir' eliminare la variable de sesion si la hay y redirigire a la pagina de login
session_start();
if(isset($_SESSION['usuario'])) unset($_SESSION['usuario']);
if(isset($_SESSION['contraseña'])) unset($_SESSION['contraseña']);
header('Location:../public/login.php');
