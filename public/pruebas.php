<?php
session_start();
require_once '../vendor/autoload.php';
use Symfony\Component\HttpClient\HttpClient;

$url = 'https://firestore.googleapis.com/v1/projects/proyectoreflejos-314e8/databases/(default)/documents/historiaclinica/ZOLBkUNIKDObzJupEUH9';
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
print_r($data['fields']['descripcion']['stringValue']);


