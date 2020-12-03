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
        $query = Product::query();

        foreach (request('filter', []) as $filter => $value) {
            if ($filter === 'year') {
                $query->whereYear('created_at', $value);
            } elseif ($filter === 'month') {
                $query->whereMonth('created_at', $value);
            } else {
                $query->where($filter, 'LIKE', "%$value%");
            }
        }

        $products = $query->applySorts()->jsonPaginate();

        return ProductCollection::make($products);
    }

    public function show(Product $product)
    {
        return ProductResource::make($product);
    }
}
