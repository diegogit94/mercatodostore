<?php

namespace App\Library;

use App\Order;
use App\Product;
use App\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

/**
 * Class PlaceToPayConnection
 * @package App\Library
 */
class PlaceToPayConnection
{
    public $response;
    public $auth;

    /**
     * @return Application|RedirectResponse|Redirector
     * @throws \Exception
     */
    public function connect()
    {
        $this->authentication();
        return $this->createRequest();
    }

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
     * @return Application|RedirectResponse|Redirector
     */
    public function createRequest(): RedirectResponse
    {
        $reference = uniqid();

        $this->response = Http::post(env('PLACETOPAY_BASE_URL'), [
            'auth' => $this->auth,
            'payment' => ['reference' => $reference,
                'description' => 'description test',
                'amount' => ['currency' => "COP", 'total' => Cart::total()]
//                'amount' => ['currency' => "COP", 'total' => 15000] //valor para pruebas con tinker
            ],
            'expiration' => date('c', strtotime("+3 days")),
            'returnUrl' => route('thankyou.index', "$reference"),
            'ipAddress' => request()->server('SERVER_ADDR'),
            'userAgent' => request()->server('HTTP_USER_AGENT')
        ]);

        foreach (Cart::content() as $item)
        {
            $products[] = $item->name;
        }

        Order::create([
            'user_id' => Auth::id(),
            'request_id' => $this->response['requestId'],
            'reference' => $reference,
            'description' => $products,
            'total' => Cart::total(),
        ]);

//        return $this->response->json();
        return redirect($this->response['processUrl']);
    }

    /**
     * Makes a post request to p2p to consult the information of the user's transaction
     * @return array|mixed
     * @throws \Exception
     */
    public function getRequestInformation(): array
    {
        $requestId = Order::where('user_id', Auth::id())
            ->where('reference', getUrlReference())
            ->get()->toArray();

        $requestId = $requestId['0']['request_id'];

        $response = Http::post(env('PLACETOPAY_BASE_URL') . "$requestId", [
            'auth' => $this->authentication(),
        ]);

        DB::table('orders')
            ->where('reference', getUrlReference())
            ->update(['transaction_information' => $response]);

        DB::table('orders')
            ->where('reference', getUrlReference())
            ->update(['status' => $response['status']['status']]);

        return $response->json();
    }

    /**
     * @param Order $order
     * @return array|mixed
     * @throws \Exception
     */
    public function retryPayment(Order $order)
    {
        $response = Http::post(env('PLACETOPAY_BASE_URL'), [
            'auth' => $this->authentication(),
            'payment' => ['reference' => $order['reference'],
                'description' => implode($order['description']),
                'amount' => ['currency' => "COP", 'total' => $order['total']]
            ],
            'expiration' => date('c', strtotime("+3 days")),
            'returnUrl' => route('thankyou.index',  $order['reference']),
            'ipAddress' => request()->server('SERVER_ADDR'),
            'userAgent' => request()->server('HTTP_USER_AGENT')
        ]);

        return $response->json();
    }
}
