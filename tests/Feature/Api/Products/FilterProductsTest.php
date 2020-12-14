<?php

namespace Tests\Feature\Api\Products;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class FilterProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_filter_products_by_name()
    {
        $user = factory(User::class)->create();

        factory(Product::class)->create([
            'name' => 'First product',
            'user_id' => $user->id,
        ]);

        factory(Product::class)->create([
            'name' => 'Other element',
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $url = route('api.v1.products.index', ['filter[name]' => 'element']);

        $this->jsonApi()->get($url)
            ->assertJsonCount(1, 'data')
            ->assertSee('Other element')
            ->assertDontSee('First product');
    }

    /** @test */
    public function can_filter_products_by_description()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        factory(Product::class)->create([
            'description' => "<div>First product</div>",
            'user_id' => $user->id,
        ]);

        factory(Product::class)->create([
            'description' => '<div>Other element</div>',
            'user_id' => $user->id,
        ]);


        $url = route('api.v1.products.index', ['filter[description]' => 'element']);

        $this->jsonApi()->get($url)
            ->assertJsonCount(1, 'data')
            ->assertSee('Other element')
            ->assertDontSee('First product');
    }

    /** @test */
    public function can_filter_products_by_year()
    {
        $user = factory(User::class)->create();

        factory(Product::class)->create([
            'name' => 'Product from 2020',
            'created_at' => now()->year(2020),
            'user_id' => $user->id,

        ]);

        factory(Product::class)->create([
            'name' => 'Product from 2021',
            'created_at' => now()->year(2021),
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $url = route('api.v1.products.index', ['filter[year]' => 2020]);

        $this->jsonApi()->get($url)
            ->assertJsonCount(1, 'data')
            ->assertSee('Product from 2020')
            ->assertDontSee('Product from 2021');
    }

    /** @test */
    public function can_filter_products_by_month()
    {
        $user = factory(User::class)->create();

        factory(Product::class)->create([
            'name' => 'Product from March',
            'created_at' => now()->month(3),
            'user_id' => $user->id,
        ]);

        factory(Product::class)->create([
            'name' => 'Another product from March',
            'created_at' => now()->month(3),
            'user_id' => $user->id,
        ]);

        factory(Product::class)->create([
            'name' => 'Product from December',
            'created_at' => now()->month(12),
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $url = route('api.v1.products.index', ['filter[month]' => 3]);

        $this->jsonApi()->get($url)
            ->assertJsonCount(2, 'data')
            ->assertSee('Product from March')
            ->assertSee('Another product from March')
            ->assertDontSee('Product from December');
    }

    /** @test */
    public function cannot_filter_products_by_unknown_filter()
    {
        $user = factory(User::class)->create();

        factory(Product::class)->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $url = route('api.v1.products.index', ['filter[unknown]' => 'value']);

        $this->jsonApi()->get($url)->assertStatus(400);
    }

    /** @test */
    public function can_search_products_by_name_and_description()
    {
        $user = factory(User::class)->create();

        factory(Product::class)->create([
            'name' => 'First product test',
            'description' => 'First description',
            'user_id' => $user->id,
        ]);

        factory(Product::class)->create([
            'name' => 'Other element',
            'description' => 'Other description test',
            'user_id' => $user->id,
        ]);

        factory(Product::class)->create([
            'name' => 'Generic name',
            'description' => 'Generic description',
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $url = route('api.v1.products.index', ['filter[search]' => 'test']);

        $this->jsonApi()->get($url)
            ->assertJsonCount(2, 'data')
            ->assertSee('First product test')
            ->assertSee('Other element')
            ->assertDontSee('Generic name');
    }

    /** @test */
    public function can_search_products_by_with_multiple_terms()
    {
        $user = factory(User::class)->create();

        factory(Product::class)->create([
            'name' => 'First product test',
            'description' => 'First description',
            'user_id' => $user->id,
        ]);

        factory(Product::class)->create([
            'name' => 'Other element',
            'description' => 'Other description test',
            'user_id' => $user->id,
        ]);

        factory(Product::class)->create([
            'name' => 'Different element',
            'description' => 'Different description test',
            'user_id' => $user->id,
        ]);

        factory(Product::class)->create([
            'name' => 'Generic name',
            'description' => 'Generic empty',
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $url = route('api.v1.products.index', ['filter[search]' => 'test description']);

        $this->jsonApi()->get($url)
            ->assertJsonCount(3, 'data')
            ->assertSee('First product test')
            ->assertSee('Other description test')
            ->assertSee('Different description test')
            ->assertDontSee('Generic name');
    }
}
