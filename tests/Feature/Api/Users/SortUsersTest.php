<?php

namespace Tests\Feature\Api\Users;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SortUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_sort_users_by_name_asc()
    {
        factory(User::class)->create(['name' => 'C name']);
        factory(User::class)->create(['name' => 'A name']);
        factory(User::class)->create(['name' => 'B name']);

        $url = route('api.v1.users.index', ['sort' => 'name']);

        $this->jsonApi()->get($url)->assertSeeInOrder([
            'A name',
            'B name',
            'C name',
        ]);
    }

    /** @test */
    public function it_can_sort_users_by_name_desc()
    {
        factory(User::class)->create(['name' => 'C name']);
        factory(User::class)->create(['name' => 'A name']);
        factory(User::class)->create(['name' => 'B name']);

        $url = route('api.v1.users.index', ['sort' => '-name']);

        $this->jsonApi()->get($url)->assertSeeInOrder([
            'C name',
            'B name',
            'A name',
        ]);
    }

    /** @test */
    public function it_can_sort_users_by_name_and_status()
    {
        factory(User::class)->create([
            'name' => 'User D',
            'active' => false,
        ]);

        factory(User::class)->create([
            'name' => 'User A',
            'active' => true,
        ]);

        factory(User::class)->create([
            'name' => 'User C',
            'active' => false,
        ]);

        factory(User::class)->create([
            'name' => 'User B',
            'active' => true,
        ]);

        factory(User::class)->create([
            'name' => 'User E',
            'active' => false,
        ]);

        $url = route('api.v1.users.index', ['sort' => 'name,active']);

        $this->jsonApi()->get($url)->assertSeeInOrder([
            'User A',
            'User B',
        ]);

        $url = route('api.v1.users.index', ['sort' => 'active,-name']);

        $this->jsonApi()->get($url)->assertSeeInOrder([
            'User E',
            'User D',
            'User C',
        ]);
    }
}
