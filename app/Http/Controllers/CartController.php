<?php

namespace App\Http\Controllers;

use Melihovv\ShoppingCart\Facades\ShoppingCart as Cart;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('store.cart');
    }

    public function store(Request $request)
    {
        Cart::add($request->id, $request->name, $request->price, 1);

        return redirect()->route('cart.index')->with('success_message', 'Item añadido a tu carrito');
    }
}
