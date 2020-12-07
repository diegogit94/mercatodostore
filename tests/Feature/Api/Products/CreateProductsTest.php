<?php

namespace Tests\Feature\Api\Products;

use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_a_product()
    {
        $product = factory(Product::class)->raw(); //Raw method gives an array with the attributes of a product

        $this->assertDatabaseMissing('products', $product);

        $this->jsonApi()->content([
            'data' => [
                'type' => 'products',
                'attributes' => $product,
            ]
        ])->post(route('api.v1.products.create'))->assertCreated();

        $this->assertDatabaseHas('products', $product);
    }

    /** @test */
    public function name_is_required()
    {
        $product = factory(Product::class)->raw(['name' => '']);

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
