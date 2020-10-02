<?php

namespace App\Library;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class PlaceToPayConnection
{
    public $response;
    public $auth;

    public function connect()
    {
        $this->authentication();
        return $this->createRequest();
    }

    public function authentication()
    {
        if (function_exists('random_bytes')) {
            $nonce = bin2hex(random_bytes(16));
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $nonce = bin2hex(openssl_random_pseudo_bytes(16));
        } else {
            $nonce = mt_rand();
        }

        $nonceBase64 = base64_encode($nonce);
        $seed = date('c');
        $secretKey = env('PLACETOPAY_SECRETKEY');
        $tranKey= base64_encode(sha1($nonce . $seed . $secretKey, true));

        $this->auth = [
            'login' => env('PLACETOPAY_LOGIN'),
            'seed' => $seed,
            'nonce' => $nonceBase64,
            'tranKey' => $tranKey
        ];

        return $this->auth;
    }

    public function createRequest()
    {
        $reference = uniqid();

        $this->response = Http::post('https://test.placetopay.com/redirection/api/session/', [
            'auth' => $this->auth,
            'payment' => ['reference' => $reference,
                'description' => 'description test',
//                'amount' => ['currency' => "COP", 'total' => Cart::total()]
                'amount' => ['currency' => "COP", 'total' => 15000] //valor para pruebas con tinker
            ],
            'expiration' => date('c', strtotime("+6 minutes")),
            'returnUrl' => "http://mercatodo.test:8000/success/$reference", //resolver página de retorno
            'ipAddress' => '127.0.0.1', //sacar de la peticion
            'userAgent' => 'PlacetoPay Sandbox' //sacar de la peticion, no quemar estos datos
        ]);

        return redirect($this->response['processUrl']);
    }

    public function getRequestInformation()
    {
        $requestId = $this->response['requestId'];

        $response = Http::post("https://test.placetopay.com/redirection/api/session/$requestId", [
            'auth' => $this->authentication(),
        ]);

        return $response['requestId'];
    }
}
