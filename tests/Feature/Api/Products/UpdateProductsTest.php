<?php

namespace Tests\Feature\Api\Products;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_non_authenticated_user_cannot_update_products()
    {
        $user = factory(User::class)->create();

        $product = factory(Product::class)->create(['user_id' => $user->id]);

        $this->jsonApi()
            ->patch(route('api.v1.products.update', $product))
            ->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_can_update_products()
    {
        $user = factory(User::class)->create();

        $product = factory(Product::class)->create(['user_id' => $user->id]);

        Sanctum::actingAs($product->user);

        $this->jsonApi()
            ->content([
                'data' => [
                    'type' => 'products',
                    'id' => (string) $product->getRouteKey(),
                    'attributes' => [
                        'name' => 'Title changed',
                        'description' => 'Description changed'
                    ]
                ]
            ])
            ->patch(route('api.v1.products.update', $product))
            ->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'name' => 'Title changed',
            'description' => 'Description changed'
        ]);
    }

    /** @test */
    public function can_update_name_only()
    {
        $user = factory(User::class)->create();

        $product = factory(Product::class)->create(['user_id' => $user->id]);

        Sanctum::actingAs($product->user);

        $this->jsonApi()
            ->content([
                'data' => [
                    'type' => 'products',
                    'id' => (string) $product->getRouteKey(),
                    'attributes' => [
                        'name' => 'Title changed',
                    ]
                ]
            ])
            ->patch(route('api.v1.products.update', $product))
            ->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'name' => 'Title changed',
        ]);
    }

    /** @test */
    public function can_update_description_only()
    {
        $user = factory(User::class)->create();

        $product = factory(Product::class)->create(['user_id' => $user->id]);

        Sanctum::actingAs($product->user);

        $this->jsonApi()
            ->content([
                'data' => [
                    'type' => 'products',
                    'id' => (string) $product->getRouteKey(),
                    'attributes' => [
                        'description' => 'Description changed',
                    ]
                ]
            ])
            ->patch(route('api.v1.products.update', $product))
            ->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'description' => 'Description changed',
        ]);
    }
}
