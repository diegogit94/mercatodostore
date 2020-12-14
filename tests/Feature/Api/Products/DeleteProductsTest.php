<?php

namespace Tests\Feature\Api\Products;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_non_authenticated_user_cannot_delete_products()
    {
        $user = factory(User::class)->create();

        $product = factory(Product::class)->create(['user_id' => $user->id]);

        Sanctum::actingAs(factory(User::class)->create());

        $this->jsonApi()
            ->delete(route('api.v1.products.delete', $product))
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_can_delete_products()
    {
        $user = factory(User::class)->create(['user_type' => 'admin']);

        $product = factory(Product::class)->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        $this->jsonApi()
            ->delete(route('api.v1.products.delete', $product))
            ->assertStatus(204);
    }
}
