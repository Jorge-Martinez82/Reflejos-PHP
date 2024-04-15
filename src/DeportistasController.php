<?php
namespace Jorgem\ProyectoReflejos;
require_once 'config.php'; // usare config para leer sus variables globales

use DateTime; // clase para trabajar con el formato de la fecha de nacimiento
use Symfony\Component\HttpClient\HttpClient; // utilizo la clase HttpClient para realizar las peticiones
class DeportistasController {


    // metodo que crea y devuelve el codigo HTML que incluira la informacion de los deportistas de la BD
    public function getDeportistas() {

        $url = FIRESTORE_URL . 'deportistas'; // creo la url que apunta a la coleccion
        $client = HttpClient::create(); // creo un nuevo cliente http
        // realizo una solicitud GET a la url
        $response = $client->request('GET', $url , [
            'headers' => [
                // debo incluir el idToken que generé con la clase GenerarIdToken en ValidarUsuario
                // para tener autorizacion a hacer la peticion
                'Authorization' => 'Bearer ' . $_SESSION['idToken']
            ],
        ]);
        // obtengo el contenido de la respuesta en formato JSON y lo transformo en array
        $data = $response->toArray();

        $html = ''; // creo la variable HTML fuera del bucle
        $html .= "<table class='table mt-2'>"; // creo una tabla que contendra la informacion

        // creo el fragmento HTML por cada deportista y lo concateno con el siguiente
        foreach ($data['documents'] as $deportista) {
            // transformo los datos a JSON para enviarlos despues en modificar
            $jsonDeportista = json_encode($deportista);
            // para obtener el ID debo extraerlo del campo 'name', divido y obtengo el ID de su campo en el JSON
            $parts = explode('/', $deportista['name']);
            $deportistaId = end($parts);

            $html .= "<thead class='bg-info'>\n";
            $html .= "<tr>\n";
            $html .= "<th scope='col' style='width:22rem;'>".$deportista['fields']['nombre']['stringValue'] ." "
                . $deportista['fields']['apellido1']['stringValue']." "
                . $deportista['fields']['apellido2']['stringValue'] ."</th>\n";
            $html .= "<th scope='col' class='text-right'>\n";
            $html .= "</th></tr>\n";
            $html .= "</thead>\n";
            // la fecha de la BD la formateo a d/m/Y
            $fechaNacimiento = new DateTime($deportista['fields']['fechanacimiento']['timestampValue']);
            $fechaNacimientoFormateada = $fechaNacimiento->format('d/m/Y');
            $html .= "<tr><td><strong>Fecha de nacimiento:</strong></td><td>" . $fechaNacimientoFormateada . "</td></tr>";
            $html .= "<tr><td><strong>Deporte:</strong></td><td>" . $deportista['fields']['deporte']['stringValue'] . "</td></tr>";
            $html .= "<tr><td><strong>Club:</strong></td><td>" . $deportista['fields']['club']['stringValue'] . "</td></tr>";

            // Codigo que obtiene la histaria clinica. Descartado por falta de tiempo
//            $lesion = (function($deportista) {
//                $url = 'https://firestore.googleapis.com/v1/' . $deportista['fields']['historiaclinica']['arrayValue']['values'][0]['referenceValue'];
//                $client = HttpClient::create();
//                $response = $client->request('GET', $url , [
//                    'headers' => [
//                        'Authorization' => 'Bearer ' . $_SESSION['idToken']
//                    ],
//                ]);
//                $data = $response->toArray();
//                return ($data['fields']['descripcion']['stringValue']);
//            })($deportista);
            //$html .= "<tr><td><strong>Lesion:</strong></td><td>" . $lesion . "</td></tr>";

            // creo formularios con campo oculto para eliminar y modificar
            $html .= "<tr><td></td><td>
                <div class='d-flex justify-content-end'>
                    <form method='POST' class='mr-2'>
                        <input type='hidden' name='deportistaId' value='{$deportistaId}'>
                        <button class='btn btn-outline-danger btn-sm' type='submit' onclick=\"return confirm('¿Borrar Deportista?')\">Eliminar</button>
                    </form>
                    <form method='POST' action='modificarDeportista.php'>
                        <input type='hidden' name='deportista' value='".$jsonDeportista."'>
                        <button class='btn btn-outline-warning btn-sm' type='submit'>Modificar</button>
                    </form>
                </div>
              </td></tr>";

        }

        $html .= "</table>";
        return $html;
    }

