<?php

namespace Jorgem\ProyectoReflejos;
// necesitare importar la clase HttpClient de Symfony y el archivo config
use Symfony\Component\HttpClient\HttpClient;
require_once 'config.php';

class GenerarIDToken{
    public function generarToken(){
        // realizo una peticion a la url proporcionada por Firebase, en ella tengo que indicar
        // el email y el password del ususario y la API key de la base de datos. Firebase procesara
        // mi solicitud y en caso de ser exitosa me devolvera un tokenID que necesitare para realizar
        // las operaciones CRUD de la aplicacion

        $client = HttpClient::create();
        // url de la peticion
        $url = 'https://identitytoolkit.googleapis.com/v1/accounts:signInWithPassword?key=' . FIRESTORE_API_KEY;
        $data = [ // datos a pasar
            'email' => $_SESSION['usuario'],
            'password' => $_SESSION['contraseña'],
            'returnSecureToken' => true,
        ];
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $body = json_encode($data);

        try {
            // realizo la peticion
            $response = $client->request('POST', $url, [
                'headers' => $headers,
                'body' => $body,
            ]);

            if ($response->getStatusCode() === 200) {
                $responseData = json_decode($response->getContent(), true);
                // si es exitosa guardo el token devuelto en una variable de sesion
                $_SESSION['idToken'] = $responseData['idToken'];
            } else {
                echo 'Error: ' . $response->getStatusCode() . ' - ' . $response->getContent();
            }
        } catch (ClientException $e) {
            echo 'Exception: ' . $e->getMessage();
        }
    }
}