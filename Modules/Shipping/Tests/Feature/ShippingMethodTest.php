<?php

namespace Modules\Shipping\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Modules\Shipping\Entities\ShippingMethod;

class ShippingMethodTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_add_new_shipping()
    {
        $user = User::find(1);
        $this->actingAs($user);
        Storage::fake('/public');

        $this->post('/shipping-methods/store',[
            "method_name" => "test 99",
            "phone" => "tc99",
            "shipment_time" => "3-5 days",
            'cost' => 5,
            'method_logo' => UploadedFile::fake()->image('image.jpg', 1, 1)

        ])->assertSee('TableData');
        File::deleteDirectory(base_path('/uploads'));
    }

    public function test_for_edit_shipping_form()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $shipping = ShippingMethod::create([
            'method_name' => 'test 99',
            'phone' => '2398794934596',
            'shipment_time' => '3-5 days',
            'cost' => 5,
            'status' => 0
        ]);
        $this->get('/shipping-methods/edit/'.$shipping->id)->assertSee('edit method info');
    }

    public function test_for_update_shipping()
    {
        $user = User::find(1);
        $this->actingAs($user);
        Storage::fake('/public');

        $shipping = ShippingMethod::create([
            'method_name' => 'test 99',
            'phone' => '2398794934596',
            'shipment_time' => '3-5 days',
            'cost' => 5,
            'status' => 0
        ]);

        $this->post('/shipping-methods/update',[
            "id" => $shipping->id,
            "method_name" => "test 99",
            "phone" => "tc99",
            "shipment_time" => "3-5 days",
            'cost' => 5,
            'method_logo' => UploadedFile::fake()->image('image.jpg', 1, 1)

        ])->assertSee('TableData');
        File::deleteDirectory(base_path('/uploads'));
    }

    public function test_for_delete_shipping()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $shipping = ShippingMethod::create([
            'method_name' => 'test 99',
            'phone' => '2398794934596',
            'shipment_time' => '3-5 days',
            'cost' => 5,
            'status' => 0
        ]);

        $this->post('/shipping-methods/delete',[
            "id" => $shipping->id

        ])->assertSee('TableData');
    }

    public function test_for_status_change_shipping()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $shipping = ShippingMethod::create([
            'method_name' => 'test 99',
            'phone' => '2398794934596',
            'shipment_time' => '3-5 days',
            'cost' => 5,
            'status' => 0
        ]);

        $this->post('/shipping-methods/update-status',[
            "id" => $shipping->id,
            'status' => 1

        ])->assertStatus(200);
    }
}
