<?php

namespace App\Services;

use GuzzleHttp\Client;

class NetgsmSMS
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function send($number, $message)
    {
        $response = $this->client->post('https://api.netgsm.com.tr/sms/send/get', [
            'form_params' => [
                'usercode' => config('services.netgsm.username'),
                'password' => config('services.netgsm.password'),
                'msgheader' => config('services.netgsm.header'),
                'gsmno' => $number,
                'message' => $message,
                'startdate' => '',
                'stopdate' => '',
                'dil' => 'TR',
                'bayikodu' => '',
                'filter' => '',
                'type' => '',
                'msgfilter' => '',
                'encoding' => '',
                'username' => '',
                'orgin' => config('services.netgsm.originator'),
            ],
        ]);

        return $response->getBody()->getContents();
    }
}
