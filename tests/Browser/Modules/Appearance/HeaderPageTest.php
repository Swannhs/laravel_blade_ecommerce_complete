<?php

namespace Tests\Browser\Modules\Appearance;

use App\Models\User;
use App\Traits\ImageStore;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\File;
use Laravel\Dusk\Browser;
use Modules\Appearance\Entities\HeaderCategoryPanel;
use Modules\Appearance\Entities\HeaderProductPanel;
use Modules\Appearance\Entities\HeaderSliderPanel;
use Modules\Marketing\Entities\NewUserZone;
use Modules\Product\Entities\Brand;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductSku;
use Modules\Product\Entities\UnitType;
use Modules\Seller\Entities\SellerProduct;
use Modules\Seller\Entities\SellerProductSKU;
use Modules\Shipping\Entities\ShippingMethod;
use Tests\DuskTestCase;

class HeaderPageTest extends DuskTestCase
{
    use WithFaker;
    use ImageStore;

    protected $categories =[];
    protected $brands =[];
    protected $units =[];
    protected $shipping_methods =[];
    protected $products =[];
    protected $productSKUS =[];
    protected $sellerProducts = [];
    protected $sellerProductSKUS = [];

    protected $new_user_zone; 

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

        $this->new_user_zone = NewUserZone::create([
            'title' => $this->faker->title,
            'text_color' => '#000',
            'background_color' => '#fff',
            'slug' => $this->faker->slug,
            'product_navigation_label' => $this->faker->title,
            'category_navigation_label' => $this->faker->title,
            'coupon_navigation_label' => $this->faker->title,
            'product_slogan' => $this->faker->title,
            'category_slogan' => $this->faker->title,
            'coupon_slogan' => $this->faker->title,
            'banner_image' => 'backend/testing/60dfe802a57ab.png',
            'status' => 1,
            'coupon' => 1
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

        foreach ($this->sellerProducts as $product) {
            $product->delete();
        }

        foreach ($this->sellerProductSKUS as $sku) {
            $sku->delete();
        }

        $this->new_user_zone->delete();

        $sliders = HeaderSliderPanel::all();
        foreach($sliders as $slider){
            ImageStore::deleteImage($slider->slider_image);
            $slider->delete();
        }
        

        $cat_items = HeaderCategoryPanel::pluck('id');
        HeaderCategoryPanel::destroy($cat_items);

        $product_items = HeaderProductPanel::pluck('id');
        HeaderProductPanel::destroy($product_items);

        parent::tearDown(); // TODO: Change the autogenerated stub
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_for_visit_header_index_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/appearance/headers')
                    ->assertSee('Header Setup');
        });
    }

    public function test_for_visit_slider_setup_page()
    {
        $this->test_for_visit_header_index_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#sku_tbody > tr:nth-child(1) > td:nth-child(5) > div > button')
                    ->click('#sku_tbody > tr:nth-child(1) > td:nth-child(5) > div > div > a')
                    ->assertPathIs('/appearance/headers/setup/'. 1)
                    ->assertSee('Slider Section General Setting');
        });
    }

    public function test_for_update_slider_section(){
        $this->test_for_visit_slider_setup_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#category_genaral_form > div > div:nth-child(3) > div > div')
                ->pause(1000)
                ->click('#category_genaral_form > div > div:nth-child(3) > div > div > ul > li:nth-child(9)')
                ->click('#category_genaral_form > div > div.col-lg-12.text-center > div > button')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');
        });
    }

    public function test_for_create_slider(){
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/appearance/headers/setup/'. 1)
                ->assertSee('Slider Section General Setting')
                ->click('#main-content > section > div.container-fluid.p-0 > div > div > div > ul > li:nth-child(2)')
                ->waitFor('#name',2)
                ->type('#name', 'test slider 1')
                ->click('#slider_data_type_div > div > div')
                ->click('#slider_data_type_div > div > div > ul > li:nth-child(3)')
                ->waitFor('#slider_for_data_div > div > div', 25)
                ->click('#slider_for_data_div > div > div')
                ->click('#slider_for_data_div > div > div > ul > li:nth-child(1)')
                ->attach('#slider_image', public_path('/frontend/default/img/slider_img.png'))
                ->click('#theme_nav > li:nth-child(2) > label > span')
                ->click('#widget_form_btn')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Added successfully!');
        });
    }

    public function test_for_validate_add_slider(){
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/appearance/headers/setup/'. 1)
                ->assertSee('Slider Section General Setting')
                ->click('#main-content > section > div.container-fluid.p-0 > div > div > div > ul > li:nth-child(2)')
                ->waitFor('#name',2)
                ->click('#widget_form_btn')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Slider Image Required');
        });
    }

    public function test_for_edit_slider(){
        $this->test_for_create_slider();
        $this->browse(function (Browser $browser) {
            $slider = HeaderSliderPanel::latest()->first();
            $browser->click('#accordion_'.$slider->id.' > div.card-header.card_header_element > div > a.d-inline.mr-10.primary-btn.panel-title')
                ->pause(1000)
                ->type('#element_edit_form > div > div:nth-child(4) > div > input', 'test slider 1')
                ->click('#element_edit_form > div > div:nth-child(6) > div > div')
                ->click('#element_edit_form > div > div:nth-child(6) > div > div > ul > li:nth-child(1)')
                ->attach('#element_edit_form > div > div.col-lg-8 > div > div > button > input', public_path('/frontend/default/img/slider_img.png'))
                ->click('#element_edit_form > div > div:nth-child(9) > div > ul > li:nth-child(1) > label > span')
                ->pause(5000)
                ->click('#element_edit_form > div > div.col-lg-12.text-center > div > button')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');
        });
    }

    public function test_for_delete_slider(){
        $this->test_for_create_slider();
        $this->browse(function (Browser $browser) {
            $slider = HeaderSliderPanel::latest()->first();
            $browser->click('#accordion_'.$slider->id.' > div.card-header.card_header_element > div > a.d-inline.primary-btn.slider_delete_btn')
            ->whenAvailable('#slider_delete_form', function($modal){
                $modal->pause(5000)
                    ->click('#sliderDeleteBtn');
            })
            ->waitFor('.toast-message',25)
            ->assertSeeIn('.toast-message', 'Deleted successfully!');
        });
    }

    public function test_for_visit_category_section_setup_page()
    {
        $this->test_for_visit_header_index_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#sku_tbody > tr:nth-child(2) > td:nth-child(5) > div > button')
                    ->click('#sku_tbody > tr:nth-child(2) > td:nth-child(5) > div > div > a')
                    ->assertPathIs('/appearance/headers/setup/'. 2)
                    ->assertSee('Category Section General Setting');
        });
    }

    public function test_for_update_category_section(){
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/appearance/headers/setup/'. 2)
                ->assertSee('Category Section General Setting')
                ->click('#category_genaral_form > div > div:nth-child(3) > div > div')
                ->pause(1000)
                ->click('#category_genaral_form > div > div:nth-child(3) > div > div > ul > li:nth-child(4)')
                ->click('#category_genaral_form > div > div.col-lg-12.text-center > div > button')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');
        });
        
    }

    public function test_for_create_add_category(){
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/appearance/headers/setup/'. 2)
                ->assertSee('Category Section General Setting')
                ->click('#main-content > section > div.container-fluid.p-0 > div > div > div > ul > li:nth-child(2)')
                ->waitFor('#add_element_form > div > div.col-lg-12 > div > div',3)
                ->click('#add_element_form > div > div.col-lg-12 > div > div')
                ->click('#add_element_form > div > div.col-lg-12 > div > div > ul > li:nth-child(1)')
                ->click('#add_element_form > div > div.col-lg-12 > div > div')
                ->click('#add_element_form > div > div.col-lg-12 > div > div > ul > li:nth-child(2)')
                ->click('#widget_form_btn')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Added successfully!');
        });
    }

    public function test_for_edit_category_for_category_section(){
        $this->test_for_create_add_category();
        $this->browse(function (Browser $browser) {
            $item = HeaderCategoryPanel::latest()->first();
            $browser->click('#accordion_'.$item->id.' > div.card-header.card_header_element > div > a.d-inline.mr-10.primary-btn.panel-title')
                ->waitFor('#element_edit_form > div > div:nth-child(4) > div > input', 3)
                ->type('#element_edit_form > div > div:nth-child(4) > div > input', $this->faker->name)
                ->click('#element_edit_form > div > div:nth-child(5) > div > div')
                ->click('#element_edit_form > div > div:nth-child(5) > div > div > ul > li:nth-child(2)')
                ->click('#element_edit_form > div > div.col-xl-12 > div > ul > li > label > span')
                ->pause(5000)
                ->click('#element_edit_form > div > div.col-lg-12.text-center > div > button')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');
                
        });
    }


    public function test_for_delete_category_for_category_section(){
        $this->test_for_create_add_category();
        $this->browse(function (Browser $browser) {
            $item = HeaderCategoryPanel::latest()->first();
            $browser->click('#accordion_'.$item->id.' > div.card-header.card_header_element > div > a.d-inline.primary-btn.category_delete_btn')
                ->whenAvailable('#category_delete_form', function($modal){
                    $modal->pause(5000)
                        ->click('#categoryDeleteBtn');
                })
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Deleted successfully!');
        });
    }


    public function test_for_visit_product_section_setup_page()
    {
        $this->test_for_visit_header_index_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#sku_tbody > tr:nth-child(3) > td:nth-child(5) > div > button')
                    ->click('#sku_tbody > tr:nth-child(3) > td:nth-child(5) > div > div > a')
                    ->assertPathIs('/appearance/headers/setup/'. 3)
                    ->assertSee('Product Section General Setting');
        });
    }

    public function test_for_update_product_section(){
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/appearance/headers/setup/'. 3)
                ->assertSee('Product Section General Setting')
                ->click('#category_genaral_form > div > div:nth-child(3) > div > div')
                ->pause(1000)
                ->click('#category_genaral_form > div > div:nth-child(3) > div > div > ul > li:nth-child(9)')
                ->click('#category_genaral_form > div > div.col-lg-12.text-center > div > button')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');
        });
    }

    public function test_for_add_product_for_product_section(){
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/appearance/headers/setup/'. 3)
                ->assertSee('Product Section General Setting')
                ->click('#main-content > section > div.container-fluid.p-0 > div > div > div > ul > li:nth-child(2)')
                ->waitFor('#add_element_form > div > div.col-lg-12 > div > div', 3)
                ->click('#add_element_form > div > div.col-lg-12 > div > div')
                ->click('#add_element_form > div > div.col-lg-12 > div > div > ul > li:nth-child(1)')
                ->click('#add_element_form > div > div.col-lg-12 > div > div')
                ->click('#add_element_form > div > div.col-lg-12 > div > div > ul > li:nth-child(2)')
                ->click('#widget_form_btn')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Added successfully!');
        });
    }

    public function test_for_edit_product_for_product_section(){
        $this->test_for_add_product_for_product_section();
        $this->browse(function (Browser $browser) {
            $item = HeaderProductPanel::latest()->first();
            $browser->click('#accordion_'.$item->id.' > div.card-header.card_header_element > div > a.d-inline.mr-10.primary-btn.panel-title')
                    ->waitFor('#element_edit_form > div > div:nth-child(4) > div > input', 3)
                    ->type('#element_edit_form > div > div:nth-child(4) > div > input', $this->faker->title)
                    ->click('#element_edit_form > div > div:nth-child(5) > div > div')
                    ->click('#element_edit_form > div > div:nth-child(5) > div > div > ul > li:nth-child(3)')
                    ->click('#element_edit_form > div > div.col-xl-12 > div > ul > li > label > span')
                    ->pause(5000)
                    ->click('#element_edit_form > div > div.col-lg-12.text-center > div > button')
                    ->waitFor('.toast-message',25)
                    ->assertSeeIn('.toast-message', 'Updated successfully!');
        });
    }

    public function test_for_delete_product_for_product_section(){
        $this->test_for_add_product_for_product_section();
        $this->browse(function (Browser $browser) {
            $item = HeaderProductPanel::latest()->first();
            $browser->click('#accordion_'.$item->id.' > div.card-header.card_header_element > div > a.d-inline.primary-btn.product_delete_btn')
                ->whenAvailable('#product_delete_form', function($modal){
                    $modal->pause(5000)
                        ->click('#productDeleteBtn');
                })
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Deleted successfully!');
            
        });
    }


    public function test_for_visit_new_user_zone_section_setup_page()
    {
        $this->test_for_visit_header_index_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#sku_tbody > tr:nth-child(4) > td:nth-child(5) > div > button')
                    ->click('#sku_tbody > tr:nth-child(4) > td:nth-child(5) > div > div > a')
                    ->assertPathIs('/appearance/headers/setup/'. 4)
                    ->assertSee('New User Zone Section General Setting');
        });
    }

    public function test_for_update_new_user_zone_section(){
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/appearance/headers/setup/'. 4)
                ->assertSee('New User Zone Section General Setting')
                ->click('#category_genaral_form > div > div:nth-child(3) > div > div')
                ->pause(1000)
                ->click('#category_genaral_form > div > div:nth-child(3) > div > div > ul > li:nth-child(5)')
                ->click('#category_genaral_form > div > div.col-lg-12.text-center > div > button')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');
        });
    }

    public function test_for_update_new_user_zone_data(){
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/appearance/headers/setup/'. 4)
                ->assertSee('New User Zone Section General Setting')
                ->click('#main-content > section > div.container-fluid.p-0 > div > div > div > ul > li:nth-child(2)')
                ->waitFor('#element_edit_form > div > div:nth-child(3) > div > #navigation_label_id', 4)
                ->type('#element_edit_form > div > div:nth-child(3) > div > #navigation_label_id', $this->faker->title)
                ->type('#element_edit_form > div > div:nth-child(4) > div > #title_id', $this->faker->title)
                ->type('#pricing_id', 'USD 7')
                ->click('#element_edit_form > div > div:nth-child(6) > div > div')
                ->click('#element_edit_form > div > div:nth-child(6) > div > div > ul > li')
                ->click('#widget_form_btn')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');
                
        });
    }

    public function test_for_validate_new_user_zone_update(){
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/appearance/headers/setup/'. 4)
                ->assertSee('New User Zone Section General Setting')
                ->click('#main-content > section > div.container-fluid.p-0 > div > div > div > ul > li:nth-child(2)')
                ->waitFor('#element_edit_form > div > div:nth-child(3) > div > #navigation_label_id', 5)
                ->type('#element_edit_form > div > div:nth-child(3) > div > #navigation_label_id', '')
                ->type('#element_edit_form > div > div:nth-child(4) > div > #title_id', '')
                ->type('#pricing_id', '')
                ->click('#widget_form_btn')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Navigation label is required');
        });
    }


}
