<?php

namespace Tests\Browser\Modules\Marketing;

use App\Models\User;
use Google\Service\AdExchangeBuyerII\Seller;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Modules\Marketing\Entities\Coupon;
use Modules\Marketing\Entities\CouponProduct;
use Modules\Product\Entities\Brand;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductSku;
use Modules\Product\Entities\UnitType;
use Modules\Seller\Entities\SellerProduct;
use Modules\Seller\Entities\SellerProductSKU;
use Modules\Shipping\Entities\ProductShipping;
use Modules\Shipping\Entities\ShippingMethod;
use Tests\DuskTestCase;

class CouponTest extends DuskTestCase
{
    use WithFaker;

    protected $categories =[];
    protected $brands =[];
    protected $units =[];
    protected $shipping_methods =[];
    protected $products = [];
    protected $productSKUS = [];
    protected $product_shippings = [];
    protected $sellerProducts = [];
    protected $sellerProductSKUS = [];

    public function setUp(): void
    {
        parent::setUp();

        for ($i = 0; $i < 3; $i++) {
            $this->categories[] = Category::create([
                'name' => $this->faker->name,
                'slug' => $this->faker->slug,
                'parent_id' => 0
            ]);


            $this->brands[] = Brand::create([
                'name' => $this->faker->name,
                'slug' => $this->faker->slug,
                'status' => 1,
                'logo' => 'backend/testing/60dfe802a57ab.png'
            ]);

            $this->units[] = UnitType::create([
                'name' => $this->faker->name,
                'status' => 1
            ]);

            $this->shipping_methods[] = ShippingMethod::create([
                'method_name' => $this->faker->name,
                'phone' => $this->faker->phoneNumber,
                'shipping_time' => '8-12 days',
                'cost' => 5,
                'is_active' => 1
            ]);


            $this->products[] = Product::create([
                'product_type' => 1,
                'product_name' => $this->faker->name,
                'model_number' => 'euirwe7457845',
                'category_id' => $this->categories[0]->id,
                'brand_id' => $this->brands[0]->id,
                'unit_type_id' => $this->units[0]->id,
                'barcode_type' => 'c39',
                'minimum_order_qty' => '1',
                'max_order_qty' => '5',
                "tags" => "tag,tag 2",
                "description" => "<p>test</p>",
                "selling_price" => "0",
                "tax" => "0",
                "tax_type" => "1",
                "discount" => "0",
                "discount_type" => "1",
                "specification" => "<p>test</p>",
                "is_physical" => "1",
                "additional_shipping" => "0",
                "meta_title" => null,
                "meta_description" => null,
                "video_provider" => "youtube",
                "video_link" => null,
                "status" => "1",
                "display_in_details" => "1",
                'thumbnail_image' => 'backend/testing/60dfe802a57ab.png'
            ]);

            $this->product_shippings[] = ProductShipping::create([
                'product_id' => $this->products[$i]->id,
                'shipping_method_id' => $this->shipping_methods[$i]->id,
            ]);

            $this->productSKUS[] = ProductSku::create([
                'product_id' => $this->products[$i]->id,
                'sku' =>  'sku-748578'.$this->products[$i]->id,
                'purchase_price' => 100,
                'selling_price' => 100,
                'additional_shipping' => 0,
                'status' => 1,
            ]);

            $this->sellerProducts[] = SellerProduct::create([
                "product_id" => $this->products[$i]->id,
                "user_id" => 1,
                "stock_manage" => "1",
                "slug" => $this->faker->slug,
                "product_stock" => 5,
                "selling_price" => 6250,
                "product_name" => $this->products[$i]->product_name,
                "tax" => 5,
                "tax_type" => 0,
                "discount" => 50,
                "discount_type" => 1,
                "discount_start_date" => "05/01/2021",
                "discount_end_date" => "08/31/2021",
                'thum_img' => 'backend/testing/60dfe802a57ab.png'
            ]);

            $this->sellerProductSKUS[] = SellerProductSKU::create([
                "user_id" => 1,
                "product_id" => $this->products[$i]->id,
                "product_sku_id" => $this->productSKUS[$i]->id,
                "selling_price" => $this->productSKUS[$i]->selling_price
            ]);

            
        }


    }

