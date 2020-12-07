<?php

namespace Tests\Feature\Products;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ListProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_single_product()
    {
        $user = factory(User::class)->create();

        $product = factory(Product::class)->create(['user_id' => $user->id]);

        $response = $this->jsonApi()->get(route('api.v1.products.read', $product));

        $response->assertSee($product->name);
        $response->assertExactJson([
            'data' => [
                'type' => 'products',
                'id' => (string) $product->getRouteKey(),
                'attributes' => [
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'description' => $product->description,
                    'image' => $product->image,
                    'price' => $product->price,
                    'quantity' => $product->quantity,
                    'visible' => $product->visible,
//                    'category' => $product->category_id,
                    'user_id' => $product->user_id,
                    'created-at' => $product->created_at->toAtomString(),
                    'updated-at' => $product->updated_at->toAtomString(),
                ],
                'links' => [
                    'self' => route('api.v1.products.read', $product)
                ]
            ]
        ]);
    }

    /** @test */
    public function can_fetch_all_articles()
    {
        $user = factory(User::class)->create();

        $products = factory(Product::class)->times(3)->create(['user_id' => $user->id]);

        $response = $this->jsonApi()->get(route('api.v1.products.index'));

        $response->assertJsonFragment([
            'data' => [
                [
                'type' => 'products',
                'id' => (string) $products[0]->getRouteKey(),
                'attributes' => [
                    'name' => $products[0]->name,
                    'slug' => $products[0]->slug,
                    'description' => $products[0]->description,
                    'image' => $products[0]->image,
                    'price' => $products[0]->price,
                    'quantity' => $products[0]->quantity,
                    'visible' => $products[0]->visible,
//                    'category' => $products[0]->category_id,
                    'user_id' => $products[0]->user_id,
                    'created-at' => $products[0]->created_at->toAtomString(),
                    'updated-at' => $products[0]->updated_at->toAtomString(),
                ],
                'links' => [
                    'self' => route('api.v1.products.read', $products[0])
                    ]
                ],
                [
                'type' => 'products',
                'id' => (string) $products[1]->getRouteKey(),
                'attributes' => [
                    'name' => $products[1]->name,
                    'slug' => $products[1]->slug,
                    'description' => $products[1]->description,
                    'image' => $products[1]->image,
                    'price' => $products[1]->price,
                    'quantity' => $products[1]->quantity,
                    'visible' => $products[1]->visible,
//                    'category' => $products[1]->category_id,
                    'user_id' => $products[1]->user_id,
                    'created-at' => $products[1]->created_at->toAtomString(),
                    'updated-at' => $products[1]->updated_at->toAtomString(),
                ],
                'links' => [
                    'self' => route('api.v1.products.read', $products[1])
                    ]
                ],
                [
                'type' => 'products',
                'id' => (string) $products[2]->getRouteKey(),
                'attributes' => [
                    'name' => $products[2]->name,
                    'slug' => $products[2]->slug,
                    'description' => $products[2]->description,
                    'image' => $products[2]->image,
                    'price' => $products[2]->price,
                    'quantity' => $products[2]->quantity,
                    'visible' => $products[2]->visible,
//                    'category' => $products[2]->category_id,
                    'user_id' => $products[2]->user_id,
                    'created-at' => $products[2]->created_at->toAtomString(),
                    'updated-at' => $products[2]->updated_at->toAtomString(),
                ],
                'links' => [
                    'self' => route('api.v1.products.read', $products[2])
                    ]
                ],
            ],
        ]);
    }
}
