<?php

namespace Tests\Feature\Api\Products;

use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaginateProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_paginated_products()
    {
        $products = factory(Product::class)->times(10)->create();

        $url = route('api.v1.products.index', ['page[size]' => 2, 'page[number]' => 3]);

        $response = $this->getJson($url);

        $response->assertJsonCount(2, 'data');
    }
}
