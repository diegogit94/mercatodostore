<?php

namespace Tests\Feature;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CrudProductTest extends TestCase
{
    use refreshDatabase;
    /** @test */
    public function anAdminCanSeeTheProductList()
    {
        $user = factory(User::class)->create(['user_type' => 'admin']);

        $response = $this->actingAs($user)->get(route('products.index'));

        $response->assertViewIs('admin.productList');
        $response->assertViewHasAll(['products']);

    }

    /** @test */
    public function aNonAuthenticatedUserCantSeeProductList()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get(route('products.index'));

        $response->assertRedirect('/');
    }

    /** @test */
    public function anAuthenticatedAdminCanStoreProducts()
    {
        $user = factory(User::class)->create(['user_type' => 'admin']);

        $response = $this->actingAs($user)
            ->post(route('products.store'), $product = [
                'name' => 'juego prueba',
                'description' => 'descripcion de prueba',
                'short_description' => 'descripcion corta de prueba',
                'price' => '123',
            ]);

        //debería ser assertDatabaseHas
        $this->assertEquals($product, [
            'name' => 'juego prueba',
            'description' => 'descripcion de prueba',
            'short_description' => 'descripcion corta de prueba',
            'price' => '123',
        ]);

//        $response->assertRedirect(route('products.create'));
    }

    /** @test */
    public function anAuthenticatedAdminCanDeleteProducts()
    {
        $user = factory(User::class)->create(['user_type' => 'admin']);
        $product = factory(Product::class)->create(['name' => 'juego']);

        $response = $this->actingAs($user)
            ->delete($product);

        $response->assertDontSee($product);
    }

    /** @test */
    public function anAuthenticatedAdminCanUpdateProducts()
    {
        $user = factory(User::class)->create(['user_type' => 'admin']);
        $product = factory(Product::class)->create();

        $response = $this->actingAs($user)
            ->patch("/admin/" . $product . "/admin.editProduct", $product = [
                'name' => 'juego prueba',
            ]);

        $this->assertEquals($product,  [
            'name' => 'juego prueba',
        ]);

        $response->assertSessionHasNoErrors();
//        $response->assertRedirect(route('products.index'));
    }
}