    public function tearDown(): void
    {
        $coupons = Coupon::all();
        foreach($coupons as $coupon){
            if($coupon->coupon_type == 1){
                CouponProduct::destroy($coupon->products->pluck('id'));
            }
            $coupon->delete();
        }

        foreach ($this->categories as $category) {
            $category->delete();
        }
        foreach ($this->brands as $brand) {
            $brand->delete();
        }
        foreach ($this->units as $unit) {
            $unit->delete();
        }
        foreach ($this->shipping_methods as $shipping_method) {
            $shipping_method->delete();
        }

        foreach ($this->products as $product) {
            $product->delete();
        }
        foreach ($this->productSKUS as $sku) {
            $sku->delete();
        }
        foreach ($this->product_shippings as $shipping) {
            $shipping->delete();
        }

        foreach ($this->sellerProducts as $product) {
            $product->delete();
        }

        foreach ($this->sellerProductSKUS as $sku) {
            $sku->delete();
        }



        parent::tearDown(); // TODO: Change the autogenerated stub
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_for_visit_index_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                    ->visit('/marketing/coupon')
                    ->assertSee('Coupon List');
        });
    }

    public function test_for_order_based_coupon_create(){
        $this->test_for_visit_index_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#add_form > div > div:nth-child(1) > div:nth-child(1) > div > div')
                ->click('#add_form > div > div:nth-child(1) > div:nth-child(1) > div > div > ul > li:nth-child(3)')
                ->waitForText('Add Coupon Based on Order', 25)
                ->type('#coupon_title', $this->faker->title)
                ->type('#coupon_code', rand(111111111111,999999999999))
                ->type('#minimum_shopping', '200')
                ->click('#date')
                ->pause(1000)
                ->click('div.daterangepicker.ltr.show-calendar.opensright > div.drp-calendar.left > div.calendar-table > table > tbody > tr:nth-child(1) > td:nth-child(5)')
                ->pause(1000)
                ->click('div.daterangepicker.ltr.show-calendar.opensright > div.drp-calendar.right > div.calendar-table > table > tbody > tr:nth-child(5) > td:nth-child(5)')
                ->pause(1000)
                ->click('div.daterangepicker.ltr.show-calendar.opensright > div.drp-buttons > button.applyBtn.btn.btn-sm.btn-primary')
                ->pause(1000)
                ->type('#maximum_discount', '20')
                ->type('#discount', '20')
                ->click('#submit_btn')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Created successfully!');

        });
    }

    public function test_for_free_shipping_coupon_create(){
        $this->test_for_visit_index_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#add_form > div > div:nth-child(1) > div:nth-child(1) > div > div')
                ->click('#add_form > div > div:nth-child(1) > div:nth-child(1) > div > div > ul > li:nth-child(4)')
                ->pause(2000)
                ->waitForText('Add Coupon For Free Shipping', 25)
                ->type('#coupon_title', $this->faker->title)
                ->type('#coupon_code', rand(111111111111,999999999999))
                ->click('#date')
                ->pause(1000)
                ->click('div.daterangepicker.ltr.show-calendar.opensright > div.drp-calendar.left > div.calendar-table > table > tbody > tr:nth-child(1) > td:nth-child(5)')
                ->pause(1000)
                ->click('div.daterangepicker.ltr.show-calendar.opensright > div.drp-calendar.right > div.calendar-table > table > tbody > tr:nth-child(5) > td:nth-child(7)')
                ->pause(1000)
                ->click('div.daterangepicker.ltr.show-calendar.opensright > div.drp-buttons > button.applyBtn.btn.btn-sm.btn-primary')
                ->pause(1000)
                ->type('#maximum_discount', '20')
                ->click('#submit_btn')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Created successfully!');

        });
    }

    public function test_for_product_based_coupon_create(){
        $this->test_for_visit_index_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#add_form > div > div:nth-child(1) > div:nth-child(1) > div > div')
                ->click('#add_form > div > div:nth-child(1) > div:nth-child(1) > div > div > ul > li:nth-child(2)')
                ->pause(2000)
                ->waitForText('Add Coupon Based on Products', 25)
                ->type('#coupon_title', $this->faker->title)
                ->type('#coupon_code', rand(111111111111,999999999999))
                ->click('#formDataDiv > div > div:nth-child(3) > div > div')
                ->click('#formDataDiv > div > div:nth-child(3) > div > div > ul > li:nth-child(2)')
                ->pause(1000)
                ->click('#formDataDiv > div > div:nth-child(3) > div > div')
                ->click('#formDataDiv > div > div:nth-child(3) > div > div > ul > li:nth-child(3)')
                ->pause(1000)
                ->click('#formDataDiv > div > div:nth-child(3) > div > div')
                ->click('#formDataDiv > div > div:nth-child(3) > div > div > ul > li:nth-child(4)')
                ->pause(1000)
                ->click('#date')
                ->pause(1000)
                ->click('div.daterangepicker.ltr.show-calendar.opensright > div.drp-calendar.left > div.calendar-table > table > tbody > tr:nth-child(1) > td:nth-child(5)')
                ->pause(1000)
                ->click('div.daterangepicker.ltr.show-calendar.opensright > div.drp-calendar.right > div.calendar-table > table > tbody > tr:nth-child(4) > td:nth-child(6)')
                ->pause(1000)
                ->click('div.daterangepicker.ltr.show-calendar.opensright > div.drp-buttons > button.applyBtn.btn.btn-sm.btn-primary')
                ->pause(1000)
                ->type('#discount', '10')
                ->click('#submit_btn')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Created successfully!');

        });        
    }

    public function test_for_validate_create_form(){
        $this->test_for_visit_index_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#submit_btn')
                ->pause(1000)
                ->assertSeeIn('#error_coupon_type', 'Select Coupon Type First')
                ->click('#add_form > div > div:nth-child(1) > div:nth-child(1) > div > div')
                ->click('#add_form > div > div:nth-child(1) > div:nth-child(1) > div > div > ul > li:nth-child(2)')
                ->waitForText('Add Coupon Based on Products', 25)
                ->click('#submit_btn')
                ->waitForTextIn('#error_coupon_title', 'The coupon title field is required.', 25)
                ->assertSeeIn('#error_coupon_title', 'The coupon title field is required.')
                ->assertSeeIn('#error_coupon_code', 'The coupon code field is required.')
                ->assertSeeIn('#error_date', 'The date field is required.')
                ->type('#coupon_title', $this->faker->title)
                ->type('#coupon_code', rand(111111111111,999999999999))
                ->click('#date')
                ->pause(1000)
                ->click('div.daterangepicker.ltr.show-calendar.opensright > div.drp-calendar.left > div.calendar-table > table > tbody > tr:nth-child(1) > td:nth-child(5)')
                ->pause(1000)
                ->click('div.daterangepicker.ltr.show-calendar.opensright > div.drp-calendar.right > div.calendar-table > table > tbody > tr:nth-child(4) > td:nth-child(6)')
                ->pause(1000)
                ->click('div.daterangepicker.ltr.show-calendar.opensright > div.drp-buttons > button.applyBtn.btn.btn-sm.btn-primary')
                ->pause(1000)
                ->type('#discount', '')
                ->click('#submit_btn')
                ->waitForTextIn('#error_products', 'The product list field is required.', 25)
                ->assertSeeIn('#error_products', 'The product list field is required.')
                ->assertSeeIn('#error_discount', 'The discount field is required.')
                ->pause(1000)
                ->click('#add_form > div > div:nth-child(1) > div:nth-child(1) > div > div')
                ->click('#add_form > div > div:nth-child(1) > div:nth-child(1) > div > div > ul > li:nth-child(3)')
                ->waitForText('Add Coupon Based on Order', 25)
                ->click('#submit_btn')
                ->waitForTextIn('#error_coupon_code', 'The coupon code field is required.', 25)
                ->assertSeeIn('#error_coupon_code', 'The coupon code field is required.')
                ->assertSeeIn('#error_date', 'The date field is required.')
                ->pause(1000)
                ->type('#coupon_code', rand(111111111111,999999999999))
                ->click('#date')
                ->pause(1000)
                ->click('div:nth-child(65) > div.drp-calendar.left > div.calendar-table > table > tbody > tr:nth-child(1) > td:nth-child(5)')
                ->pause(1000)
                ->click('div:nth-child(65) > div.drp-calendar.right > div.calendar-table > table > tbody > tr:nth-child(4) > td:nth-child(6)')
                ->pause(1000)
                ->click('div:nth-child(65) > div.drp-buttons > button.applyBtn.btn.btn-sm.btn-primary')
                ->pause(1000)
                ->click('#submit_btn')

                ->waitForTextIn('#error_minimum_shopping', 'The minimum shopping field is required.', 25)
                ->assertSeeIn('#error_minimum_shopping', 'The minimum shopping field is required.')
                ->assertSeeIn('#error_maximum_discount', 'The maximum discount field is required.')
                ->pause(1000)
                ->click('#add_form > div > div:nth-child(1) > div:nth-child(1) > div > div')
                ->click('#add_form > div > div:nth-child(1) > div:nth-child(1) > div > div > ul > li:nth-child(4)')
                ->waitForText('Add Coupon For Free Shipping', 25)
                ->click('#submit_btn')
                ->waitForTextIn('#error_coupon_code', 'The coupon code field is required.', 25)
                ->assertSeeIn('#error_coupon_code', 'The coupon code field is required.')
                ->assertSeeIn('#error_date', 'The date field is required.')
                ->pause(1000)
                ->type('#coupon_code', rand(111111111111,999999999999))
                ->click('#date')
                ->pause(1000)
                ->click('div:nth-child(66) > div.drp-calendar.left > div.calendar-table > table > tbody > tr:nth-child(1) > td:nth-child(5)')
                ->pause(1000)
                ->click('div:nth-child(66) > div.drp-calendar.right > div.calendar-table > table > tbody > tr:nth-child(4) > td:nth-child(6)')
                ->pause(1000)
                ->click('div:nth-child(66) > div.drp-buttons > button.applyBtn.btn.btn-sm.btn-primary')
                ->pause(1000)
                ->type('#maximum_discount', '')
                ->click('#submit_btn')
                ->pause(1000)
                ->waitForTextIn('#error_maximum_discount', 'The maximum discount field is required.', 25)
                ->assertSeeIn('#error_maximum_discount', 'The maximum discount field is required.');

        });
    }


    public function test_for_product_based_edit_coupon(){
        $this->test_for_product_based_coupon_create();
        $this->browse(function (Browser $browser) {
            $browser->pause(8000)
                ->click('#couponTable > tbody > tr > td:nth-child(7) > div > button')
                ->click('#couponTable > tbody > tr > td:nth-child(7) > div > div > a.dropdown-item.edit_coupon')
                ->waitForText('Edit Coupon', 25)
                ->type('#coupon_title', $this->faker->title)
                ->type('#coupon_code', rand(111111111111,999999999999))
                ->click('#formDataDiv > div:nth-child(1) > div:nth-child(3) > div > div')
                ->click('#formDataDiv > div:nth-child(1) > div:nth-child(3) > div > div > ul > li:nth-child(4)')
                ->click('#date')
                ->pause(1000)
                ->click('div:nth-child(65) > div.drp-calendar.left > div.calendar-table > table > tbody > tr:nth-child(1) > td.active.start-date.available')
                ->pause(1000)
                ->click('div:nth-child(65) > div.drp-calendar.right > div.calendar-table > table > tbody > tr:nth-child(6) > td:nth-child(2)')
                ->pause(1000)
                ->click('div:nth-child(65) > div.drp-buttons > button.applyBtn.btn.btn-sm.btn-primary')
                ->pause(1000)
                ->type('#discount', '10')
                ->click('#formDataDiv > div:nth-child(1) > div:nth-child(6) > div > div > div')
                ->click('#formDataDiv > div:nth-child(1) > div:nth-child(6) > div > div > div > ul > li:nth-child(2)')
                ->click('#formDataDiv > div:nth-child(2) > div > div > ul > li > label > span')
                ->click('#submit_btn')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');
        });
    }

    public function test_for_order_based_edit_coupon(){
        $this->test_for_order_based_coupon_create();
        $this->browse(function (Browser $browser) {
            $browser->pause(8000)
                ->click('#couponTable > tbody > tr > td:nth-child(7) > div > button')
                ->click('#couponTable > tbody > tr > td:nth-child(7) > div > div > a.dropdown-item.edit_coupon')
                ->waitForText('Edit Coupon', 25)
                ->type('#coupon_title', $this->faker->title)
                ->type('#coupon_code', rand(111111111111,999999999999))
                ->type('#minimum_shopping', '200')
                ->click('#date')
                ->pause(1000)
                ->click('div:nth-child(65) > div.drp-calendar.left > div.calendar-table > table > tbody > tr:nth-child(1) > td:nth-child(6)')
                ->pause(1000)
                ->click('div:nth-child(65) > div.drp-calendar.right > div.calendar-table > table > tbody > tr:nth-child(4) > td:nth-child(6)')
                ->pause(1000)
                ->click('div:nth-child(65) > div.drp-buttons > button.applyBtn.btn.btn-sm.btn-primary')
                ->pause(1000)
                ->type('#maximum_discount', '30')
                ->type('#discount', '10')
                ->click('#formDataDiv > div:nth-child(1) > div:nth-child(7) > div > div > div')
                ->click('#formDataDiv > div:nth-child(1) > div:nth-child(7) > div > div > div > ul > li:nth-child(2)')
                ->click('#formDataDiv > div:nth-child(2) > div > div > ul > li > label > span')
                ->click('#submit_btn')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');

        });        
    }

    public function test_for_free_shipping_based_edit_coupon(){
        $this->test_for_free_shipping_coupon_create();
        $this->browse(function (Browser $browser) {
            $browser->pause(8000)
                ->click('#couponTable > tbody > tr > td:nth-child(7) > div > button')
                ->click('#couponTable > tbody > tr > td:nth-child(7) > div > div > a.dropdown-item.edit_coupon')
                ->waitForText('Edit Coupon', 25)
                ->type('#coupon_title', $this->faker->title)
                ->type('#coupon_code', rand(111111111111,999999999999))
                ->click('#date')
                ->pause(1000)
                ->click('div:nth-child(65) > div.drp-calendar.left > div.calendar-table > table > tbody > tr:nth-child(1) > td:nth-child(5)')
                ->pause(1000)
                ->click('div:nth-child(65) > div.drp-calendar.right > div.calendar-table > table > tbody > tr:nth-child(5) > td:nth-child(6)')
                ->pause(1000)
                ->click('div:nth-child(65) > div.drp-buttons > button.applyBtn.btn.btn-sm.btn-primary')
                ->pause(1000)
                ->click('#formDataDiv > div:nth-child(2) > div > div > ul > li > label > span')
                ->click('#submit_btn')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');

        });        
    }
    
    public function test_for_delete_coupon(){
        $this->test_for_free_shipping_coupon_create();
        $this->browse(function (Browser $browser) {
            $browser->pause(8000)
                ->click('#couponTable > tbody > tr > td:nth-child(7) > div > button')
                ->click('#couponTable > tbody > tr > td:nth-child(7) > div > div > a.dropdown-item.delete_coupon')
                ->whenAvailable('#item_delete_form', function($modal){
                    $modal->click('#dataDeleteBtn');
                })
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Deleted successfully!');

        });
    }


}
