<?php

namespace Tests\Feature\Api\Users;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ListUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_all_user()
    {
        $users = factory(User::class)->times(3)->create();

        Sanctum::actingAs(factory(User::class)->create(['user_type' => 'admin']));

        $this->jsonApi()->get(route('api.v1.users.index'))
            ->assertSee($users[0]->name)
            ->assertSee($users[0]->email)
            ->assertSee($users[0]->user_type)
            ->assertSee($users[0]->active);
    }

    /** @test */
    public function can_fetch_a_single_users()
    {
        $user = factory(User::class)->create();

        $this->jsonApi()->get(route('api.v1.users.read', $user))
            ->assertSee($user['name'])
            ->assertSee($user['email'])
            ->assertSee($user['user_type'])
            ->assertSee($user['active']);
    }
}
