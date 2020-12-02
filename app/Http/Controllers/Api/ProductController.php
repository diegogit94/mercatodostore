<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::applySorts(request('sort'))
            ->paginate(
                $perPage = request('page.size'),
                $columns = ['*'],
                $pageName = 'page[number]',
                $page = request('page.number')
            )->appends(request()->except('page.number'));

        return ProductCollection::make($products);
    }

    public function show(Product $product)
    {
        return ProductResource::make($product);
    }
}
