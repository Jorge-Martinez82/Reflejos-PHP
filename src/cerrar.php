<?php
// cuando pulse el boton 'Salir' eliminare la variable de sesion si la hay y redirigire a la pagina de login
session_start();
if(isset($_SESSION['usuario'])) unset($_SESSION['usuario']);
header('Location:login.php');
