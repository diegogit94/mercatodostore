<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all()->random()->get();
        $categories = Category::latest()->get();

        return view('store.store', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function search(Request $request)
    { //searchable en modelo product
        $query = $request->input('query');

        $products = Product::where('name', 'like', "%$query%")->get();

        return view('searchResults', [
            'products' => $products
        ]);
    }

}
