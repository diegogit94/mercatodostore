<?php

namespace App\Library;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Http;

class PlaceToPayConnection
{
    protected $response;
    protected $auth;

    public function connect()
    {
        $this->authentication();
        return $this->basicPay();
    }

    protected function authentication()
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
    }

    protected function basicPay()
    {
        $reference = uniqid();

        $this->response = Http::post('https://test.placetopay.com/redirection/api/session/', [
            'auth' => $this->auth,
            'payment' => ['reference' => $reference,
                'description' => 'description test',
                'amount' => ['currency' => "COP", 'total' => Cart::total()]
            ],
            'expiration' => date('c', strtotime("+6 minutes")),
            'returnUrl' => "http://mercatodo.test:8000/success/$reference", //resolver página de retorno
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'PlacetoPay Sandbox'
        ]);

        return redirect($this->response['processUrl']);
    }
}
