<?php

namespace App\Http\Controllers;

use App\Library\PlaceToPayConnection;
use Dnetix\Redirection\PlacetoPay;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public $response = '';
    public $auth = '';
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

    public function placeToPayCheckout()
    {
        $connection = new PlaceToPayConnection();
        return $connection->connect();
    }

    public function placeToPaySuccess()
    {

        $request = $this->response['requestID'];
        $response = Http::post("https://test.placetopay.com/redirection/api/session/$request", [
            'auth' => $this->auth
        ]);

        dd($response->json());

//        return view('placeToPaySuccess');
    }
}
