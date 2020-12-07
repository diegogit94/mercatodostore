<?php

namespace Tests\Feature\Api\Products;

use App\Product;
use App\User;
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
        $user = factory(User::class)->create();

        factory(Product::class)->create(['name' => 'C name', 'user_id' => $user->id]);
        factory(Product::class)->create(['name' => 'A name', 'user_id' => $user->id]);
        factory(Product::class)->create(['name' => 'B name', 'user_id' => $user->id]);

        $url = route('api.v1.products.index', ['sort' => 'name']);

        $this->jsonApi()->get($url)->assertSeeInOrder([
            'A name',
            'B name',
            'C name',
        ]);
    }

    /** @test */
    public function it_can_sort_products_by_name_desc()
    {
        $user = factory(User::class)->create();

        factory(Product::class)->create(['name' => 'C name', 'user_id' => $user->id]);
        factory(Product::class)->create(['name' => 'A name', 'user_id' => $user->id]);
        factory(Product::class)->create(['name' => 'B name', 'user_id' => $user->id]);

        $url = route('api.v1.products.index', ['sort' => '-name']);

        $this->jsonApi()->get($url)->assertSeeInOrder([
            'C name',
            'B name',
            'A name',
        ]);
    }

    /** @test */
    public function it_can_sort_products_by_name_and_description()
    {
        $user = factory(User::class)->create();

        factory(Product::class)->create([
            'name' => 'C name',
            'description' => 'B content',
            'user_id' => $user->id,
            ]);
        factory(Product::class)->create([
            'name' => 'A name',
            'description' => 'A content',
            'user_id' => $user->id,
            ]);
        factory(Product::class)->create([
            'name' => 'B name',
            'description' => 'D content',
            'user_id' => $user->id,
            ]);

        $url = route('api.v1.products.index', ['sort' => 'name,-description']);

        $this->jsonApi()->get($url)->assertSeeInOrder([
            'A name',
            'B name',
            'C name',
        ]);

        $url = route('api.v1.products.index', ['sort' => '-description,name']);

        $this->jsonApi()->get($url)->assertSeeInOrder([
            'D content',
            'B content',
            'A content',
        ]);
    }

    /** @test */
    public function it_cannot_sort_products_by_unknown_fields()
    {
        $user = factory(User::class)->create();

        factory(Product::class)->times(3)->create(['user_id' => $user->id]);

        $url = route('api.v1.products.index', ['sort' => 'unknown']);

        $this->jsonApi()->get($url)->assertStatus(400);
    }
}
