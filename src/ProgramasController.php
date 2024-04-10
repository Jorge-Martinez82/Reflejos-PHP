<?php

namespace Jorgem\ProyectoReflejos;
require_once 'config.php';
use Symfony\Component\HttpClient\HttpClient;

class ProgramasController{

    public function getProgramas(){
        $url = FIRESTORE_URL;
        $key = FIRESTORE_API_KEY;
        // Crear una instancia del cliente HTTP
        $client = HttpClient::create();

        // Realizar una solicitud GET a una URL
        $response = $client->request('GET', $url . 'programas' . $key);
        // Obtener el contenido de la respuesta en formato JSON
        return $response->toArray();

    }
}