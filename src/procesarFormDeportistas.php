<?php
session_start();
require_once '../vendor/autoload.php';

use Jorgem\ProyectoReflejos\DeportistasController;
// instancion el controlador
$deportistasController = new DeportistasController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // comprueba mediante un condicional si el formulario es el de modificar
    if ($_POST['formulario'] === 'formularioModificar') {
        // creo un array para los campos modificados
        $campos_modificados = array();
        // selecciono los campos que no estan vacios
        foreach ($_POST as $campo => $valor) {
            if (!empty($valor)) {
                // si no esta vacio guado el campo modificado y su valor en el array
                $campos_modificados[$campo] = $valor;
            }
        }
        // formateo la fecha de nacimiento, este campo siempre estara incluido ya que el input
        // tipo date no permite placeholder asi que lo tengo que mostrar tal cual y volverlo a enviar
        $timestamp = strtotime($campos_modificados['fechanacimiento']);
        $fechaFormateada = date('Y-m-d\TH:i:s\Z', $timestamp);
        $campos_modificados['fechanacimiento'] = $fechaFormateada;

        // extraigo el primer valor del array (nombre del formulario) que ya no necesito
        array_shift($campos_modificados);
        // extraido y guardo el id que utilizare para hacer la peticion
        $idDeportista = array_shift($campos_modificados);

        // llamo al metodo de actualizacion pasando el id y los campos a modificar
        $deportistasController->updateDeportista($idDeportista , $campos_modificados);
        // redirijo a la pagina principal
        header('Location: ../public/deportistas.php');

    } else{
        // capturo los datos especificos del formulario de creacion
        $datosDeportista = [
            'nombre' => $_POST['nombre'],
            'apellido1' => $_POST['apellido1'],
            'apellido2' => $_POST['apellido2'],
            'fechanacimiento' => date('Y-m-d\TH:i:s\Z', strtotime($_POST['fechanacimiento'])),
            'deporte' => $_POST['deporte'],
            'club' => $_POST['club']
        ];

        // llamo al metodo para crear un nuevo deportista y le paso los datos
        $resultado = $deportistasController->createDeportista($datosDeportista);

        // verifico si la operación fue exitosa
        if ($resultado) {
            // redirijo a la pagina principal
            header('Location: ../public/deportistas.php');
            exit();
        } else {
            // muestro un mensaje de error
            echo "Error al crear el deportista.";
        }
    }
}
