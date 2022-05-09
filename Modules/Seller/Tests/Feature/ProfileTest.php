<?php

namespace Modules\Seller\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class ProfileTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_update_seller_account()
    {
        $user = User::find(4);
        $this->actingAs($user);

        $this->post('/seller/profile/seller-account/update/'.$user->id,[
            'seller_account_id' => $user->sellerAccount->id,
            'id' => $user->id,
            'first_name' => 'test name',
            'last_name' => 'last name',
            'email' => 'email@email.com',
            'seller_phone' => '14092387476943',
            'shop_display_name' => 'shop_name',
            'commission_type' => '1',
            'holiday_mode' => '1',
            "holiday_type" => "2",
            "holiday_date" => "05/22/2021",
            "holiday_date_start" => "05/03/2021",
            "holiday_date_end" => "05/29/2021"

        ])->assertRedirect('/seller/profile');

    }

    public function test_for_update_seller_business_information()
    {
        $user = User::find(4);
        $this->actingAs($user);
        Storage::fake('/public');

        $this->post('/seller/profile/business-information/update/'.$user->id,[
            "business_owner_name" => "Amazcart Ltd",
            "business_address1" => "Birulia, Savar",
            "business_address2" => "test address",
            "country" => "18",
            "state" => "348",
            "city" => "7291",
            "business_postcode" => "454242",
            "business_person_incharge_name" => "test",
            "business_registration_number" => "test",
            "seller_tin" => "872898",
            'business_document' => UploadedFile::fake()->image('image.jpg', 1, 1)

        ])->assertRedirect('/seller/profile');
        File::deleteDirectory(base_path('/uploads'));

    }

    public function test_for_update_seller_bank_account()
    {
        $user = User::find(4);
        $this->actingAs($user);
        Storage::fake('/public');

        $this->post('/seller/profile/bank-account/update/'.$user->id,[
            "payment" => "2",
            "bank_title" => "test",
            "bank_account_number" => "test",
            "bank_name" => "test",
            "branch_name" => "test",
            "routing_number" => "872384889342",
            "ibn" => "234748723874",
            'cheque_copy' => UploadedFile::fake()->image('image.jpg', 1, 1)

        ])->assertRedirect('/seller/profile');
        File::deleteDirectory(base_path('/uploads'));

    }

    public function test_for_update_seller_warehouse_address()
    {
        $user = User::find(4);
        $this->actingAs($user);

        $this->post('/seller/profile/warehouse-address/update/'.$user->id,[
            "warehouse_name" => "amazcart",
            "warehouse_address" => "Birulia, Savar",
            "warehouse_phone" => "76543256787",
            "country" => "18",
            "state" => "348",
            "city" => "7291",
            "warehouse_postcode" => "23435464"

        ])->assertRedirect('/seller/profile');

    }

    public function test_for_update_seller_return_address()
    {
        $user = User::find(4);
        $this->actingAs($user);

        $this->post('/seller/profile/return-address/update/'.$user->id,[
            "same_as_warehouse" => "0",
            "name" => "Hafijur Rahman",
            "address" => "Birulia, Savar",
            "phone" => "0221235454",
            "country" => "18",
            "state" => "348",
            "city" => "7291",
            "postcode" => "454242"

        ])->assertRedirect('/seller/profile');

    }
}