<?php

namespace Modules\Marketing\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Marketing\Entities\Coupon;
use Modules\Marketing\Entities\CouponProduct;
use Modules\Product\Entities\Product;
use Modules\Seller\Entities\SellerProduct;

class CouponTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */

     public function test_for_get_form_data()
     {
        $user = User::find(1);
        $this->actingAs($user);

        $this->get('marketing/coupon/get-form?id=1')->assertSee('Products');
     }

    public function test_for_create_coupon_order_base()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $this->post('/marketing/coupon/store',[
            'coupon_title' => 'test title',
            'coupon_code' => '9893854589438',
            'coupon_type' => 2,
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d'),
            'discount' => 10,
            'discount_type' => 1,
            'maximum_discount' => 10,
            'minimum_shopping' => 200,
            'is_multiple_buy' => 1,
            'date' => 'ahjsda'


        ])->assertSee('TableData');
    }

    public function test_for_create_coupon_product_base()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $product = Product::create([
            'product_name' => 'test name',
            'product_type' => 1,
            'shipping_type' => 0,
            'shipping_cost' => 0,
            'discount' => 0,
            'tax' => 0,
            'is_physical' => 1,
            'is_approved' => 1
        ]);
        $seller_product = SellerProduct::create([
            'user_id' => 5,
            'product_id' => $product->id,
            'discount' => 0,
            'tax' => 0,
            'status' => 1,
            'stock_manage' => 1,
            'is_approved' => 1,
        ]);

        $this->post('/marketing/coupon/store',[
            'coupon_title' => 'test title',
            'coupon_code' => '9893854589438',
            'coupon_type' => 1,
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d'),
            'discount' => 10,
            'discount_type' => 1,
            'maximum_discount' => 10,
            'minimum_shopping' => 200,
            'is_multiple_buy' => 1,
            'date' => 'ahjsda',
            'product_list' => [$seller_product->id]


        ])->assertSee('TableData');
    }

    public function test_for_create_coupon_shipping_base()
    {
        $user = User::find(1);
        $this->actingAs($user);


        $this->post('/marketing/coupon/store',[
            'coupon_title' => 'test title',
            'coupon_code' => '9893854589438',
            'coupon_type' => 3,
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d'),
            'maximum_discount' => 10,
            'is_multiple_buy' => 1,
            'date' => 'ahjsda'


        ])->assertSee('TableData');
    }

    public function test_for_get_edit_data()
     {
        $user = User::find(1);
        $this->actingAs($user);

        $coupon = Coupon::create([
            'title' => 'test title',
            'coupon_code' => '9893854589438',
            'coupon_type' => 2,
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d'),
            'discount' => 10,
            'discount_type' => 1,
            'maximum_discount' => 10,
            'minimum_shopping' => 200,
            'is_multiple_buy' => 0
        ]);


        $this->get('marketing/coupon/edit?id='.$coupon->id)->assertSee('Edit Coupon');
     }

    public function test_for_update_coupon()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $product = Product::create([
            'product_name' => 'test name',
            'product_type' => 1,
            'shipping_type' => 0,
            'shipping_cost' => 0,
            'discount' => 0,
            'tax' => 0,
            'is_physical' => 1,
            'is_approved' => 1
        ]);
        $seller_product = SellerProduct::create([
            'user_id' => 5,
            'product_id' => $product->id,
            'discount' => 0,
            'tax' => 0,
            'status' => 1,
            'stock_manage' => 1,
            'is_approved' => 1,
        ]);

        $coupon = Coupon::create([
            'title' => 'test title',
            'coupon_code' => '9893854589438',
            'coupon_type' => 1,
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d'),
            'discount' => 10,
            'discount_type' => 1,
            'maximum_discount' => null,
            'minimum_shopping' => null,
            'is_multiple_buy' => 0
        ]);

        CouponProduct::create([
            'coupon_id' => $coupon->id,
            'coupon_code' => $coupon->coupon_code,
            'product_id' => $seller_product->id,
        ]);

        $this->post('/marketing/coupon/update',[
            'coupon_title' => 'test title',
            'coupon_code' => '9893854589438',
            'coupon_type' => 1,
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d'),
            'discount' => 10,
            'discount_type' => 1,
            'is_multiple_buy' => 1,
            'date' => 'ahjsda',
            'product_list' => [$seller_product->id],
            'id' => $coupon->id


        ])->assertSee('TableData');
    }

    public function test_for_delete_coupon()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $coupon = Coupon::create([
            'title' => 'test title',
            'coupon_code' => '9893854589438',
            'coupon_type' => 2,
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d'),
            'discount' => 10,
            'discount_type' => 1,
            'maximum_discount' => 10,
            'minimum_shopping' => 200,
            'is_multiple_buy' => 0
        ]);

        $this->post('/marketing/coupon/delete',[
            'id' => $coupon->id
        ])->assertSee('TableData');
    }

    public function test_for_get_data()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $this->get('/marketing/coupon/get-data')->assertSee('recordsTotal');
    }


}
