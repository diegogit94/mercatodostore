<?php

namespace Tests\Feature\Api\Users;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FilterUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_can_filter_users_by_name()
    {
        factory(User::class)->create([
            'name' => 'User A'
        ]);

        factory(User::class)->create([
            'name' => 'User B'
        ]);

        factory(User::class)->create([
            'name' => 'User B'
        ]);

        Sanctum::actingAs(factory(User::class)->create(['user_type' => 'admin']));

        $url = route('api.v1.users.index', ['filter[name]' => 'B']);

        $this->jsonApi()->get($url)
            ->assertJsonCount(2, 'data')
            ->assertDontSee('User A')
            ->assertSee('User B');
    }

    /** @test */
    public function an_admin_can_filter_users_by_email()
    {
        factory(User::class)->create([
            'name' => 'User A',
            'email' => 'test1@mercatodo.com'
        ]);

        factory(User::class)->create([
            'name' => 'User B',
            'email' => 'test2@mercatodo.com'
        ]);

        factory(User::class)->create([
            'name' => 'User C',
            'email' => 'test@tienda.com'
        ]);

        Sanctum::actingAs(factory(User::class)->create(['user_type' => 'admin']));

        $url = route('api.v1.users.index', ['filter[email]' => 'mercatodo']);

        $this->jsonApi()->get($url)
            ->assertJsonCount(2, 'data')
            ->assertSee('User A')
            ->assertSee('User B')
            ->assertDontSee('User C');
    }

    /** @test */
    public function an_admin_can_filter_users_by_active()
    {
        factory(User::class)->create([
            'name' => 'User A',
            'active' => true
        ]);

        factory(User::class)->create([
            'name' => 'User B',
            'active' => false
        ]);

        factory(User::class)->create([
            'name' => 'User C',
            'active' => false
        ]);

        Sanctum::actingAs(factory(User::class)->create(['user_type' => 'admin']));

        $url = route('api.v1.users.index', ['filter[active]' => true]);

        $this->jsonApi()->get($url)
            ->assertJsonCount(2, 'data') //This count include the actingAs user
            ->assertSee('User A')
            ->assertDontSee('User B')
            ->assertDontSee('User C');

    }

    /** @test */
    public function cannot_filter_users_by_unknown_parameter()
    {
        factory(User::class)->create([
            'name' => 'User A',
        ]);

        factory(User::class)->create([
            'name' => 'User B',
        ]);

        factory(User::class)->create([
            'name' => 'User C',
        ]);

        Sanctum::actingAs(factory(User::class)->create(['user_type' => 'admin']));

        $url = route('api.v1.users.index', ['filter[unknown]' => 'value']);

        $this->jsonApi()->get($url)
            ->assertStatus(400);
    }

    /** @test */
    public function an_admin_can_search_users_by_name_and_email()
    {
        factory(User::class)->create([
            'name' => 'User A',
            'email' => 'test1@mercatodo.com'
        ]);

        factory(User::class)->create([
            'name' => 'User B',
            'email' => 'test2@mercatodo.com'
        ]);

        factory(User::class)->create([
            'name' => 'Person',
            'email' => 'test1@tienda.com'
        ]);

        factory(User::class)->create([
            'name' => 'User D',
            'email' => 'test2@tienda.com'
        ]);

        Sanctum::actingAs(factory(User::class)->create(['user_type' => 'admin']));

        $url = route('api.v1.users.index', ['filter[search]' => 'user mercatodo']);

        $this->jsonApi()->get($url)
            ->assertJsonCount(3, 'data')
            ->assertSee('User A')
            ->assertSee('User B')
            ->assertSee('User D')
            ->assertDontSee('User C');
    }
}
