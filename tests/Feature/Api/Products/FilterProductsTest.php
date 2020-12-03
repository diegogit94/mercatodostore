<?php

namespace Tests\Feature\Api\Products;

use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FilterProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_filter_products_by_name()
    {
        factory(Product::class)->create([
            'name' => 'First product'
        ]);

        factory(Product::class)->create([
            'name' => 'Other element'
        ]);

        $url = route('api.v1.products.index', ['filter[name]' => 'element']);

        $this->getJson($url)
            ->assertJsonCount(1, 'data')
            ->assertSee('Other element')
            ->assertDontSee('First product');
    }

    /** @test */
    public function can_filter_products_by_description()
    {
        factory(Product::class)->create([
            'description' => "<div>First product</div>"
        ]);

        factory(Product::class)->create([
            'description' => '<div>Other element</div>'
        ]);

        $url = route('api.v1.products.index', ['filter[description]' => 'element']);

        $this->getJson($url)
            ->assertJsonCount(1, 'data')
            ->assertSee('Other element')
            ->assertDontSee('First product');
    }

    /** @test */
    public function can_filter_products_by_year()
    {
        factory(Product::class)->create([
            'name' => 'Product from 2020',
            'created_at' => now()->year(2020)
        ]);

        factory(Product::class)->create([
            'name' => 'Product from 2021',
            'created_at' => now()->year(2021)
        ]);

        $url = route('api.v1.products.index', ['filter[year]' => 2020]);

        $this->getJson($url)
            ->assertJsonCount(1, 'data')
            ->assertSee('Product from 2020')
            ->assertDontSee('Product from 2021');
    }

    /** @test */
    public function can_filter_products_by_month()
    {
        factory(Product::class)->create([
            'name' => 'Product from March',
            'created_at' => now()->month(3)
        ]);

        factory(Product::class)->create([
            'name' => 'Another product from March',
            'created_at' => now()->month(3)
        ]);

        factory(Product::class)->create([
            'name' => 'Product from December',
            'created_at' => now()->month(12)
        ]);

        $url = route('api.v1.products.index', ['filter[month]' => 3]);

        $this->getJson($url)
            ->assertJsonCount(2, 'data')
            ->assertSee('Product from March')
            ->assertSee('Another product from March')
            ->assertDontSee('Product from December');
    }

    /** @test */
    public function cannot_filter_products_by_unknown_filter()
    {
        factory(Product::class)->create([]);

        $url = route('api.v1.products.index', ['filter[unknown]' => 'value']);

        $this->getJson($url)->assertStatus(400);
    }
}
