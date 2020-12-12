<?php

namespace Tests\Feature\Api\Products;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_create_a_product()
    {
        $user = factory(User::class)->create(['user_type' => 'admin']);

        $product = factory(Product::class)->raw(['user_id' => $user->id]); //Raw method gives an array with the attributes of a product

        $this->assertDatabaseMissing('products', $product);

        Sanctum::actingAs($user);

        $this->jsonApi()->content([
            'data' => [
                'type' => 'products',
                'attributes' => [
                    'name' => $product['name'],
                    'short_description' => $product['short_description'],
                    'description' => $product['description'],
                    'image' => $product['image'],
                    'price' => $product['price'],
                    'quantity' => $product['quantity'],
                    'visible' => $product['visible'],
                    'user_id' => $user->id,
                ]
            ]
        ])->post(route('api.v1.products.create'))->assertCreated();

        $this->assertDatabaseHas('products', [
            'name' => $product['name'],
            'short_description' => $product['short_description'],
            'description' => $product['description'],
            'image' => $product['image'],
            'price' => $product['price'],
            'quantity' => $product['quantity'],
            'visible' => $product['visible'],
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function a_non_authenticated_user_cannot_create_a_product()
    {
        $product = factory(Product::class)->raw(['user_id' => null]); //Raw method gives an array with the attributes of a product

        Sanctum::actingAs(factory(User::class)->create());

        $this->jsonApi()->content([
            'data' => [
                'type' => 'products',
                'attributes' => $product,
            ]
        ])->post(route('api.v1.products.create'))->assertStatus(302);

        $this->assertDatabaseMissing('products', $product);
    }

    /** @test */
    public function name_is_required()
    {
        $product = factory(Product::class)->raw(['name' => '']);

        Sanctum::actingAs(factory(User::class)->create(['user_type' => 'admin']));

        $this->jsonApi()->content([
            'data' => [
                'type' => 'products',
                'attributes' => $product,
            ]
        ])->post(route('api.v1.products.create'))
            ->assertStatus(422)
            ->assertSee('data\/attributes\/name');

        $this->assertDatabaseMissing('products', $product);
    }

    /** @test */
    public function short_description_is_required()
    {
        $product = factory(Product::class)->raw(['short_description' => '']);

        Sanctum::actingAs(factory(User::class)->create(['user_type' => 'admin']));

        $this->jsonApi()->content([
            'data' => [
                'type' => 'products',
                'attributes' => $product,
            ]
        ])->post(route('api.v1.products.create'))
            ->assertStatus(422)
            ->assertSee('data\/attributes\/short_description');

        $this->assertDatabaseMissing('products', $product);
    }

    /** @test */
    public function description_is_required()
    {
        $product = factory(Product::class)->raw(['description' => '']);

        Sanctum::actingAs(factory(User::class)->create(['user_type' => 'admin']));

        $this->jsonApi()->content([
            'data' => [
                'type' => 'products',
                'attributes' => $product,
            ]
        ])->post(route('api.v1.products.create'))
            ->assertStatus(422)
            ->assertSee('data\/attributes\/description');

        $this->assertDatabaseMissing('products', $product);
    }

    /** @test */
    public function price_is_required()
    {
        $product = factory(Product::class)->raw(['price' => null]);

        Sanctum::actingAs(factory(User::class)->create(['user_type' => 'admin']));

        $this->jsonApi()->content([
            'data' => [
                'type' => 'products',
                'attributes' => $product,
            ]
        ])->post(route('api.v1.products.create'))
            ->assertStatus(422)
            ->assertSee('data\/attributes\/price');

        $this->assertDatabaseMissing('products', $product);
    }

    /** @test */
    public function quantity_is_required()
    {
        $product = factory(Product::class)->raw(['quantity' => null]);

        Sanctum::actingAs(factory(User::class)->create(['user_type' => 'admin']));

        $this->jsonApi()->content([
            'data' => [
                'type' => 'products',
                'attributes' => $product,
            ]
        ])->post(route('api.v1.products.create'))
            ->assertStatus(422)
            ->assertSee('data\/attributes\/quantity');

        $this->assertDatabaseMissing('products', $product);
    }
}
