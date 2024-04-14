<?php
session_start();
require_once '../vendor/autoload.php';

use Jorgem\ProyectoReflejos\ProgramasController;

$programasController = new ProgramasController();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar de qué formulario provienen los datos
    if ($_POST['formulario'] === 'formularioModificar') {
        // Capturar los datos específicos del formulario de modificación
        $campos_modificados = array();
        // Recoger los campos que no están vacíos
        foreach ($_POST as $campo => $valor) {
            if (!empty($valor)) {
                // Guardar el nombre del campo modificado y su valor
                $campos_modificados[$campo] = $valor;
            }
        }
        array_shift($campos_modificados);
        $programaId = array_shift($campos_modificados);
        $programasController->updatePrograma($programaId , $campos_modificados);


        header('Location: ../public/programas.php');

    } else{
        // Capturar los datos específicos del formulario de creación
        // Aquí puedes hacer lo que necesites con los datos del formulario de creación
        $descripcion = $_POST['descripcion'];
        $distancia = $_POST['distancia'];
        $nciclos = $_POST['nciclos'];
        $tdescanso = $_POST['tdescanso'];
        $tejercicio = $_POST['tejercicio'];


        // Llama al método para crear un nuevo deportista
        $resultado = $programasController->createPrograma([
            'descripcion' => $descripcion,
            'distancia' => $distancia,
            'nciclos' => $nciclos,
            'tdescanso' => $tdescanso,
            'tejercicio' => $tejercicio
        ]);

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
