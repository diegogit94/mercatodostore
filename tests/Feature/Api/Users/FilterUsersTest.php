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
    public function can_filter_users_by_name()
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

        $url = route('api.v1.users.index', ['filter[name]' => 'B']);

        $this->jsonApi()->get($url)
            ->assertJsonCount(2, 'data')
            ->assertDontSee('User A')
            ->assertSee('User B');
    }

    /** @test */
    public function can_filter_users_by_active()
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

        $url = route('api.v1.users.index', ['filter[active]' => true]);

        $this->jsonApi()->get($url)
            ->assertJsonCount(1, 'data')
            ->assertSee('User A')
            ->assertDontSee('User B')
            ->assertDontSee('User C');

    }
}
