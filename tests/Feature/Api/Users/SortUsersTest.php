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
}
