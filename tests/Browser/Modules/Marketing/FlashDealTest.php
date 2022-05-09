<?php

namespace Tests\Browser\Modules\Marketing;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Modules\Marketing\Entities\FlashDeal;
use Modules\Marketing\Entities\FlashDealProduct;
use Tests\DuskTestCase;

use Modules\Product\Entities\Brand;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductSku;
use Modules\Product\Entities\UnitType;
use Modules\Seller\Entities\SellerProduct;
use Modules\Seller\Entities\SellerProductSKU;
use Modules\Shipping\Entities\ProductShipping;
use Modules\Shipping\Entities\ShippingMethod;

class FlashDealTest extends DuskTestCase
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

        $deals = FlashDeal::all();
        foreach($deals as $deal){
            FlashDealProduct::destroy($deal->products->pluck('id'));
            $deal->delete();
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
                    ->visit('/marketing/flash-deals')
                    ->assertSee('Flash Deal List');
        });
        
    }

    public function test_for_visit_create_page()
    {
        $this->test_for_visit_index_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#main-content > section > div > div > div.col-12 > div > div > ul > li > a')
                    ->assertPathIs('/marketing/flash-deals/create')
                    ->assertSee('Create Flash Deal')
                    ->type('#title', 'test flash deal')
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
                    ->click('#date')
                    ->pause(1000)
                    ->click('div.daterangepicker.ltr.show-calendar.opensright > div.drp-calendar.left > div.calendar-table > table > tbody > tr:nth-child(1) > td:nth-child(5)')
                    ->pause(1000)
                    ->click('div.daterangepicker.ltr.show-calendar.opensright > div.drp-calendar.right > div.calendar-table > table > tbody > tr:nth-child(6) > td:nth-child(2)')
                    ->pause(1000)
                    ->click('div.daterangepicker.ltr.show-calendar.opensright > div.drp-buttons > button.applyBtn.btn.btn-sm.btn-primary')
                    ->pause(1000)
                    ->click('#formHtml > div > div > div:nth-child(1) > div:nth-child(7) > div > div')
                    ->click('#formHtml > div > div > div:nth-child(1) > div:nth-child(7) > div > div > ul > li:nth-child(2)')
                    ->pause(9000)
                    ->click('#formHtml > div > div > div:nth-child(1) > div:nth-child(7) > div > div')
                    ->click('#formHtml > div > div > div:nth-child(1) > div:nth-child(7) > div > div > ul > li:nth-child(3)')
                    ->pause(9000)
                    ->click('#sku_tbody > tr:nth-child(2) > td.text-center.pt-25 > a > i')
                    ->pause(1000)
                    ->click('#formHtml > div > div > div:nth-child(1) > div:nth-child(7) > div > div')
                    ->click('#formHtml > div > div > div:nth-child(1) > div:nth-child(7) > div > div > ul > li:nth-child(4)')
                    ->pause(9000)
                    ->click('#submit_btn')
                    ->assertPathIs('/marketing/flash-deals')
                    ->waitFor('.toast-message',25)
                    ->assertSeeIn('.toast-message', 'Created successfully!');


        });
        
    }

    public function test_for_validate_create_form(){
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/marketing/flash-deals/create')
                ->assertSee('Create Flash Deal')
                ->click('#submit_btn')
                ->assertPathIs('/marketing/flash-deals/create')
                ->assertSeeIn('#error_title', 'The title field is required.')
                ->assertSeeIn('#error_background_color', 'The background color field is required.')
                ->assertSeeIn('#error_text_color', 'The text color field is required.')
                ->assertSeeIn('#error_banner_image', 'The banner image field is required.')
                ->assertSeeIn('#error_date', 'The date field is required.')
                ->assertSeeIn('#formHtml > div > div > div:nth-child(1) > div:nth-child(7) > div > span', 'The products field is required.');

        });
    }

    public function test_for_edit_flash_deal(){
        $this->test_for_visit_create_page();
        $this->browse(function (Browser $browser) {
            $flash_deal = FlashDeal::latest()->first();
            $browser->click('#DataTables_Table_0 > tbody > tr > td:nth-child(9) > div > button')
                ->click('#DataTables_Table_0 > tbody > tr > td:nth-child(9) > div > div > a.dropdown-item.edit_brand')
                ->assertPathIs('/marketing/flash-deals/edit/'.$flash_deal->id)
                ->assertSee('Update Flash Deal')
                ->click('#sku_tbody > tr:nth-child(2) > td.text-center.pt-25 > a > i')
                ->pause(1000)
                ->type('#title', 'test flash deal edit')
                ->click('#background_color')
                ->pause(1000)
                ->click('div:nth-child(64) > div.sp-palette-container > div.sp-palette.sp-thumb.sp-cf > div.sp-cf.sp-palette-row.sp-palette-row-0 > span:nth-child(7) > span')
                ->click('div:nth-child(64) > div.sp-picker-container > div.sp-button-container.sp-cf > button.sp-choose')
                ->pause(1000)
                ->click('#text_color')
                ->pause(1000)
                ->click('div:nth-child(65) > div.sp-palette-container > div.sp-palette.sp-thumb.sp-cf > div.sp-cf.sp-palette-row.sp-palette-row-0 > span:nth-child(1) > span')
                ->click('div:nth-child(65) > div.sp-picker-container > div.sp-button-container.sp-cf > button.sp-choose')
                ->pause(1000)
                ->attach('#banner_image', __DIR__.'/files/banner_image.png')
                ->click('#date')
                ->pause(1000)
                ->click('div.daterangepicker.ltr.show-calendar.opensright > div.drp-calendar.left > div.calendar-table > table > tbody > tr:nth-child(1) > td:nth-child(6)')
                ->pause(1000)
                ->click('div.daterangepicker.ltr.show-calendar.opensright > div.drp-calendar.right > div.calendar-table > table > tbody > tr:nth-child(5) > td:nth-child(7)')
                ->pause(1000)
                ->click('div.daterangepicker.ltr.show-calendar.opensright > div.drp-buttons > button.applyBtn.btn.btn-sm.btn-primary')
                ->pause(1000)
                ->click('#formHtml > div > div > div:nth-child(1) > div:nth-child(7) > div > div')
                ->click('#formHtml > div > div > div:nth-child(1) > div:nth-child(7) > div > div > ul > li:nth-child(3)')
                ->pause(10000)
                ->click('#submit_btn')
                ->assertPathIs('/marketing/flash-deals')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');
        });
        
    }

    public function test_for_validate_edit_form(){
        $this->test_for_visit_create_page();
        $this->browse(function (Browser $browser) {
            $flash_deal = FlashDeal::latest()->first();
            $browser->click('#DataTables_Table_0 > tbody > tr > td:nth-child(9) > div > button')
                ->click('#DataTables_Table_0 > tbody > tr > td:nth-child(9) > div > div > a.dropdown-item.edit_brand')
                ->assertPathIs('/marketing/flash-deals/edit/'.$flash_deal->id)
                ->assertSee('Update Flash Deal')
                ->click('#sku_tbody > tr:nth-child(2) > td.text-center.pt-25 > a > i')
                ->pause(1000)
                ->click('#sku_tbody > tr > td.text-center.pt-25 > a > i')
                ->pause(1000)
                ->type('#title', '')
                ->type('#background_color', '')
                ->click('#formHtml > div > div > div:nth-child(1) > div:nth-child(1) > div > label')
                ->pause(1000)
                ->type('#text_color', '')
                ->click('#formHtml > div > div > div:nth-child(1) > div:nth-child(1) > div > label')
                ->pause(1000)
                ->click('#submit_btn')
                ->assertPathIs('/marketing/flash-deals/edit/'.$flash_deal->id)
                ->assertSeeIn('#error_title', 'The title field is required.')
                ->assertSeeIn('#error_background_color', 'The background color field is required.')
                ->assertSeeIn('#error_text_color', 'The text color field is required.')
                ->assertSeeIn('#formHtml > div > div > div:nth-child(1) > div:nth-child(7) > div > span', 'The products field is required.');
            
        });
    }

    public function test_for_delete_flash_deal(){
        $this->test_for_visit_create_page();
        $this->browse(function (Browser $browser) {
            $browser->pause(6000)
                ->click('#DataTables_Table_0 > tbody > tr > td:nth-child(9) > div > button')
                ->click('#DataTables_Table_0 > tbody > tr > td:nth-child(9) > div > div > a.dropdown-item.delete_deal')
                ->whenAvailable('#item_delete_form', function($modal){
                    $modal->click('#dataDeleteBtn');
                })
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Deleted successfully!');
        });
    }

    public function test_for_status_change(){
        $this->test_for_visit_create_page();
        $this->browse(function (Browser $browser) {
            $browser->pause(6000)
                ->click('#DataTables_Table_0 > tbody > tr > td:nth-child(7) > label > div')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');
        });    
    }

    public function test_for_is_featured_change(){
        $this->test_for_visit_create_page();
        $this->browse(function (Browser $browser) {
            $browser->pause(6000)
                ->click('#DataTables_Table_0 > tbody > tr > td:nth-child(8) > label > div')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');
        });    
    }
}
