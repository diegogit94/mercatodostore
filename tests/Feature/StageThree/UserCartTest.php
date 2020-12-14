<?php

namespace Tests\Feature\StageThree;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Gloudemans\Shoppingcart\Cart;
use Gloudemans\Tests\Shoppingcart\CartAssertions;

class UserCartTest extends TestCase
{
    use RefreshDatabase;
//    use CartAssertions;

    /** @test */
    public function an_user_can_add_a_product_to_cart()
    {
        $user = factory(User::class)->create();

        $product = factory(Product::class)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->post(route('cart.store'), [
                'id' => $product['id'],
                'name' => $product['name'],
                'quantity' => 1,
                'price' => $product['price'],
            ]);

        $response->assertRedirect('cart');
//        $this->assertItemsInCart();
//        $this->assertItemsInCart(1, $cart);
    }

    /** @test */
    public function an_user_can_see_the_products_that_added_to_cart()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get(route('cart.index'));

        $response->assertViewIs('store.cart');
        $response->assertViewHasAll(['cart']);
    }

    /** @test */
    public function an_user_can_delete_a_product_to_cart()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $product = factory(Product::class)->create(['id' => 1, 'user_id' => $user->id]);

        $cart = $this->actingAs($user)
            ->post(route('cart.store'), [
                'id' => $product['id'],
                'name' => $product['name'],
                'quantity' => 1,
                'price' => $product['price'],
            ]);

        $response = $this->actingAs($user)
            ->delete("cart/027c91341fd5cf4d2579b49c4b6a90da");

        $response->assertDontSee('cart', false);
        $response->assertRedirect('/'); //no redirecciona correctamente
    }
}
