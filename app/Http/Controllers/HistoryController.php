<?php

namespace App\Http\Controllers;

use App\Library\PlaceToPayConnection;
use App\Order;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use phpDocumentor\Reflection\DocBlock\Tags\Method;

class HistoryController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->paginate(8);

        return view('history', ['orders' => $orders]);
    }

    public function retryPayment(Order $order)
    {
        $retry = new PlaceToPayConnection();

        $retry->authentication();

        $response = $retry->createRequest($order['total']);

        DB::table('orders')->where('user_id', Auth::id())
        ->where('request_id', $order['request_id'])
        ->where('reference', $order['reference'])
            ->update(['user_id' => Auth::id(),
                'request_id' => $response['requestId'],
                'reference' => $retry->reference,]);

        return redirect($response['processUrl']);
    }
}
