<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
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
        $cart = Cart::instance();

        return view('store.cart', [
            'cart' => $cart
        ]);
    }

    public function store(Request $request)
    {
        $duplicates = Cart::search(function ($cartItem, $rowId) use ($request)
        {
            return $cartItem->id === $request->id;
        });

        if ($duplicates->isNotEmpty())
        {
            return redirect()->route('cart.index')->with('success_message', 'Ya tienes este producto en tu carrito');
        }

        Cart::add($request->id, $request->name, 1, $request->price)
            ->associate('App\Product');

        return redirect()->route('cart.index')->with('success_message', 'Item añadido a tu carrito');
    }

    public function remove($rowId)
    {
        Cart::remove($rowId);

        return back()->with('success_message', 'Producto eliminado');
    }

    public function update(Request $request, $id)
    {
        Cart::update($id, $request->quantity);
        session()->flash('success_message', 'Cantidad actualizada con exito!');

        return response()->json(['success' => true]);
    }
}
