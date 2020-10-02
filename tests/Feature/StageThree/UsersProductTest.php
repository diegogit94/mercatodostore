<?php

namespace Tests\Feature\StageThree;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_user_can_see_products_in_the_store()
    {
        $response = $this->get('/store');

        $response->assertViewIs('store.store');
        $response->assertViewHasAll(['products']);
    }

//    /** @test */
    public function an_user_can_see_the_product_specific_view()
    {
//        $this->withoutExceptionHandling();
        $product = factory(Product::class)->create();

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get("store/$product->first");

//        $this->assertDatabaseHas('products', [$product]);
//        $response->assertStatus(200);
//        $response->assertViewIs('store.product');
    }
}
