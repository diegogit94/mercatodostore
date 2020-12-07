<?php

namespace App\Http\Controllers;

use App\Category;
use App\Exports\ProductsExport;
use App\Http\Requests\ExportRequest;
use App\Http\Requests\ImportFileRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Imports\ProductsImport;
use App\Jobs\SendExportCompleteNotification;
use App\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $name = $request->get('name');
        $category = $request->get('category');
        $price = $request->get('price');
        $visible = $request->get('visible');
        $categories = Category::all();

        $products = Product::orderBy('id', 'ASC')
            ->name($name)
            ->category($category)
            ->price($price)
            ->visible($visible)
            ->paginate(8);

        return view('admin.productList', [
            'products' => $products,
            'categories' => $categories
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
     * @param StoreProductRequest $request
     * @return Response
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create([
            'name' => $request['name'],
            'short_description' => $request['short_description'],
            'description' => $request['description'],
            'price' => $request['price'],
            'user_id' => Auth::id(),
        ]);

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('public');
        }

        $product->save();

        return back()->with('success_message', 'Se creo el producto satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
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
    public function edit(Product $product)
    {
        return view('admin.editProduct', [
            'product' => $product
        ]);
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

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('public');
        }

        $product->save();

        return redirect()
            ->route('products.index', $product)
            ->with('success_message', 'Se modifico el producto satisfactoriamente');
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     */
    public function visible (Product $product)
    {
        $product->toggleVisibility();

        return redirect()->route('products.index', $product);
    }

    public function export(ExportRequest $request)
    {
        $request->validated();

        $user = Auth::user();
        $filePath = 'public/products-' . date('Y-m-d H:i:s') .  '.xlsx';

        (new ProductsExport($request->all()))
            ->queue($filePath)
            ->chain([
                new SendExportCompleteNotification($user, asset($filePath))
            ]);

        return back()->with('success_message', 'El archivo se está exportando, recibirá un correo con el link al archivo en un momento');
    }

    public function import(ImportFileRequest $request)
    {
        $request->validated();

        $file = $request->file('file');

        Excel::import(new ProductsImport, $file);

        return redirect()->back()->with('success_message', 'Importación exitosa');
    }
}
