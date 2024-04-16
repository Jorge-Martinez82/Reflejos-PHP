<?php

namespace Jorgem\ProyectoReflejos;
require_once 'config.php'; // añado config y el cliente http
use Symfony\Component\HttpClient\HttpClient;

class ProgramasController{

    // metodo que crea y devuelve el codigo HTML que incluira la informacion de los programas de la BD
    public function getProgramas(){
        $url = FIRESTORE_URL . 'programas'; // creo la url que apunta a la coleccion
        // creo una instancia del cliente HTTP
        $client = HttpClient::create();

        // realizo la solicitud GET a una URL
        $response = $client->request('GET', $url , [
            'headers' => [
                // debo incluir el idToken que generé con la clase GenerarIdToken en ValidarUsuario
                // para tener autorizacion para hacer la peticion
                'Authorization' => 'Bearer ' . $_SESSION['idToken']
            ],
        ]);
        // obtengo el contenido de la respuesta en formato JSON
        $data = $response->toArray();

        $html = ''; // creo la variable con la cadena a devolver
        $html .= "<table class='table mt-2'>"; // inicio la tabla
        // creo el fragmento HTML por cada programa y lo concateno con el siguiente
        foreach ($data['documents'] as $programa) {
            // transformo los datos a JSON para enviarlos despues en modificar
            $jsonPrograma = json_encode($programa);
            // para obtener el ID debo extraerlo del campo 'name', divido y obtengo el ID de su campo en el JSON
            $parts = explode('/', $programa['name']);
            $programaId = end($parts);

            // agrego el fragmento de HTML por cada programa
            $html .= "<thead class='bg-success'>\n";
            $html .= "<tr>\n";
            $html .= "<th scope='col' style='width:22rem;'>".$programa['fields']['descripcion']['stringValue']."</th>\n";
            $html .= "<th scope='col' class='text-right'>\n";
            $html .= "</th></tr>\n";
            $html .= "</thead>\n";
            $html .= "<tr><td><strong>Distancia:</strong></td><td>" . $programa['fields']['distancia']['integerValue'] . "</td></tr>";
            $html .= "<tr><td><strong>Nciclos:</strong></td><td>" . $programa['fields']['nciclos']['integerValue'] . "</td></tr>";
            $html .= "<tr><td><strong>Tdescanso:</strong></td><td>" . $programa['fields']['tdescanso']['integerValue'] . "</td></tr>";
            $html .= "<tr><td><strong>Tejercicio:</strong></td><td>" . $programa['fields']['tejercicio']['integerValue'] . "</td></tr>";
            $html .= "<tr><td></td><td>
                <div class='d-flex justify-content-end'>
                    <form method='POST' class='mr-2'>
                        <input type='hidden' name='programaId' value='{$programaId}'>
                        <button class='btn btn-outline-danger btn-sm' type='submit' onclick=\"return confirm('¿Borrar Programa?')\">Eliminar</button>
                    </form>
                    <form method='POST' action='modificarPrograma.php'>
                        <input type='hidden' name='programa' value='".$jsonPrograma."'>
                        <button class='btn btn-outline-warning btn-sm' type='submit'>Modificar</button>
                    </form>
                </div>
              </td></tr>";
        }
        $html .= "</table>";
        return $html;
    }

    // metodo para crear un programa
    public function createPrograma($programaData){
        $url = FIRESTORE_URL . 'programas';
        $client = HttpClient::create();
        // construyo los datos del nuevo programa
        $newProgramaData = [
            'fields' => [
                'descripcion' => ['stringValue' => $programaData['descripcion']],
                'distancia' => ['integerValue' => $programaData['distancia']],
                'nciclos' => ['integerValue' => $programaData['nciclos'] ?? ''],
                'tdescanso' => ['integerValue' => $programaData['tdescanso']],
                'tejercicio' => ['integerValue' => $programaData['tejercicio'] ?? ''],
            ]
        ];
        // codifico e formato JSON
        $jsonData = json_encode($newProgramaData, JSON_UNESCAPED_UNICODE);

        // realizo la solicitud POST a la URL de Firestore para agregar un nuevo documento a la colección de programas
        $response = $client->request('POST', $url , [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $_SESSION['idToken']
            ],
            'body' => $jsonData,
        ]);
        if ($response->getStatusCode() === 200) {
            return true;
        } else {
            return false;
        }
    }

    public function updatePrograma($programaId, $newProgramData){
        $updateMaskFields = '';// inicializo la cadena para incluir en la url
        // voy añadiendo la sintaxis updateMask a la cadena por cada dato
        foreach ($newProgramData as $key => $value) {
            $updateMaskFields .= "&updateMask.fieldPaths={$key}";
        }
        // inicializo el array para crear el JSON en el formato que necesito
        $jsonArray = [
            'fields' => []
        ];
        // recorro el array de datos y los voy introduciendo en en array JSON
        foreach ($newProgramData as $key => $value) {
            if ($key === 'descripcion') { // para descripcion cambia el formato de dato
                $jsonArray['fields'][$key] = [
                    'stringValue' => $value,
                ];
            } else {
                $jsonArray['fields'][$key] = [
                    'integerValue' => $value,
                ];
            }
        }
        // creo el JSON usando el array
        $json = json_encode($jsonArray, JSON_PRETTY_PRINT);

        $url = FIRESTORE_URL . 'programas/';// inicio la url
        // creo la url final añadiendo el id a modificar y la sintaxis que me pide Firebase
        $urlfinal = $url . $programaId . '?currentDocument.exists=true' . $updateMaskFields;
        $client = HttpClient::create();
        $response = $client->request('PATCH', $urlfinal, [ // hago la peticion con todos los datos que necesito
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

    // Función para eliminar un programa por su ID
    public function deletePrograma($programaId){
        $url = FIRESTORE_URL . 'programas/';
        $client = HttpClient::create();
        // realizo una solicitud DELETE a la URL de Firestore para eliminar el deportista
        $response = $client->request('DELETE', $url . $programaId, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $_SESSION['idToken']
            ],
        ]);

        if ($response->getStatusCode() === 204) {
            return true;
        } else {
            return false;
        }
    }
}