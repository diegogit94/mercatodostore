<?php

namespace App\Http\Controllers;

use App\Library\PlaceToPayConnection;
use App\Order;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PlaceToPaySuccessController extends Controller
{
    public function index()
    {
        $auth = new PlaceToPayConnection();

        try {
            $auth->getRequestInformation();
        } catch (\Exception $e) {
        }

        $order = Order::where('user_id', Auth::id()) //Muestra solo los datos de la transacción que acaba de hacer el usuario
            ->where('reference', getUrlReference())
            ->get();

//        $order = Order::where('user_id', Auth::id())->get(); //Muestra todos los datos de las transacciones que ha hecho el usuario

//        return $order = $order[0]['transaction_information']['payment'][0]['status'];
//        return $order = $order[0]['transaction_information']['payment'][0];
//        return $order = $order[0]['transaction_information']['payment'][0]['amount'];
//        return $order = $order[0]['transaction_information']['payment'][0];

//        $options = $order->options; //Array casting

//        return $order[0]['transaction_information']; //Acceder a la información de la transacción desde la DB

        Cart::destroy();

        return view('thankyou', ['order' => $order]);
    }
}
