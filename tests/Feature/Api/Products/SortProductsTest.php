<?php

namespace Tests\Feature\Api\Products;

use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SortProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_sort_products_by_name_asc()
    {
        factory(Product::class)->create(['name' => 'C name']);
        factory(Product::class)->create(['name' => 'A name']);
        factory(Product::class)->create(['name' => 'B name']);

        $url = route('api.v1.products.index', ['sort' => 'name']);

        $this->getJson($url)->assertSeeInOrder([
            'A name',
            'B name',
            'C name',
        ]);
    }

    /** @test */
    public function it_can_sort_products_by_name_desc()
    {
        factory(Product::class)->create(['name' => 'C name']);
        factory(Product::class)->create(['name' => 'A name']);
        factory(Product::class)->create(['name' => 'B name']);

        $url = route('api.v1.products.index', ['sort' => '-name']);

        $this->getJson($url)->assertSeeInOrder([
            'C name',
            'B name',
            'A name',
        ]);
    }

    /** @test */
    public function it_can_sort_products_by_name_and_description()
    {
        factory(Product::class)->create([
            'name' => 'C name',
            'description' => 'B content'
            ]);
        factory(Product::class)->create([
            'name' => 'A name',
            'description' => 'A content'
            ]);
        factory(Product::class)->create([
            'name' => 'B name',
            'description' => 'D content'
            ]);

        $url = route('api.v1.products.index', ['sort' => 'name,-description']);

        $this->getJson($url)->assertSeeInOrder([
            'A name',
            'B name',
            'C name',
        ]);

        $url = route('api.v1.products.index', ['sort' => '-description,name']);

        $this->getJson($url)->assertSeeInOrder([
            'D content',
            'B content',
            'A content',
        ]);
    }
}
