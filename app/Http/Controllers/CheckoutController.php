<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): view
    {
        $cart = Cart::instance();

        return view('store.checkout',[
            'cart' => $cart
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function edit(int $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy(int $id)
    {
        //
    }

    public function placeToPayCheckout()
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

        $auth = [
            'login' => env('PLACETOPAY_LOGIN'),
            'seed' => $seed,
            'nonce' => $nonceBase64,
            'tranKey' => $tranKey
        ];

        $data = [
            'auth' => $auth,

            'payment' => ['reference' => uniqid(),
                          'description' => 'description test',
                          'amount' => ['currency' => "COP", 'total' => Cart::total()]
            ],

            'expiration' => date('c', strtotime("+5 minutes")),
            'returnUrl' => 'https://mercatodo.test/placeToPaySuccess/{reference}', //crear página de pago exitoso
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'PlacetoPay Sandbox'
        ];
        
        $response = Http::post('https://test.placetopay.com/redirection/api/session/', [
            'auth' => $auth,
            'payment' => ['reference' => uniqid(),
                'description' => 'description test',
                'amount' => ['currency' => "COP", 'total' => Cart::total()]
            ],
            'expiration' => date('c', strtotime("+6 minutes")),
            'returnUrl' => 'https://mercatodo.test/checkout/{reference}', //resolver página de retorno
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'PlacetoPay Sandbox'
        ]);

        return redirect($response['processUrl']);
    }
}
