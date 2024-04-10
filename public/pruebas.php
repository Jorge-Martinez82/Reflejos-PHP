<?php
require_once '../vendor/autoload.php';
use Symfony\Component\HttpClient\HttpClient;

//https://firestore.googleapis.com/v1beta1/projects/proyectoreflejos-314e8/databases/(default)/documents/deportistas/1?key=[YOUR_API_KEY]
$url = 'https://firestore.googleapis.com/v1beta1/projects/proyectoreflejos-314e8/databases/(default)/documents/deportistas/';
$key = '?key=AIzaSyAC-tLkSIq8otkvLp3mOemyelvd5QMwElo';

// Crear una instancia del cliente HTTP
$client = HttpClient::create();

// Construir los datos del nuevo deportista
$deportistaData = [
    'fields' => [
        'nombre' => ['stringValue' => 'aaaaa'],
        'apellido1' => ['stringValue' => 'Apellido 1 del deportista'],
        'apellido2' => ['stringValue' => 'Apellido 2 del deportista'],
        'fechanacimiento' => ['timestampValue' => '1980-01-01T00:00:00Z'],
        'deporte' => ['stringValue' => 'Deporte del deportista'],
        'club' => ['stringValue' => 'Club del deportista']
    ]
];

$jsonData = json_encode($deportistaData, JSON_UNESCAPED_UNICODE);

// Realizar una solicitud POST a la URL de Firestore para agregar un nuevo documento a la colección de deportistas
$response = $client->request('POST', $url, [
    'headers' => [
        'Content-Type' => 'application/json',
    ],
    'body' => $jsonData,
]);
