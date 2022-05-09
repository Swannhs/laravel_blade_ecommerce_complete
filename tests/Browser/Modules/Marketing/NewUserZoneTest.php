<?php

namespace Tests\Browser\Modules\Marketing;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Modules\Marketing\Entities\Coupon;
use Modules\Marketing\Entities\NewUserZone;
use Modules\Marketing\Entities\NewUserZoneCategory;
use Modules\Marketing\Entities\NewUserZoneCouponCategory;
use Modules\Marketing\Entities\NewUserZoneProduct;
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
use Str;

class NewUserZoneTest extends DuskTestCase
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
        Coupon::create([
            'title' => 'new user zone coupon',
            'coupon_code' => rand(111111111111, 999999999999),
            'coupon_type' => 2,
            'start_date' => date('Y-m-d', strtotime('2021-07-01')),
            'end_date' => date('Y-m-d', strtotime('2021-10-01')),
            'discount' => 10,
            'discount_type' => 0,
            'minimum_shopping' => 500,
            'maximum_discount' => 50,
            'is_expire' => 0,
            'is_multiple_buy' => 0
        ]);

    }

    public function tearDown(): void
    {
        
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

        $coupons = Coupon::pluck('id');
        Coupon::destroy($coupons);

        $new_user_zones = NewUserZone::all();
        if(count($new_user_zones) > 0){
            foreach($new_user_zones as $new_user_zone){
                NewUserZoneProduct::destroy($new_user_zone->products->pluck('id'));
                NewUserZoneCategory::destroy($new_user_zone->categories->pluck('id'));
                NewUserZoneCouponCategory::destroy($new_user_zone->couponCategories->pluck('id'));
                $new_user_zone->delete();
            }
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
                    ->visit('/marketing/new-user-zone')
                    ->assertSee('New User Zone List');
        });
    }

    public function test_for_create_new_user_zone()
    {
        $this->test_for_visit_index_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#main-content > section > div > div > div.col-12 > div > div > ul > li > a')
                    ->assertPathIs('/marketing/new-user-zone/create')
                    ->assertSee('Create New User Zone')
                    ->type('#title', 'test new user zone')
                    ->click('#background_color')
                    ->pause(1000)
                    ->click('div:nth-child(64) > div.sp-palette-container > div.sp-palette.sp-thumb.sp-cf > div.sp-cf.sp-palette-row.sp-palette-row-0 > span:nth-child(8) > span')
                    ->click('div:nth-child(64) > div.sp-picker-container > div.sp-button-container.sp-cf > button.sp-choose')
                    ->pause(1000)
                    ->click('#text_color')
                    ->pause(1000)
                    ->click('div:nth-child(65) > div.sp-palette-container > div.sp-palette.sp-thumb.sp-cf > div.sp-cf.sp-palette-row.sp-palette-row-0 > span:nth-child(2) > span')
                    ->click('div:nth-child(65) > div.sp-picker-container > div.sp-button-container.sp-cf > button.sp-choose')
                    ->pause(1000)
                    ->attach('#banner_image', __DIR__.'/files/banner_image.png')
                    ->click('#main-content > section > div.row > div.col-lg-8 > ul > li:nth-child(2) > a')
                    ->pause(1000)
                    ->assertSee('Setup Products')
                    ->type('#product_navigation_label', $this->faker->name)
                    ->type('#product_slogan', $this->faker->name)
                    ->click('#formHtmlProduct > div > div > div > div:nth-child(3) > div > div')
                    ->click('#formHtmlProduct > div > div > div > div:nth-child(3) > div > div > ul > li:nth-child(2)')
                    ->pause(7000)
                    ->click('#formHtmlProduct > div > div > div > div:nth-child(3) > div > div')
                    ->click('#formHtmlProduct > div > div > div > div:nth-child(3) > div > div > ul > li:nth-child(3)')
                    ->pause(7000)
                    ->click('#formHtmlProduct > div > div > div > div:nth-child(3) > div > div')
                    ->click('#formHtmlProduct > div > div > div > div:nth-child(3) > div > div > ul > li:nth-child(4)')
                    ->pause(7000)
                    ->click('#sku_tbody > tr:nth-child(3) > td.text-center.pl-16 > a > i')
                    ->pause(1000)
                    ->click('#formHtmlProduct > div > div > div > div:nth-child(3) > div > div')
                    ->click('#formHtmlProduct > div > div > div > div:nth-child(3) > div > div > ul > li:nth-child(4)')
                    ->pause(7000)
                    ->click('#main-content > section > div.row > div.col-lg-8 > ul > li:nth-child(3) > a')
                    ->pause(1000)
                    ->assertSee('Category Setup')
                    ->type('#category_navigation_label', $this->faker->name)
                    ->type('#category_slogan', $this->faker->name)
                    ->click('#priceSetup > div > div.col-lg-5 > div:nth-child(2) > div > div > div:nth-child(3) > div > div')
                    ->click('#priceSetup > div > div.col-lg-5 > div:nth-child(2) > div > div > div:nth-child(3) > div > div > ul > li:nth-child(2)')
                    ->pause(7000)
                    ->click('#priceSetup > div > div.col-lg-5 > div:nth-child(2) > div > div > div:nth-child(3) > div > div')
                    ->click('#priceSetup > div > div.col-lg-5 > div:nth-child(2) > div > div > div:nth-child(3) > div > div > ul > li:nth-child(3)')
                    ->pause(7000)
                    ->click('#categoryDiv > div:nth-child(2) > div > div > div > div > a > i')
                    ->pause(1000)
                    ->click('#priceSetup > div > div.col-lg-5 > div:nth-child(2) > div > div > div:nth-child(3) > div > div')
                    ->click('#priceSetup > div > div.col-lg-5 > div:nth-child(2) > div > div > div:nth-child(3) > div > div > ul > li:nth-child(3)')
                    ->pause(7000)
                    ->click('#main-content > section > div.row > div.col-lg-8 > ul > li:nth-child(4) > a')
                    ->pause(1000)
                    ->assertSee('Coupon Section Setup')
                    ->type('#coupon_navigation_label', $this->faker->name)
                    ->type('#coupon_slogan', $this->faker->name)
                    ->click('#formHtmlCoupon > div > div > div > div:nth-child(3) > div > div')
                    ->click('#formHtmlCoupon > div > div > div > div:nth-child(3) > div > div > ul > li:nth-child(1)')
                    ->pause(1000)
                    ->click('#formHtmlCoupon > div > div > div > div:nth-child(4) > div > div')
                    ->click('#formHtmlCoupon > div > div > div > div:nth-child(4) > div > div > ul > li:nth-child(2)')
                    ->pause(7000)
                    ->click('#formHtmlCoupon > div > div > div > div:nth-child(4) > div > div')
                    ->click('#formHtmlCoupon > div > div > div > div:nth-child(4) > div > div > ul > li:nth-child(3)')
                    ->pause(7000)
                    ->click('#CouponCategoryDiv > div:nth-child(2) > div > div > div > div > a > i')
                    ->pause(1000)
                    ->click('#formHtmlCoupon > div > div > div > div:nth-child(4) > div > div')
                    ->click('#formHtmlCoupon > div > div > div > div:nth-child(4) > div > div > ul > li:nth-child(3)')
                    ->pause(7000)
                    ->click('#submit_btn')
                    ->assertPathIs('/marketing/new-user-zone')
                    ->waitFor('.toast-message',25)
                    ->assertSeeIn('.toast-message', 'Created successfully!');

        });
    }

    

    public function test_for_edit_new_user_zone()
    {
        $this->test_for_create_new_user_zone();
        $this->browse(function (Browser $browser) {
            $new_user_zone = NewUserZone::latest()->first();
            $browser->click('#DataTables_Table_0 > tbody > tr > td:nth-child(7) > div > button')
                    ->click('#DataTables_Table_0 > tbody > tr > td:nth-child(7) > div > div > a.dropdown-item.edit_brand')
                    ->assertPathIs('/marketing/new-user-zone/edit/'.$new_user_zone->id)
                    ->assertSee('Update New User Zone')
                    ->type('#title', 'test new user zone edit')
                    ->click('#background_color')
                    ->click('div:nth-child(64) > div.sp-palette-container > div.sp-palette.sp-thumb.sp-cf > div.sp-cf.sp-palette-row.sp-palette-row-0 > span:nth-child(7) > span')
                    ->click('div:nth-child(64) > div.sp-picker-container > div.sp-button-container.sp-cf > button.sp-choose')
                    ->pause(1000)
                    ->click('#text_color')
                    ->click('div:nth-child(65) > div.sp-palette-container > div.sp-palette.sp-thumb.sp-cf > div.sp-cf.sp-palette-row.sp-palette-row-0 > span:nth-child(1) > span')
                    ->click('div:nth-child(65) > div.sp-picker-container > div.sp-button-container.sp-cf > button.sp-choose')
                    ->pause(1000)
                    ->attach('#banner_image', __DIR__.'/files/banner_image.png')
                    ->click('#main-content > section > div.row > div.col-lg-8 > ul > li:nth-child(2) > a')
                    ->pause(1000)
                    ->assertSee('Setup Products')
                    ->click('#sku_tbody > tr:nth-child(2) > td.text-center.pl-16 > a > i')
                    ->pause(1000)
                    ->type('#product_navigation_label', $this->faker->name)
                    ->type('#product_slogan', $this->faker->name)
                    ->click('#formHtmlProduct > div > div > div > div:nth-child(3) > div > div')
                    ->click('#formHtmlProduct > div > div > div > div:nth-child(3) > div > div > ul > li:nth-child(4)')
                    ->pause(7000)
                    ->click('#main-content > section > div.row > div.col-lg-8 > ul > li:nth-child(3) > a')
                    ->pause(1000)
                    ->assertSee('Category Setup')
                    ->click('#categoryDiv > div:nth-child(2) > div > div > div > div > a > i')
                    ->pause(1000)
                    ->type('#category_navigation_label', $this->faker->name)
                    ->type('#category_slogan', $this->faker->name)
                    ->click('#priceSetup > div > div.col-lg-5 > div:nth-child(2) > div > div > div:nth-child(3) > div > div')
                    ->click('#priceSetup > div > div.col-lg-5 > div:nth-child(2) > div > div > div:nth-child(3) > div > div > ul > li:nth-child(4)')
                    ->pause(7000)
                    ->click('#main-content > section > div.row > div.col-lg-8 > ul > li:nth-child(4)')
                    ->pause(1000)
                    ->assertSee('Coupon Section Setup')
                    ->click('#CouponCategoryDiv > div:nth-child(2) > div > div > div > div > a > i')
                    ->pause(1000)
                    ->type('#coupon_navigation_label', $this->faker->name)
                    ->type('#coupon_slogan', $this->faker->name)
                    ->click('#formHtmlCoupon > div > div > div > div:nth-child(4) > div > div')
                    ->click('#formHtmlCoupon > div > div > div > div:nth-child(4) > div > div > ul > li:nth-child(4)')
                    ->click('#submit_btn')
                    ->assertPathIs('/marketing/new-user-zone')
                    ->waitFor('.toast-message',25)
                    ->assertSeeIn('.toast-message', 'Updated successfully!');
        });
        
    }

    public function test_for_delete_new_user_zone(){
        $this->test_for_create_new_user_zone();
        $this->browse(function (Browser $browser) {
            $browser->pause(5000)
                ->click('#DataTables_Table_0 > tbody > tr > td:nth-child(7) > div > button')
                ->click('#DataTables_Table_0 > tbody > tr > td:nth-child(7) > div > div > a.dropdown-item.delete_zone')
                ->whenAvailable('#item_delete_form', function($modal){
                    $modal->click('#dataDeleteBtn');
                })
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Deleted successfully!');
        });
    }

    public function test_for_status_change(){
        $this->test_for_create_new_user_zone();
        $this->browse(function (Browser $browser) {
            $browser->pause(5000)
                ->click('#DataTables_Table_0 > tbody > tr > td:nth-child(7) > label > div')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');
        });    
    }

    public function test_for_features_change(){
        $this->test_for_create_new_user_zone();
        $this->browse(function (Browser $browser) {
            $browser->pause(5000)
                ->click('#DataTables_Table_0 > tbody > tr > td:nth-child(8) > label > div')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');
        });  
    }

}
