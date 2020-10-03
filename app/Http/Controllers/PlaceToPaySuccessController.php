<?php

namespace App\Http\Controllers;

use App\Library\PlaceToPayConnection;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PlaceToPaySuccessController extends Controller
{
    public function index()
    {
        $auth = new PlaceToPayConnection();

        $info = $auth->getRequestInformation();

        $url = request()->path();
        $parts = explode('/', $url);
        $reference = $parts[count($parts) -1];

        $order = Order::where('user_id', Auth::id())
            ->where('reference', $reference)
            ->get()->toArray();

        return $order;

//        return view('placeToPaySuccess', ['info' => $info]);
    }
}
