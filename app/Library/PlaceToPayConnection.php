<?php

namespace App\Library;

use App\Http\Requests\CheckoutRequest;
use App\Order;
use App\Product;
use App\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use GuzzleHttp\Psr7\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use phpDocumentor\Reflection\Types\Mixed_;
use Ramsey\Collection\Collection;

/**
 * Class PlaceToPayConnection
 * @package App\Library
 */
class PlaceToPayConnection
{
    public $response;
    public $auth;
    public $reference;

    /**
     * Generate all the authentication credentials
     * @return array
     * @throws \Exception
     */
    public function authentication(): array
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

    /**
     * Create a POST petition for P2P webcheckout and save the response on DB
     * @param float $total
     * @param $request
     * @return array|mixed
     */
    public function createRequest(float $total, $request): array //Tipo de dato del segundo parametro
    {
        $this->reference = uniqid();

        $this->response = Http::post(env('PLACETOPAY_BASE_URL'), [
            'auth' => $this->auth,
            'payment' => [
                'reference' => $this->reference,
                'description' => 'description test',
                'amount' => ['currency' => "COP", 'total' => $total]
            ],
            'buyer' => [
                'name' => $request['name'],
                'surname' => $request['last_name'],
                'email' => $request['email'],
                'documentType' => $request['document_type'],
                'document' => $request['document_number'],
                'mobile' => $request['phone'],
                'address' => [
                    'street' => $request['addresss'],
                    'city' => $request['city'],
                    'state' => $request['Province'],
                    'postalCode' => $request['postal_code'],
//                    'country' => 'US',
//                    'phone' => '363-547-1441 x383',
                ]],
            'expiration' => date('c', strtotime("+15 minutes")),
            'returnUrl' => route('thankyou.index', $this->reference),
            'ipAddress' => request()->ip(),
            'userAgent' => request()->server('HTTP_USER_AGENT')
        ]);

        return $this->response->json();
    }

    /**
     * @param $requestId
     * @return array|mixed
     * @throws \Exception
     */
    public function getRequestInformation($requestId): array
    {
        $response = Http::post(env('PLACETOPAY_BASE_URL') . "$requestId", [
            'auth' => $this->authentication(),
        ]);

        return $response->json();
    }
}
