<?php

namespace Tests\Feature\Products;

use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListProductTest extends TestCase
{
    use RefreshDatabase;

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
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'description' => $product->description,
                ],
                'links' => [
                    'self' => route('api.v1.products.show', $product)
                ]
            ]
        ]);
    }

    /** @test */
    public function can_fetch_all_articles()
    {
        $this->withoutExceptionHandling();

        $products = factory(Product::class)->times(3)->create();

        $response = $this->getJson(route('api.v1.products.index'));

        $response->assertExactJson([
            'data' => [
                [
                'type' => 'products',
                'id' => (string) $products[0]->getRouteKey(),
                'attributes' => [
                    'name' => $products[0]->name,
                    'slug' => $products[0]->slug,
                    'description' => $products[0]->description,
                ],
                'links' => [
                    'self' => route('api.v1.products.show', $products[0])
                    ]
                ],
                [
                'type' => 'products',
                'id' => (string) $products[1]->getRouteKey(),
                'attributes' => [
                    'name' => $products[1]->name,
                    'slug' => $products[1]->slug,
                    'description' => $products[1]->description,
                ],
                'links' => [
                    'self' => route('api.v1.products.show', $products[1])
                    ]
                ],
                [
                'type' => 'products',
                'id' => (string) $products[2]->getRouteKey(),
                'attributes' => [
                    'name' => $products[2]->name,
                    'slug' => $products[2]->slug,
                    'description' => $products[2]->description,
                ],
                'links' => [
                    'self' => route('api.v1.products.show', $products[2])
                    ]
                ],
            ],
            'links' => [
                'self' => route('api.v1.products.index')
            ]
        ]);
    }
}
