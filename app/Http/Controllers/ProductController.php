<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $products = Product::paginate(8);

        return view('admin.productList', [
           'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.createProduct');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            $request->image = $request->file('image')->store('public');
        }
        request()->validate([
            'name' => 'required|unique:products',
            'short_description' => 'required|min:2|max:200',
            'description' => 'required|min:2|max:200',
            'image' => 'required|file'
        ]);

        Product::create([
            'name' => $request->name,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $request->image
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $product
     * @return Response
     */
    public function edit($product)
    {
        return view('admin.editProduct', [
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Product $product
     * @return void
     */
    public function update(Product $product)
    {
        request()->validate([
            'name' => 'unique:products',
            'short_description' => 'min:2|max:200',
            'description' => 'min:2|max:200',
            'image' => 'file'
        ]);

        $product->update([
            'name' => request('name'),
            'short_description' => request('short_description'),
            'description' => request('description'),
            'price' => request('price'),
            'image' => request('image')
        ]);

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return void
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return back();
    }
}
