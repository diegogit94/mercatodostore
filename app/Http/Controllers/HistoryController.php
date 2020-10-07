<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class HistoryController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->get();

        return view('history', ['orders' => $orders]);
    }

    public function retryPayment(Order $order)
    {
        $retry = Order::where('user_id', Auth::id())
            ->where('request_id', $order->request_id)
            ->where('reference', $order->reference)
            ->get();

        dd($retry);

        return $response = Http::post(env('PLACETOPAY_BASE_URL') . $order->request_id . "/" . $order->reference );
    }
}
