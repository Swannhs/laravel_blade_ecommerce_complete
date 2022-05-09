<?php

namespace Modules\Seller\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SellerListTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_add_new_seller()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $this->post('/admin/merchant-add-form-data',[
            
            "subscription_type" => 1,
            "name" => "test shop 99 ltd",
            "shop_name" => "test shop 99",
            "email" => "test99@test.com",
            "phone_number" => "029038394859384",
            "password" => "12345678",
            "admin_creation" => $user->id,
            "password_confirmation" => "12345678"
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect('/admin/merchants');
    }

    public function test_for_trasted_and_remove_trasted_seller()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $seller = User::find(4);

        $this->get('/admin/change-trusted-status/'.$seller->sellerAccount->id)->assertRedirect('/admin/merchants');
    }




}
