<?php

namespace App\Listeners;

use App\Order;
use App\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DiscountStockItemListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $order = Order::where('status', 'PENDING')->firstOrFail();

        $order->products->each(function ($product) {
            $product->decrement('quantity', $product->pivot->quantity);
        });
    }
}
