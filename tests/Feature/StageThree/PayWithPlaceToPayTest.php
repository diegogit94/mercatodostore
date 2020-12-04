<?php

namespace Tests\Feature\StageThree;

use App\Library\PlaceToPayConnection;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PayWithPlaceToPayTest extends TestCase
{
    /** @test */
    public function can_make_a_request_to_place_to_pay_endpoint()
    {
//        $this->withoutExceptionHandling();
//        $response = $this->json('POST', route('checkout.placeToPayCheckout'));

//        $response->assertRedirect($response['processUrl']);
//        $response->assertJsonStructure();
//        $response->assertJson(['status' => ['status' => 'OK']]);
    }

//    /** @test */
    public function redirect_user_to_web_checkout()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->json('POST', route('checkout.placeToPayCheckout'));

        $response->assertJson(['status' => ['status' => 'OK']]);
        $response->assertOk();
        $this->assertAuthenticated();
    }

//    /** @test */
    public function can_see_the_place_to_pay_transaction_status()
    {

    }
}
