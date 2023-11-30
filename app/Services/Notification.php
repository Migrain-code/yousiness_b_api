<?php
namespace App\Services;

use GuzzleHttp\Client;

class Notification{



    private $client;
    private $firebaseApiKey;
    private $firebaseProjectId;
    private $firebaseSenderId;

    public function __construct()
    {
        $this->client = new Client();
        $this->firebaseApiKey = env('FIREBASE_API_KEY');
        $this->firebaseProjectId = env('FIREBASE_PROJECT_ID');
        $this->firebaseSenderId = env('FIREBASE_SENDER_ID');
    }

    public function sendPushNotification($deviceToken, $title, $body)
    {

        $url = "https://fcm.googleapis.com/fcm/send";
        $headers = [
            'Authorization' => 'key=' . $this->firebaseApiKey,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $data = [
            'to' => $deviceToken,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
        ];

        $response = $this->client->post($url, [
            'headers' => $headers,
            'json' => $data,
        ]);

        $statusCode = $response->getStatusCode();
        $result = $response->getBody();
        if ($statusCode){
            return true;
        } else{
            return false;
        }
        // İşlemlerinizi gerçekleştirin
    }

}