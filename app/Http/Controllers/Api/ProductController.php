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
        $sortFields = Str::of(request('sort'))->explode(',');
        $productQuery = Product::query();

        foreach ($sortFields as $sortField)
        {
            $direction = 'asc';

            if (Str::of($sortField)->startsWith('-'))
            {
                $direction = 'desc';
                $sortField = Str::of($sortField)->substr(1);
            }
            $productQuery->orderBy($sortField, $direction);
        }

        return ProductCollection::make($productQuery->get());
    }

    public function show(Product $product)
    {
        return ProductResource::make($product);
    }
}
