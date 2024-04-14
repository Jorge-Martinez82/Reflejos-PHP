<?php

namespace Jorgem\ProyectoReflejos;
require_once 'config.php';
use Symfony\Component\HttpClient\HttpClient;

class ProgramasController{

    public function getProgramas(){
        $url = FIRESTORE_URL . 'programas';
        // Crear una instancia del cliente HTTP
        $client = HttpClient::create();

        // Realizar una solicitud GET a una URL
        $response = $client->request('GET', $url , [
            'headers' => [
                'Authorization' => 'Bearer ' . $_SESSION['idToken']
            ],
        ]);
        // Obtener el contenido de la respuesta en formato JSON
        $data = $response->toArray();

        $html = ''; // Inicializa la variable HTML fuera del bucle
        $html .= "<table class='table mt-2'>"; // Inicia la tabla

        foreach ($data['documents'] as $programa) {
            $jsonPrograma = json_encode($programa);
            $parts = explode('/', $programa['name']);
            $programaId = end($parts);
            // Agrega una fila para cada campo del deportista

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

            // Agrega más filas aquí si es necesario
        }

        $html .= "</table>";
        return $html;


    }

    public function createPrograma($programaData){
        $url = FIRESTORE_URL . 'programas';

        // Crear una instancia del cliente HTTP
        $client = HttpClient::create();
        // Construir los datos del nuevo deportista
        $programaNewData = [
            'fields' => [
                'descripcion' => ['stringValue' => $programaData['descripcion']],
                'distancia' => ['integerValue' => $programaData['distancia']],
                'nciclos' => ['integerValue' => $programaData['nciclos'] ?? ''],
                'tdescanso' => ['integerValue' => $programaData['tdescanso']],
                'tejercicio' => ['integerValue' => $programaData['tejercicio'] ?? ''],
            ]
        ];
        $jsonData = json_encode($programaNewData, JSON_UNESCAPED_UNICODE);

        // Realizar una solicitud POST a la URL de Firestore para agregar un nuevo documento a la colección de deportistas
        $response = $client->request('POST', $url , [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $_SESSION['idToken']
            ],
            'body' => $jsonData,
        ]);

        // Verificar el código de respuesta
        if ($response->getStatusCode() === 200) {
            // El deportista se creó exitosamente
            return true;
        } else {
            // Ocurrió un error al crear el deportista
            return false;
        }
    }

    public function updatePrograma($programaId, $newProgramData){
// Implementa la lógica para actualizar la información de un usuario en la base de datos

        $updateMaskFields = '';

        foreach ($newProgramData as $key => $value) {
            $updateMaskFields .= "&updateMask.fieldPaths={$key}";
        }

        $jsonArray = [
            'fields' => []
        ];
        foreach ($newProgramData as $key => $value) {
            if ($key === 'descripcion') {
                $jsonArray['fields'][$key] = [
                    'stringValue' => $value,
                ];
            } else {
                $jsonArray['fields'][$key] = [
                    'integerValue' => $value,
                ];
            }
        }

        $json = json_encode($jsonArray, JSON_PRETTY_PRINT);
        echo $json;

        $url = FIRESTORE_URL . 'programas/';
        $urlfinal = $url . $programaId . '?currentDocument.exists=true' . $updateMaskFields;
        $client = HttpClient::create();

        $response = $client->request('PATCH', $urlfinal, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $_SESSION['idToken']
            ],
            'body' => $json,
        ]);
        if ($response->getStatusCode() === 204) {
            return true; // Éxito
        } else {
            return false; // Error
        }
    }

    public function deletePrograma($programaId){
        $url = FIRESTORE_URL . 'programas/';
        $client = HttpClient::create();

        // Realizar una solicitud DELETE a la URL de Firestore para eliminar el deportista
        $response = $client->request('DELETE', $url . $programaId, [
            'headers' => [
                'Content-Type' => 'application/json',
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