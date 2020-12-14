<?php

namespace Tests\Feature\Api\Users;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PaginateUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_paginate_users()
    {
        $users = factory(User::class)->times(10)->create();

        $url = route('api.v1.users.index', ['page[size]' => 2, 'page[number]' => 4]);

        Sanctum::actingAs(factory(User::class)->create(['user_type' => 'admin']));

        $response = $this->jsonApi()->get($url);

        $response->assertJsonCount(2, 'data')
            ->assertDontSee($users[0]->name)
            ->assertDontSee($users[1]->name)
            ->assertDontSee($users[2]->name)
            ->assertDontSee($users[3]->name)
            ->assertDontSee($users[4]->name)
            ->assertDontSee($users[5]->name)
            ->assertSee($users[6]->name)
            ->assertSee($users[7]->name)
            ->assertDontSee($users[8]->name)
            ->assertDontSee($users[9]->name);

        $response->assertJsonStructure([
            'links' => ['first', 'last', 'prev', 'next']
        ]);

        $response->assertJsonFragment([
            'first' => route('api.v1.users.index', ['page[number]' => 1, 'page[size]' => 2]),
            'last' => route('api.v1.users.index', ['page[number]' => 6, 'page[size]' => 2]),
            'prev' => route('api.v1.users.index', ['page[number]' => 3, 'page[size]' => 2]),
            'next' => route('api.v1.users.index', ['page[number]' => 5, 'page[size]' => 2]),
        ]);
    }
}
