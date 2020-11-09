<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Library\PlaceToPayConnection;
use App\Order;
use App\OrderProduct;
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
//        Order::create([
//            'address' => $request->address,
//            'city' => $request->city,
//            'province' => $request->province,
//            'postal_code' => $request->postalcode,
//            'phone' => $request->phone,
//        ]);
    }

    /**
     * @param CheckoutRequest $request
     * @return Application|RedirectResponse|Redirector
     * @throws \Exception
     */
    public function placeToPayCheckout(CheckoutRequest $request): RedirectResponse
    {
        $request->validated();

        if (!Cart::count())
        {
            return back()->with('success_message', 'First add something to your car, sugar ;)');
        }

        $connection = new PlaceToPayConnection();
        $connection->authentication();
        $response = $connection->createRequest(Cart::total(), $request);

        $products = [];

        foreach (Cart::content() as $product)
        {
            $products[$product->id] = ['quantity' => $product->qty, 'unit_price' => $product->price];
            $names[] = $product->name;
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'request_id' => $response['requestId'],
            'reference' => $connection->reference,
            'description' => $names,
            'total' => Cart::total(),
            'address' => $request['address'],
            'city' => $request['city'],
            'province' => $request['province'],
            'postal_code' => $request['postal_code'],
            'phone' => $request['phone'],
        ]);


        $order->products()->attach($products);

        return redirect($response['processUrl']);
    }
}
