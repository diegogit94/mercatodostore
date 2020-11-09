<?php

namespace App\Http\Controllers;

use App\Library\PlaceToPayConnection;
use App\Order;
use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ThankYouController extends Controller
{
    public const STATUS_APPROVED = "APPROVED";

    public function index(string $reference)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('reference', $reference)
            ->firstOrFail();

        $info = new PlaceToPayConnection();

        $response = $info->getRequestInformation($order['request_id']);

//        $order->update(['transaction_information' => $response, 'status' => $response['status']['status']]);

        DB::table('orders')
        ->where('reference', getUrlReference())
            ->update(['transaction_information' => $response, 'status' => $response['status']['status']]);

        if ($response['status']['status'] == self::STATUS_APPROVED && $order->status != self::STATUS_APPROVED) {

            $order->products->each(function ($product) {
                $product->decrement('quantity', $product->pivot->quantity);
            });
        }

        Cart::destroy();

        return view('thankyou', ['status' => $response['status']['status']]);
    }
}
