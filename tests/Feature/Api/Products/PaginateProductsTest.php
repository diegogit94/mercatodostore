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

        $response = $this->jsonApi()->get($url);

        $response->assertJsonCount(2, 'data')
            ->assertDontSee($products[0]->name)
            ->assertDontSee($products[1]->name)
            ->assertDontSee($products[2]->name)
            ->assertDontSee($products[3]->name)
            ->assertSee($products[4]->name)
            ->assertSee($products[5]->name)
            ->assertDontSee($products[6]->name)
            ->assertDontSee($products[7]->name)
            ->assertDontSee($products[8]->name)
            ->assertDontSee($products[9]->name);

        $response->assertJsonStructure([
            'links' => ['first', 'last', 'prev', 'next']
        ]);

        $response->assertJsonFragment([
            'first' => route('api.v1.products.index', ['page[size]' => 2, 'page[number]' => 1]),
            'last' => route('api.v1.products.index', ['page[size]' => 2, 'page[number]' => 5]),
            'prev' => route('api.v1.products.index', ['page[size]' => 2, 'page[number]' => 2]),
            'next' => route('api.v1.products.index', ['page[size]' => 2, 'page[number]' => 4]),
        ]);
    }
}
