<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anAdminCanSeeTheUserList()
    {
        $user = factory(User::class)->create(['user_type' => 'admin']);

        $response = $this->actingAs($user)
        ->get(route('users.index'));

        $response->assertViewIs('admin.admin');
        $response->assertViewHasAll(['users']);
    }

    /** @test */
    public function aNonAuthenticatedUserCantSeeUsersList()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get(route('users.index'));

        $response->assertRedirect('/');
    }

    /** @test */
    public function anAuthenticatedAdminCanStoreUsers()
    {
        $user = factory(User::class)->create(['user_type' => 'admin']);

        $response = $this->actingAs($user)
            ->post(route('users.store'), [
                'name' => 'prueba',
                'email' => 'prueba@mail.com',
                'password' => 'pruebapass'
            ]);
        $this->assertDatabaseHas('users', [
            'name' => 'prueba',
            'email' => 'prueba@mail.com',
        ]);
    }

    /** @test */
    public function anAuthenticatedAdminCanDeleteAnUser()
    {
        $userAdmin = factory(User::class)->create(['user_type' => 'admin']);
        $user = factory(User::class)->create(['name' => 'pruebaman']);

        $response = $this->actingAs($userAdmin)
            ->delete($user);

        $response->assertDontSee($user);
    }

    /** @test */
    public function anAuthenticatedAdminCanUpdateAnUser()
    {
        $userAdmin = factory(User::class)->create(['user_type' => 'admin']);
        $user = factory(User::class)->create();

        $response = $this->actingAs($userAdmin)
            ->patch(route('users.update'), [
                'name' => 'pruebin',
                'email' => 'pruebin@test.com'
            ]);
        dd($user);
        $this->assertDatabaseHas('users', [
            'name' => 'pruebin',
            'email' => 'pruebin@test.com'
        ]);
    }

}
