<?php

namespace App\Http\Controllers;

use App\Library\PlaceToPayConnection;
use App\Order;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ThankYouController extends Controller
{
    public function index()
    {
        $info = new PlaceToPayConnection();

        try {
            $info->getRequestInformation();
        } catch (\Exception $e) {
        }

        $status = Order::where('user_id', Auth::id()) //Muestra solo los datos de la transacción que acaba de hacer el usuario
            ->where('reference', getUrlReference())
            ->get();

        Cart::destroy();

        return view('thankyou', ['status' => $status]);
    }
}