    // Función para crear un nuevo usuario
    public function createDeportista($userData) {
        // creo la url y el cliente
        $url = FIRESTORE_URL . 'deportistas';
        $client = HttpClient::create();
        // construyo los datos del nuevo deportista en el formato que necesita la peticion POST
        $deportistaData = [
            'fields' => [
                'nombre' => ['stringValue' => $userData['nombre']],
                'apellido1' => ['stringValue' => $userData['apellido1']],
                'apellido2' => ['stringValue' => $userData['apellido2'] ?? ''],
                'fechanacimiento' => ['timestampValue' => $userData['fechanacimiento']],
                'deporte' => ['stringValue' => $userData['deporte']],
                'club' => ['stringValue' => $userData['club'] ?? ''],
            ]
        ];
        // convierto los datos a JSON
        $jsonData = json_encode($deportistaData, JSON_UNESCAPED_UNICODE);

        // realizo una solicitud POST a la URL de Firestore para agregar un nuevo documento a la colección de deportistas
        $response = $client->request('POST', $url , [
            'headers' => [
                'Content-Type' => 'application/json',
                // incluyo el idToken como autorizacion
                'Authorization' => 'Bearer ' . $_SESSION['idToken']
            ],
            'body' => $jsonData, // incluyo los datos
        ]);

        if ($response->getStatusCode() === 200) {
            // el deportista se creó exitosamente
            return true;
        } else {
            // devuelve false si ha habido error
            return false;
        }
    }


    // metodo para actualizar la informacion de un usuario
    public function updateDeportista($userId, $newDeportistaData) {
        // inicializo la cadena para la url
        $updateMaskFields = '';
        // voy añadiendo la sintaxis updateMask a la cadena por cada dato
        foreach ($newDeportistaData as $key => $value) {
            $updateMaskFields .= "&updateMask.fieldPaths={$key}";
        }
        // inicializo el array para crear el JSON en el formato que necesito
        $jsonArray = [
            'fields' => []
        ];
        // recorro el array de datos y los voy introduciendo en en array JSON
        foreach ($newDeportistaData as $key => $value) {
            if ($key === 'fechanacimiento') { // si el dato es la fecha tendre que utilizar 'tiemstampValue
                $jsonArray['fields'][$key] = [
                    'timestampValue' => $value,
                ];
            } else {
                $jsonArray['fields'][$key] = [
                    'stringValue' => $value,
                ];
            }
        }
        // Creo el JSON usando el array
        $json = json_encode($jsonArray, JSON_PRETTY_PRINT);
        // inicio la url
        $url = FIRESTORE_URL . 'deportistas/';
        // creo la url final añadiendo el id a modificar y la sintaxis que me pide Firebase
        $urlfinal = $url . $userId . '?currentDocument.exists=true' . $updateMaskFields;
        $client = HttpClient::create();
        // hago la peticion con todos los datos que necesito
        $response = $client->request('PATCH', $urlfinal, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $_SESSION['idToken']
            ],
            'body' => $json,
        ]);
        if ($response->getStatusCode() === 204) {
            return true;
        } else {
            return false;
        }
    }

    // Función para eliminar un usuario por su ID
    public function deleteDeportista($deportistaId) {
        $url = FIRESTORE_URL . 'deportistas/';
        $client = HttpClient::create();

        // Realizar una solicitud DELETE a la URL de Firestore para eliminar el deportista
        $response = $client->request('DELETE', $url . $deportistaId, [
            'headers' => [
                'Authorization' => 'Bearer ' . $_SESSION['idToken']
            ],
        ]);

        // Verificar si la operación fue exitosa
        if ($response->getStatusCode() === 204) {
            return true; // Éxito
        } else {
            return false; // Error
        }
    }
}
