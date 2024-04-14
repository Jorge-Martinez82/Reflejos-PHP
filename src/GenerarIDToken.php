<?php

namespace Jorgem\ProyectoReflejos;
use Symfony\Component\HttpClient\HttpClient;
require_once 'config.php';


class GenerarIDToken
{
    public function generarToken(){

        $client = HttpClient::create();

        $url = 'https://identitytoolkit.googleapis.com/v1/accounts:signInWithPassword?key=' . FIRESTORE_API_KEY;

        $data = [
            'email' => $_SESSION['usuario'],
            'password' => $_SESSION['contraseña'],
            'returnSecureToken' => true,
        ];

        $headers = [
            'Content-Type' => 'application/json',
        ];

        $body = json_encode($data);

        try {
            $response = $client->request('POST', $url, [
                'headers' => $headers,
                'body' => $body,
            ]);

            if ($response->getStatusCode() === 200) {
                $responseData = json_decode($response->getContent(), true);
                $_SESSION['idToken'] = $responseData['idToken'];
//                echo 'ID Token: ' . $responseData['idToken'];
//                echo '<br>Refresh Token: ' . $responseData['refreshToken']; // Optional, depending on your needs
            } else {
                echo 'Error: ' . $response->getStatusCode() . ' - ' . $response->getContent();
            }
        } catch (ClientException $e) {
            echo 'Exception: ' . $e->getMessage();
        }


    }
}