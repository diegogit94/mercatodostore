<?php

namespace App\Http\Controllers;

use App\Library\PlaceToPayConnection;
use App\Order;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ThankYouController extends Controller
{
    public function index()
    {
        $requestId = Order::where('user_id', Auth::id())
            ->where('reference', getUrlReference())
            ->get();

        $info = new PlaceToPayConnection();

        $response = $info->getRequestInformation($requestId[0]['request_id']);

        DB::table('orders') //poner estos dos queries en uno solo
        ->where('reference', getUrlReference())
            ->update(['transaction_information' => $response, 'status' => $response['status']['status']]);

//        $status = Order::where('user_id', Auth::id()) //Muestra solo los datos de la transacción que acaba de hacer el usuario
//            ->where('reference', getUrlReference())
//            ->get();

        Cart::destroy();

        return view('thankyou', ['status' => $response['status']['status']]);
    }
}
