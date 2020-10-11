<?php

namespace App\Http\Controllers;

use App\Library\PlaceToPayConnection;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use phpDocumentor\Reflection\DocBlock\Tags\Method;

class HistoryController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->get();

        return view('history', ['orders' => $orders]);
    }

    /**
     * @param Order $order
     * @return array|mixed
     * @throws \Exception
     */
    public function retryPayment(Order $order): array
    {
        $retry = new PlaceToPayConnection();

        return $retry->retryPayment($order);
    }
}
