<?php

namespace App\Library;

use App\Order;
use App\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        $this->response = Http::post(env('PLACETOPAY_BASE_URL'), [
            'auth' => $this->auth,
            'payment' => ['reference' => $reference,
                'description' => 'description test',
                'amount' => ['currency' => "COP", 'total' => Cart::total()]
//                'amount' => ['currency' => "COP", 'total' => 15000] //valor para pruebas con tinker
            ],
            'expiration' => date('c', strtotime("+1 hour")),
            'returnUrl' => "http://mercatodo.test:8000/success/$reference",
            'ipAddress' => request()->server('SERVER_ADDR'),
            'userAgent' => request()->server('HTTP_USER_AGENT')
        ]);

        Order::create([
            'user_id' => Auth::id(),
            'request_id' => $this->response['requestId'],
            'reference' => $reference,
        ]);

//        return $this->response->json();
        return redirect($this->response['processUrl']);
    }

    public function getRequestInformation()
    {
        $url = request()->path();
        $parts = explode('/', $url);
        $reference = $parts[count($parts) -1];

        $requestId = Order::where('user_id', Auth::id())
            ->where('reference', $reference)
            ->get()->toArray();

        $requestId = $requestId['0']['request_id'];

        $response = Http::post(env('PLACETOPAY_BASE_URL') . "$requestId", [
            'auth' => $this->authentication(),
        ]);

        DB::table('orders')
            ->where('reference', $reference)
            ->update(['transaction_information' => $response]);

//        return redirect(route('placeToPaySuccess.index'))->with('transactionInformation', $transactionInformation);
        return $response->json();
    }
}
