<?php

namespace Tests\Feature\Products;

use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListProductTest extends TestCase
{
    /** @test */
    public function can_fetch_single_product()
    {
        $product = factory(Product::class)->create();

        $response = $this->getJson(route('api.v1.products.show', $product));

        $response->assertSee($product->name);
        $response->assertExactJson([
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
