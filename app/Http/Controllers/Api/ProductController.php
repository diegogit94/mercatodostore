<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        return response()->json([
            'data' => [
                'type' => 'products',
                'id' => (string) $product->getRouteKey(),
                'attributes' => [
                    'title' => $product->name,
                    'slug' => $product->slug,
                    'description' => $product->description,
                ],
                'links' => [
                    'self' => route('api.v1.products.show', $product)
                ]
            ]
        ]);
    }
}
