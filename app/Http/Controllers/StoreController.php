<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $products = Product::paginate(3);
        $categories = Category::latest()->get();

        return view('store.store', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
           'query' => 'required|min:1'
        ]);

        $query = $request->input('query');

        $products = Product::where('name', 'like', "%$query%")
            ->orwhere('short_description', 'like', "%$query%")
            ->orwhere('description', 'like', "%$query%")
            ->get();

        return view('searchResults', [
            'products' => $products
        ]);
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        return view('store.product')->with('product', $product);
    }
}
