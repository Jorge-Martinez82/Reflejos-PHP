<?php
session_start();
require_once '../vendor/autoload.php';

use Jorgem\ProyectoReflejos\ProgramasController;

$programasController = new ProgramasController();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // verifico de que formulario provienen los datos
    if ($_POST['formulario'] === 'formularioModificar') {
        // creo el array que contendra solo los campos modificados
        $campos_modificados = array();
        // añado al array los campos modificados
        foreach ($_POST as $campo => $valor) {
            if (!empty($valor)) {
                // guardo el nombre del campo modificado y su valor
                $campos_modificados[$campo] = $valor;
            }
        }
        // extraigo el primer valor del array (nombre del formulario) que ya no necesito
        array_shift($campos_modificados);
        // extraido y guardo el id que utilizare para hacer la peticion
        $programaId = array_shift($campos_modificados);
        // llamo al metodo de actualizacion pasando el id y los campos a modificar
        $programasController->updatePrograma($programaId , $campos_modificados);
        // redirijo a la pagina principal
        header('Location: ../public/programas.php');

    } else{
        // capturo los datos específicos del formulario de creación
        $datosPrograma = [
            'descripcion' => $_POST['descripcion'],
            'distancia' => $_POST['distancia'],
            'nciclos' => $_POST['nciclos'],
            'tdescanso' => $_POST['tdescanso'],
            'tejercicio' => $_POST['tejercicio']
        ];

        // llamo al metodo para crear un nuevo programa
        $resultado = $programasController->createPrograma($datosPrograma);


        // Verifica si la operación fue exitosa
        if ($resultado) {
            // Redirige a una página de éxito o muestra un mensaje de éxito
            header('Location: ../public/programas.php');
            exit();
        } else {
            // Muestra un mensaje de error
            echo "Error al crear el programa.";
        }
    }
}
