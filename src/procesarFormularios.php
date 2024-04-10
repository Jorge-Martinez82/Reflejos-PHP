<?php
require_once '../vendor/autoload.php';

use Jorgem\ProyectoReflejos\DeportistasController;

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
        $timestamp = strtotime($campos_modificados['fechanacimiento']);

// Formatear el timestamp
        $fechaFormateada = date('Y-m-d\TH:i:s\Z', $timestamp);

// Actualizar el array
        $campos_modificados['fechanacimiento'] = $fechaFormateada;

        $deportistasController = new DeportistasController();

        //$id = 'khB6n4AKGCbZUNYa0L8Z';
        //$array = [
        //    'nombre' => 'Sara',
        //    'apellido1' => 'Pa',
        //    'club' => 'ardoi'
        //];
        //// Llama al método para crear un nuevo deportista
        //$deportistasController->updateDeportista($id , $array);
        array_shift($campos_modificados);
        $idDeportista = array_shift($campos_modificados);

        $deportistasController->updateDeportista($idDeportista , $campos_modificados);
        header('Location: ../public/deportistas.php');
        // y así sucesivamente...
    } else{
        // Capturar los datos específicos del formulario de creación
        // Aquí puedes hacer lo que necesites con los datos del formulario de creación
        $nombre = $_POST['nombre'];
        $apellido1 = $_POST['apellido1'];
        $apellido2 = $_POST['apellido2'];
        $fechanacimiento = date('Y-m-d\TH:i:s\Z', strtotime($_POST['fechanacimiento']));
        $deporte = $_POST['deporte'];
        $club = $_POST['club'];

        // Instancia el controlador de deportistas
        $deportistasController = new DeportistasController();

        // Llama al método para crear un nuevo deportista
        $resultado = $deportistasController->createDeportista([
            'nombre' => $nombre,
            'apellido1' => $apellido1,
            'apellido2' => $apellido2,
            'fechanacimiento' => $fechanacimiento,
            'deporte' => $deporte,
            'club' => $club
        ]);

        // Verifica si la operación fue exitosa
        if ($resultado) {
            // Redirige a una página de éxito o muestra un mensaje de éxito
            header('Location: ../public/deportistas.php');
            exit();
        } else {
            // Muestra un mensaje de error
            echo "Error al crear el deportista.";
        }
    }
}
