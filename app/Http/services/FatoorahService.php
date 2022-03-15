<?php


namespace App\Http\Services;


//use http\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;


class FatoorahService
{
    private $base_url;
    private $headers;
    private $request_client;



    public function __construct(Client $request_client)
    {
        $this->request_client = $request_client;


        $this->base_url = env('fatoorah_base_url');
        $this->headers = [
            'authorization' => 'Bearer ' . env('fatoorah_token'),
            'Content-Type' => 'application/json',
        ];


    }

    private function buildRequest($uri, $method, $data = [])
    {


        $request = new Request($method, $this->base_url . $uri, $this->headers);

       if (!$data)
           return false;

        $response = $this->request_client->send($request, [
            'json' => $data
        ]);
       if ($response->getStatusCode() != 200){
           return false;
       }
        $response = json_decode($response->getBody(), true);

        return $response;
    }

    public function sendPayment($data)
    {

        return $response = $this->buildRequest('v2/SendPayment', 'POST', $data);
//       if ($response)
//            $this->saveTransacionPayment($patient_id, $response['Data']['InvoiceId']);
//



    }

    public function getPaymentStatus($data)
    {

        return $response = $this->buildRequest('v2/getPaymentStatus', 'POST', $data);

    }


}