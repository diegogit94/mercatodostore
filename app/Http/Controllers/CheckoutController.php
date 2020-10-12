<?php

namespace App\Http\Controllers;

use App\Library\PlaceToPayConnection;
use App\Order;
use Dnetix\Redirection\PlacetoPay;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class   CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): view
    {
        $cart = Cart::instance();

        return view('store.checkout',[
            'cart' => $cart
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function edit(int $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy(int $id)
    {
        //
    }

    /**
     * @return Application|RedirectResponse|Redirector
     * @throws \Exception
     */
    public function placeToPayCheckout()
    {
        $connection = new PlaceToPayConnection();

        $connection->authentication();

        $response = $connection->createRequest(Cart::total());

        foreach (Cart::content() as $item)
        {
            $products[] = $item->name;
        }

        Order::create([
            'user_id' => Auth::id(),
            'request_id' => $response['requestId'],
            'reference' => $connection->reference,
            'description' => $products,
            'total' => Cart::total(),
        ]);

        return redirect($response['processUrl']);
//        return $connection->connect();
    }
}
