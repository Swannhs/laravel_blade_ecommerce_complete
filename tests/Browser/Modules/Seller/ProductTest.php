<?php

namespace Tests\Browser\Modules\Seller;

use App\Models\User;
use Facebook\WebDriver\WebDriverBy;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
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

class ProductTest extends DuskTestCase
{
    use WithFaker;

    protected $categories =[];
    protected $brands =[];
    protected $units =[];
    protected $shipping_methods =[];
    protected $products = [];
    protected $productSKUS = [];
    protected $product_shippings = [];


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

            
        }

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
            'product_id' => $this->products[0]->id,
            'shipping_method_id' => $this->shipping_methods[0]->id,
        ]);

        $this->productSKUS[] = ProductSku::create([
            'product_id' => $this->products[0]->id,
            'sku' =>  'sku-7485722'.$this->products[0]->id,
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
        ]);


        $this->products[] = Product::create([
            'product_type' => 2,
            'product_name' => $this->faker->name,
            'model_number' => 'euirwe7457845',
            'category_id' => $this->categories[1]->id,
            'brand_id' => $this->brands[1]->id,
            'unit_type_id' => $this->units[1]->id,
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
            'product_id' => $this->products[1]->id,
            'shipping_method_id' => $this->shipping_methods[1]->id,
        ]);

        $this->productSKUS[] = ProductSku::create([
            'product_id' => $this->products[1]->id,
            'sku' =>  'sku-748578'.$this->products[1]->id,
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
        ]);

        $this->productSKUS[] = ProductSku::create([
            'product_id' => $this->products[1]->id,
            'sku' =>  'sku-748579'.$this->products[1]->id,
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
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



        parent::tearDown(); // TODO: Change the autogenerated stub
    }


    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_for_visit_product_list_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(5)
                ->visit('/seller/product');
        });

    }




    public function test_for_create_new_single_product()
    {
        $this->test_for_visit_product_list_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#main-content > section > div > div.row > div.col-md-12.mb-20 > div > div > ul > li:nth-child(6) > a')
                ->assertPathIs('/seller/products/create')
                ->assertSee('Add Product')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > div:nth-child(1) > div > div > div')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > div:nth-child(1) > div > div > div > ul > li:nth-child(2)')
                ->pause(1000)
                ->assertSee('Product Information')
                ->type('#product_name_new', $this->faker->name)
                ->type('#sku_single', $this->faker->slug)
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(5) > div > input', $this->faker->name)
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(6) > div > div')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(6) > div > div > ul > li:nth-child(2)')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(7) > div > div')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(7) > div > div > ul > li:nth-child(2)')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(8) > div > div')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(8) > div > div > ul > li:nth-child(2)')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(9) > div > div')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(9) > div > div > ul > li:nth-child(2)')
                ->type('#minimum_order_qty', '2')
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(11) > div > input', '10')
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(1) > div.tagInput_field.mb_26 > div > input[type=text]', $this->faker->title)
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(2) > div > div > div.note-editing-area > div.note-editable', $this->faker->paragraph)
                ->type('#selling_price', '250')
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(5) > div > input', '10')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(6) > div > div')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(6) > div > div > ul > li:nth-child(2)')
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(7) > div > input', '5')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(8) > div > div')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(8) > div > div > ul > li:nth-child(2)')
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(10) > div > div > div.note-editing-area > div.note-editable', $this->faker->paragraph)
                ->type('#phisical_shipping_div > div > div > div > input', '0')
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(16) > div > input', $this->faker->title)
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(17) > div > textarea', $this->faker->paragraph)
                ->attach('#meta_image', __DIR__.'/files/mi.png')
                ->attach('#choice_form > div > div.col-lg-4 > div > div > div.col-lg-10 > div > div > button > input', __DIR__.'/files/product_details.png')
                ->attach('#choice_form > div > div.col-lg-4 > div > div > div:nth-child(5) > div > div > button > input', __DIR__.'/files/product_details_2.png')
                ->attach('#choice_form > div > div.col-lg-4 > div > div > div:nth-child(7) > div > div > button > input', __DIR__.'/files/digital_file.pdf')
                ->click('#choice_form > div > div.col-lg-4 > div > div > div.col-lg-12.shipping_type_div > div > div')
                ->click('#choice_form > div > div.col-lg-4 > div > div > div.col-lg-12.shipping_type_div > div > div > ul > li:nth-child(1)')
                ->type('#choice_form > div > div.col-lg-4 > div > div > div:nth-child(12) > div > input', $this->faker->slug)
                ->click('#choice_form > div > div.col-lg-4 > div > div > div.col-12 > button')
                ->assertPathIs('/seller/product')
                ->waitFor('.toast-message',30)
                ->assertSeeIn('.toast-message', 'Product added Successfully!');
        });

    }

    public function test_for_edit_new_single_product(){
        $this->test_for_create_new_single_product();
        $this->browse(function (Browser $browser) {
            $product = Product::latest()->first();
            $browser->click('#my_product_list_li > a')
                ->waitFor('#mainProductTable > tbody > tr > td:nth-child(8) > div > button',30)
                ->click('#mainProductTable > tbody > tr > td:nth-child(8) > div > button')
                ->click('#mainProductTable > tbody > tr > td:nth-child(8) > div > div > a:nth-child(2)')
                ->assertPathIs('/seller/product/'.$product->id.'/edit')
                ->assertSee('Edit Product')
                ->type('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(5) > div > input', $this->faker->name)
                ->type('#sku_single', rand(1111111111,9999999999))
                ->type('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(7) > div > input', $this->faker->name)
                ->click('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(8) > div > div')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(8) > div > div > ul > li:nth-child(3)')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(9) > div > div')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(9) > div > div > ul > li:nth-child(3)')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(10) > div > div')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(10) > div > div > ul > li:nth-child(3)')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(11) > div > div')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(11) > div > div > ul > li:nth-child(4)')
                ->type('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(12) > div > input', '5')
                ->type('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(13) > div > input', '10')
                ->type('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(1) > div > div > div > input[type=text]', 'test 2')
                ->type('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(2) > div > div > div.note-editing-area > div.note-editable', $this->faker->paragraph)
                ->type('#selling_price', '300')
                ->type('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(5) > div > input', '10')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(6) > div > div')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(6) > div > div > ul > li:nth-child(1)')
                ->type('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(7) > div > input', '15')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(8) > div > div')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(8) > div > div > ul > li:nth-child(1)')
                ->type('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(10) > div > div > div.note-editing-area > div.note-editable', $this->faker->paragraph)
                ->type('#phisical_shipping_div > div > div > div > input', '20')
                ->type('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(15) > div > input', $this->faker->title)
                ->type('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(16) > div > textarea', $this->faker->name)
                ->attach('#meta_image', __DIR__.'/files/product_details.png')
                ->attach('#thumbnail_image', __DIR__.'/files/product_details.png')
                ->attach('#galary_image', __DIR__.'/files/product_details.png')
                ->attach('#pdf_file', __DIR__.'/files/digital_file.pdf')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-4 > div > div > div.col-lg-12.shipping_type_div > div > div > span')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-4 > div > div > div.col-lg-12.shipping_type_div > div > div > ul > li:nth-child(3)')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-4 > div > div > div.col-12.text-center > button')
                ->assertPathIs('/seller/product')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Product Updated Successfully!');

        });
    }

    public function test_for_create_digital_new_single_product(){
        $this->test_for_visit_product_list_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#main-content > section > div > div.row > div.col-md-12.mb-20 > div > div > ul > li:nth-child(6) > a')
                ->assertPathIs('/seller/products/create')
                ->assertSee('Add Product')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > div:nth-child(1) > div > div > div')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > div:nth-child(1) > div > div > div > ul > li:nth-child(2)')
                ->pause(1000)
                ->assertSee('Product Information')
                ->type('#product_name_new', $this->faker->name)
                ->type('#sku_single', $this->faker->slug)
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(5) > div > input', $this->faker->name)
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(6) > div > div')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(6) > div > div > ul > li:nth-child(2)')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(7) > div > div')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(7) > div > div > ul > li:nth-child(2)')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(8) > div > div')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(8) > div > div > ul > li:nth-child(2)')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(9) > div > div')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(9) > div > div > ul > li:nth-child(2)')
                ->type('#minimum_order_qty', '2')
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(11) > div > input', '10')
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(1) > div.tagInput_field.mb_26 > div > input[type=text]', $this->faker->title)
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(2) > div > div > div.note-editing-area > div.note-editable', $this->faker->paragraph)
                ->type('#selling_price', '250')
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(5) > div > input', '10')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(6) > div > div')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(6) > div > div > ul > li:nth-child(2)')
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(7) > div > input', '5')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(8) > div > div')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(8) > div > div > ul > li:nth-child(2)')
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(10) > div > div > div.note-editing-area > div.note-editable', $this->faker->paragraph)
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div.col-xl-12 > div > ul > li > label > span')
                ->pause(1000)
                ->attach('#digital_file', __DIR__.'/files/digital_file.pdf')
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(16) > div > input', $this->faker->title)
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(17) > div > textarea', $this->faker->paragraph)
                ->attach('#meta_image', __DIR__.'/files/mi.png')
                ->attach('#thumbnail_image', __DIR__.'/files/product_details.png')
                ->attach('#galary_image', __DIR__.'/files/product_details_2.png')
                ->attach('#pdf', __DIR__.'/files/digital_file.pdf')
                ->click('#choice_form > div > div.col-lg-4 > div > div > div.col-12 > button')
                ->assertPathIs('/seller/product')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Product added Successfully!');
        });        
    }

    public function test_for_edit_digital_new_single_product(){
        $this->test_for_create_digital_new_single_product();
        $this->browse(function (Browser $browser) {
            $product = Product::latest()->first();
            $browser->click('#my_product_list_li > a')
                ->waitFor('#mainProductTable > tbody > tr > td:nth-child(8) > div > button',30)
                ->click('#mainProductTable > tbody > tr > td:nth-child(8) > div > button')
                ->click('#mainProductTable > tbody > tr > td:nth-child(8) > div > div > a:nth-child(2)')
                ->assertPathIs('/seller/product/'.$product->id.'/edit')
                ->assertSee('Edit Product')
                ->type('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(5) > div > input', $this->faker->name)
                ->type('#sku_single', rand(1111111111,9999999999))
                ->type('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(7) > div > input', 'test model number')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(8) > div > div')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(8) > div > div > ul > li:nth-child(4)')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(9) > div > div')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(9) > div > div > ul > li:nth-child(3)')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(10) > div > div')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(10) > div > div > ul > li:nth-child(3)')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(11) > div > div')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(11) > div > div > ul > li:nth-child(4)')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(12) > div > input', '5')
                ->type('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(13) > div > input', '10')
                ->type('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(1) > div > div > div > input[type=text]', 'testhasjkj')
                ->type('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(2) > div > div > div.note-editing-area > div.note-editable', $this->faker->paragraph)
                ->type('#selling_price', '400')
                ->type('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(5) > div > input', '8')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(6) > div > div')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(6) > div > div > ul > li:nth-child(2)')
                ->type('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(7) > div > input', '9')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(8) > div > div')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(8) > div > div > ul > li:nth-child(2)')
                ->type('#choice_form > div:nth-child(3) > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(10) > div > div > div.note-editing-area > div.note-editable', $this->faker->paragraph)
                ->attach('#digital_file', __DIR__.'/files/digital_file.pdf')
                ->attach('#thumbnail_image', __DIR__.'/files/product_details_2.png')
                ->attach('#galary_image', __DIR__.'/files/product_details_2.png')
                ->click('#choice_form > div:nth-child(3) > div.col-lg-4 > div > div > div.col-12.text-center > button')
                ->assertPathIs('/seller/product')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Product Updated Successfully!');

        });
    }

    public function test_for_create__new_variant_product(){
        $this->test_for_visit_product_list_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#main-content > section > div > div.row > div.col-md-12.mb-20 > div > div > ul > li:nth-child(6) > a')
                ->assertPathIs('/seller/products/create')
                ->assertSee('Add Product')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > div:nth-child(1) > div > div > div')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > div:nth-child(1) > div > div > div > ul > li:nth-child(2)')
                ->pause(1000)
                ->assertSee('Product Information')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(2) > div > div')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(2) > div > div > ul > li:nth-child(2)')
                ->type('#product_name_new', $this->faker->name)
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(5) > div > input', $this->faker->name)
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(6) > div > div')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(6) > div > div > ul > li:nth-child(2)')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(7) > div > div')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(7) > div > div > ul > li:nth-child(2)')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(8) > div > div')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(8) > div > div > ul > li:nth-child(2)')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(9) > div > div')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(9) > div > div > ul > li:nth-child(2)')
                ->click('#minimum_order_qty', '2')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div:nth-child(11) > div > input', '10')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div.col-lg-12.attribute_div > div > div')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(1) > div.col-lg-12.attribute_div > div > div > ul > li:nth-child(2)')
                ->waitFor('#customer_choice_options > div > div.col-lg-4 > div > input', 25)
                ->click('#customer_choice_options > div > div.col-lg-8 > div > div')
                ->click('#customer_choice_options > div > div.col-lg-8 > div > div > ul > li:nth-child(1)')
                ->click('#customer_choice_options > div > div.col-lg-8 > div > div')
                ->click('#customer_choice_options > div > div.col-lg-8 > div > div > ul > li:nth-child(2)')
                ->waitFor('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div.col-lg-12.sku_combination > table > tbody > tr:nth-child(1) > td.text-center.pt-36 > label', 30)
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(1) > div.tagInput_field.mb_26 > div > input[type=text]', $this->faker->name)
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(2) > div > div > div.note-editing-area > div.note-editable', $this->faker->paragraph)
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(5) > div > input', '10')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(6) > div > div')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(6) > div > div > ul > li:nth-child(2)')
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(7) > div > input', '5')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(8) > div > div')
                ->click('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(8) > div > div > ul > li:nth-child(2)')
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(10) > div > div > div.note-editing-area > div.note-editable', $this->faker->paragraph)
                ->type('#phisical_shipping_div > div > div > div > input', '0')
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div.col-lg-12.sku_combination > table > tbody > tr:nth-child(1) > td:nth-child(2) > input', '200')
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div.col-lg-12.sku_combination > table > tbody > tr:nth-child(1) > td:nth-child(3) > input', $this->faker->slug)
                ->attach('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div.col-lg-12.sku_combination > table > tbody > tr:nth-child(1) > td.variant_physical_div.text-center.pt_2 > div > div > button > input', __DIR__.'/files/product_details.png')
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div.col-lg-12.sku_combination > table > tbody > tr:nth-child(2) > td:nth-child(2) > input', '210')
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div.col-lg-12.sku_combination > table > tbody > tr:nth-child(2) > td:nth-child(3) > input', $this->faker->name)
                ->attach('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div.col-lg-12.sku_combination > table > tbody > tr:nth-child(2) > td.variant_physical_div.text-center.pt_2 > div > div > button > input', __DIR__.'/files/product_details_2.png')
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(16) > div > input', $this->faker->title)
                ->type('#choice_form > div > div.col-lg-8 > div > div:nth-child(3) > div:nth-child(17) > div > textarea', $this->faker->paragraph)
                ->attach('#meta_image', __DIR__.'/files/mi.png')
                ->attach('#thumbnail_image', __DIR__.'/files/product_details.png')
                ->attach('#galary_image', __DIR__.'/files/product_details_2.png')
                ->attach('#pdf', __DIR__.'/files/digital_file.pdf')
                ->click('#choice_form > div > div.col-lg-4 > div > div > div.col-lg-12.shipping_type_div > div > div')
                ->click('#choice_form > div > div.col-lg-4 > div > div > div.col-lg-12.shipping_type_div > div > div > ul > li:nth-child(2)')
                ->click('#choice_form > div > div.col-lg-4 > div > div > div.col-12 > button')
                ->assertPathIs('/seller/product')
                ->waitFor('.toast-message',30)
                ->assertSeeIn('.toast-message', 'Product added Successfully!');
        });        
    }

    public function test_for_edit__new_variant_product(){
        $this->test_for_create__new_variant_product();
        $this->browse(function (Browser $browser) {
            $product = Product::latest()->first();
            $browser->click('#my_product_list_li > a')
                ->waitFor('#mainProductTable > tbody > tr > td:nth-child(8) > div > button',30)
                ->click('#mainProductTable > tbody > tr > td:nth-child(8) > div > button')
                ->click('#mainProductTable > tbody > tr > td:nth-child(8) > div > div > a:nth-child(2)')
                ->assertPathIs('/seller/product/'.$product->id.'/edit')
                ->assertSee('Edit Product')
                ;
        });
    }


    public function test_for__with_stock_add_single_exsisting_product(){
        $this->test_for_visit_product_list_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#main-content > section > div > div.row > div.col-md-12.mb-20 > div > div > ul > li:nth-child(6) > a')
                ->assertPathIs('/seller/products/create')
                ->assertSee('Add Product')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > div:nth-child(1) > div > div > div')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > div:nth-child(1) > div > div > div > ul > li:nth-child(3)')
                ->pause(1000)
                ->click('#exsisitng_product_div > form > div:nth-child(2) > div:nth-child(2) > div > div')
                ->click('#exsisitng_product_div > form > div:nth-child(2) > div:nth-child(2) > div > div > ul > li:nth-child(2)')
                ->pause(15000)
                ->click('#single_product_stock_manage_div > div > div')
                ->click('#single_product_stock_manage_div > div > div > ul > li:nth-child(1)')
                ->pause(1000)
                ->type('#product_stock', '100')
                ->type('#selling_prices', '220')
                ->type('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(1) > div > input', $this->faker->name)
                ->attach('#thumbnail_image_seller', __DIR__.'/files/product_details_2.png')
                ->type('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(3) > div > input', '10')
                ->click('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(4) > div > div')
                ->click('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(4) > div > div > ul > li:nth-child(2)')
                ->type('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(5) > div > input', '8')
                ->click('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(6) > div > div')
                ->click('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(6) > div > div > ul > li:nth-child(2)')
                ->click('#startDate')
                ->pause(1000)
                ->click('div.datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-bottom > div.datepicker-days > table > tbody > tr:nth-child(1) > td:nth-child(5)')
                ->click('#endDate')
                ->pause(1000)
                ->click('div.datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-bottom > div.datepicker-days > table > tbody > tr:nth-child(5) > td:nth-child(5)')
                ->click('#save_button_parent')
                ->assertPathIs('/seller/product')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Product added Successfully!');
        });
    }

    public function test_for_without_stock_add_single_exsisting_product(){
        $this->test_for_visit_product_list_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#main-content > section > div > div.row > div.col-md-12.mb-20 > div > div > ul > li:nth-child(6) > a')
                ->assertPathIs('/seller/products/create')
                ->assertSee('Add Product')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > div:nth-child(1) > div > div > div')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > div:nth-child(1) > div > div > div > ul > li:nth-child(3)')
                ->pause(1000)
                ->click('#exsisitng_product_div > form > div:nth-child(2) > div:nth-child(2) > div > div')
                ->click('#exsisitng_product_div > form > div:nth-child(2) > div:nth-child(2) > div > div > ul > li:nth-child(2)')
                ->pause(15000)

                ->type('#selling_prices', '220')
                ->type('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(1) > div > input', $this->faker->name)
                ->attach('#thumbnail_image_seller', __DIR__.'/files/product_details_2.png')
                ->type('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(3) > div > input', '10')
                ->click('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(4) > div > div')
                ->click('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(4) > div > div > ul > li:nth-child(2)')
                ->type('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(5) > div > input', '8')
                ->click('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(6) > div > div')
                ->click('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(6) > div > div > ul > li:nth-child(2)')
                ->click('#startDate')
                ->pause(1000)
                ->click('div.datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-bottom > div.datepicker-days > table > tbody > tr:nth-child(1) > td:nth-child(5)')
                ->click('#endDate')
                ->pause(1000)
                ->click('div.datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-bottom > div.datepicker-days > table > tbody > tr:nth-child(5) > td:nth-child(5)')
                ->click('#save_button_parent')
                ->assertPathIs('/seller/product')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Product added Successfully!');
        });
    }

    public function test_for_with_stock_variant_product_add(){
        $this->test_for_visit_product_list_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#main-content > section > div > div.row > div.col-md-12.mb-20 > div > div > ul > li:nth-child(6) > a')
                ->assertPathIs('/seller/products/create')
                ->assertSee('Add Product')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > div:nth-child(1) > div > div > div')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > div:nth-child(1) > div > div > div > ul > li:nth-child(3)')
                ->pause(1000)
                ->click('#exsisitng_product_div > form > div:nth-child(2) > div:nth-child(2) > div > div')
                ->click('#exsisitng_product_div > form > div:nth-child(2) > div:nth-child(2) > div > div > ul > li:nth-child(3)')
                ->pause(15000)
                ->click('#single_product_stock_manage_div > div > div')
                ->click('#single_product_stock_manage_div > div > div > ul > li:nth-child(1)')
                ->click('#variant_sku_div > div > div')
                ->click('#variant_sku_div > div > div > ul > li:nth-child(1)')
                ->click('#variant_sku_div > div > div')
                ->click('#variant_sku_div > div > div > ul > li:nth-child(2)')
                ->waitFor('#sku_tbody > tr > td.text-center.product_sku_name', 30)
                ->type('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(1) > div > input', $this->faker->name)
                ->attach('#thumbnail_image_seller', __DIR__.'/files/product_details_2.png')
                ->type('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(3) > div > input', '20')
                ->click('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(4) > div > div')
                ->click('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(4) > div > div > ul > li:nth-child(1)')
                ->type('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(5) > div > input', '15')
                ->click('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(6) > div > div')
                ->click('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(6) > div > div > ul > li:nth-child(1)')
                ->click('#startDate')
                ->pause(1000)
                ->click('div.datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-top > div.datepicker-days > table > tbody > tr:nth-child(1) > td:nth-child(5)')
                ->click('#endDate')
                ->pause(1000)
                ->click('div.datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-top > div.datepicker-days > table > tbody > tr:nth-child(4) > td:nth-child(4)')
                ->type('#sku_tbody > tr:nth-child(1) > td.text-center.sku_price_td > input', '210')
                ->type('#sku_tbody > tr:nth-child(1) > td.sku_price_td.stock_td > input', '50')
                ->type('#sku_tbody > tr:nth-child(2) > td.text-center.sku_price_td > input', '220')
                ->type('#sku_tbody > tr:nth-child(2) > td.sku_price_td.stock_td > input', '60')
                ->click('#save_button_parent')
                ->assertPathIs('/seller/product')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Product added Successfully!');
        });        
    }

    public function test_for_without_stock_variant_product_add(){
        $this->test_for_visit_product_list_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#main-content > section > div > div.row > div.col-md-12.mb-20 > div > div > ul > li:nth-child(6) > a')
                ->assertPathIs('/seller/products/create')
                ->assertSee('Add Product')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > div:nth-child(1) > div > div > div')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > div:nth-child(1) > div > div > div > ul > li:nth-child(3)')
                ->pause(1000)
                ->click('#exsisitng_product_div > form > div:nth-child(2) > div:nth-child(2) > div > div')
                ->click('#exsisitng_product_div > form > div:nth-child(2) > div:nth-child(2) > div > div > ul > li:nth-child(3)')
                ->pause(15000)
                ->click('#single_product_stock_manage_div > div > div')
                ->click('#single_product_stock_manage_div > div > div > ul > li:nth-child(1)')
                ->click('#variant_sku_div > div > div')
                ->click('#variant_sku_div > div > div > ul > li:nth-child(1)')
                ->click('#variant_sku_div > div > div')
                ->click('#variant_sku_div > div > div > ul > li:nth-child(2)')
                ->waitFor('#sku_tbody > tr > td.text-center.product_sku_name', 25)
                ->type('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(1) > div > input', $this->faker->name)
                ->attach('#thumbnail_image_seller', __DIR__.'/files/product_details_2.png')
                ->type('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(3) > div > input', '20')
                ->click('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(4) > div > div')
                ->click('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(4) > div > div > ul > li:nth-child(1)')
                ->type('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(5) > div > input', '15')
                ->click('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(6) > div > div')
                ->click('#exsisitng_product_div > form > div:nth-child(4) > div:nth-child(6) > div > div > ul > li:nth-child(1)')
                ->click('#startDate')
                ->pause(1000)
                ->click('div.datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-top > div.datepicker-days > table > tbody > tr:nth-child(1) > td:nth-child(5)')
                ->click('#endDate')
                ->pause(1000)
                ->click('div.datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-top > div.datepicker-days > table > tbody > tr:nth-child(4) > td:nth-child(4)')
                ->type('#sku_tbody > tr:nth-child(1) > td.text-center.sku_price_td > input', '210')
                ->type('#sku_tbody > tr:nth-child(2) > td.text-center.sku_price_td > input', '220')
                ->click('#save_button_parent')
                ->assertPathIs('/seller/product')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Product added Successfully!');
        });        
    }

    public function test_for_with_stock_edit_inhouse_single_product(){
        $this->test_for__with_stock_add_single_exsisting_product();
        $this->browse(function (Browser $browser) {
            $product = SellerProduct::where('user_id', auth()->user()->id)->latest()->first();
            $browser->waitFor('#sellerProductTable > tbody > tr:nth-child(1) > td:nth-child(8) > div > button', 30)
                ->click('#sellerProductTable > tbody > tr:nth-child(1) > td:nth-child(8) > div > button')
                ->click('#sellerProductTable > tbody > tr:nth-child(1) > td:nth-child(8) > div > div > a.dropdown-item.edit_brand')
                ->assertPathIs('/seller/product/edit/'.$product->id)
                ->assertSee('Product Update')
                ->type('#product_stock', '50')
                ->type('#selling_price', '220')
                ->type('#tax', '15')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(5) > div:nth-child(2) > div > div')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(5) > div:nth-child(2) > div > div > ul > li:nth-child(2)')
                ->type('#discount', '5')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(5) > div:nth-child(4) > div > div')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(5) > div:nth-child(4) > div > div > ul > li:nth-child(2)')
                ->click('#startDate')
                ->pause(1000)
                ->click('div.datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-bottom > div.datepicker-days > table > tbody > tr:nth-child(1) > td:nth-child(6)')
                ->click('#endDate')
                ->pause(1000)
                ->click('div.datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-bottom > div.datepicker-days > table > tbody > tr:nth-child(5) > td:nth-child(3)')
                ->pause(1000)
                ->click('#save_button_parent')
                ->assertPathIs('/seller/product')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Product updated Successfully!');
        });
    }

    public function test_for_without_stock_edit_inhouse_single_product(){
        $this->test_for_without_stock_add_single_exsisting_product();
        $this->browse(function (Browser $browser) {
            $product = SellerProduct::where('user_id', auth()->user()->id)->latest()->first();
            $browser->waitFor('#sellerProductTable > tbody > tr:nth-child(1) > td:nth-child(8) > div > button', 30)
                ->click('#sellerProductTable > tbody > tr:nth-child(1) > td:nth-child(8) > div > button')
                ->click('#sellerProductTable > tbody > tr:nth-child(1) > td:nth-child(8) > div > div > a.dropdown-item.edit_brand')
                ->assertPathIs('/seller/product/edit/'.$product->id)
                ->assertSee('Product Update')
                ->type('#selling_price', '220')
                ->type('#tax', '15')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(5) > div:nth-child(2) > div > div')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(5) > div:nth-child(2) > div > div > ul > li:nth-child(2)')
                ->type('#discount', '5')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(5) > div:nth-child(4) > div > div')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(5) > div:nth-child(4) > div > div > ul > li:nth-child(2)')
                ->click('#startDate')
                ->pause(1000)
                ->click('div.datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-bottom > div.datepicker-days > table > tbody > tr:nth-child(1) > td:nth-child(6)')
                ->click('#endDate')
                ->pause(1000)
                ->click('div.datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-bottom > div.datepicker-days > table > tbody > tr:nth-child(5) > td:nth-child(3)')
                ->pause(1000)
                ->click('#save_button_parent')
                ->assertPathIs('/seller/product')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Product updated Successfully!');
        });
    }

    public function test_for_with_stock_edit_inhouse_variant_product(){
        $this->test_for_with_stock_variant_product_add();
        $this->browse(function (Browser $browser) {
            $product = SellerProduct::where('user_id', auth()->user()->id)->latest()->first();
            $browser->waitFor('#sellerProductTable > tbody > tr:nth-child(1) > td:nth-child(8) > div > button', 30)
                ->click('#sellerProductTable > tbody > tr:nth-child(1) > td:nth-child(8) > div > button')
                ->click('#sellerProductTable > tbody > tr:nth-child(1) > td:nth-child(8) > div > div > a.dropdown-item.edit_brand')
                ->assertPathIs('/seller/product/edit/'.$product->id)
                ->assertSee('Product Update')
                ->type('#tax', '11')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(4) > div:nth-child(2) > div > div')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(4) > div:nth-child(2) > div > div > ul > li:nth-child(2)')
                ->type('#discount', '7')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(4) > div:nth-child(4) > div > div')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(4) > div:nth-child(4) > div > div > ul > li:nth-child(2)')
                ->click('#startDate')
                ->pause(1000)
                ->click('div.datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-top > div.datepicker-days > table > tbody > tr:nth-child(1) > td:nth-child(6)')
                ->click('#endDate')
                ->pause(1000)
                ->click('div.datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-top > div.datepicker-days > table > tbody > tr:nth-child(5) > td:nth-child(5)')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(5) > div.col-xl-6 > div > div')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(5) > div.col-xl-6 > div > div > ul > li:nth-child(2)')
                ->waitFor('#sku_tbody > tr:nth-child(3) > td:nth-child(2)', 25)
                ->click('#sku_tbody > tr:nth-child(3) > td.text-center.sku_delete_td > p > i')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(5) > div.col-xl-6 > div > div')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(5) > div.col-xl-6 > div > div > ul > li:nth-child(2)')
                ->type('#sku_tbody > tr:nth-child(1) > td:nth-child(3) > input', '221')
                ->type('#sku_tbody > tr:nth-child(1) > td:nth-child(4) > input', '110')
                ->type('#sku_tbody > tr:nth-child(2) > td:nth-child(3) > input', '240')
                ->type('#sku_tbody > tr:nth-child(2) > td:nth-child(4) > input', '50')
                ->type('#sku_tbody > tr:nth-child(3) > td.text-center.sku_price_td > input','250')
                ->type('#sku_tbody > tr:nth-child(3) > td:nth-child(4) > input', '30')
                ->click('#save_button_parent')
                ->assertPathIs('/seller/product')
                ->waitFor('.toast-message',30)
                ->assertSeeIn('.toast-message', 'Product updated Successfully!');
        });        
    }

    public function test_for_without_stock_edit_inhouse_variant_product(){
        $this->test_for_without_stock_variant_product_add();
        $this->browse(function (Browser $browser) {
            $product = SellerProduct::where('user_id', auth()->user()->id)->latest()->first();
            $browser->waitFor('#sellerProductTable > tbody > tr:nth-child(1) > td:nth-child(8) > div > button', 30)
                ->click('#sellerProductTable > tbody > tr:nth-child(1) > td:nth-child(8) > div > button')
                ->click('#sellerProductTable > tbody > tr:nth-child(1) > td:nth-child(8) > div > div > a.dropdown-item.edit_brand')
                ->assertPathIs('/seller/product/edit/'.$product->id)
                ->assertSee('Product Update')
                ->type('#tax', '11')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(4) > div:nth-child(2) > div > div')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(4) > div:nth-child(2) > div > div > ul > li:nth-child(2)')
                ->type('#discount', '7')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(4) > div:nth-child(4) > div > div')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(4) > div:nth-child(4) > div > div > ul > li:nth-child(2)')
                ->click('#startDate')
                ->pause(1000)
                ->click('div.datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-top > div.datepicker-days > table > tbody > tr:nth-child(1) > td:nth-child(6)')
                ->click('#endDate')
                ->pause(1000)
                ->click('div.datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-top > div.datepicker-days > table > tbody > tr:nth-child(5) > td:nth-child(5)')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(5) > div.col-xl-6 > div > div')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(5) > div.col-xl-6 > div > div > ul > li:nth-child(2)')
                ->waitFor('#sku_tbody > tr:nth-child(3) > td:nth-child(2)', 25)
                ->click('#sku_tbody > tr:nth-child(3) > td.text-center.sku_delete_td > p > i')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(5) > div.col-xl-6 > div > div')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(5) > div.col-xl-6 > div > div > ul > li:nth-child(2)')
                ->type('#sku_tbody > tr:nth-child(1) > td:nth-child(3) > input', '221')
                ->type('#sku_tbody > tr:nth-child(2) > td:nth-child(3) > input', '240')
                ->type('#sku_tbody > tr:nth-child(3) > td.text-center.sku_price_td > input','250')
                ->click('#save_button_parent')
                ->assertPathIs('/seller/product')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Product updated Successfully!');
        });        
    }

    public function test_delete_exsisting_product(){
        $this->test_for_without_stock_add_single_exsisting_product();
        $this->browse(function (Browser $browser) {
            $browser->waitFor('#sellerProductTable > tbody > tr:nth-child(1) > td:nth-child(8) > div > button', 30)
                ->click('#sellerProductTable > tbody > tr:nth-child(1) > td:nth-child(8) > div > button')
                ->click('#sellerProductTable > tbody > tr:nth-child(1) > td:nth-child(8) > div > div > a:nth-child(3)')
                ->whenAvailable('#item_delete_form', function($modal){
                    $modal->click('input.primary-btn.fix-gr-bg');

                })
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Product Deleted successfully!');
        });
    }

    public function test_show_exsisting_product(){
        $this->test_for_without_stock_add_single_exsisting_product();
        $this->browse(function (Browser $browser) {
            $browser->waitFor('#sellerProductTable > tbody > tr:nth-child(1) > td:nth-child(8) > div > button', 30)
                ->click('#sellerProductTable > tbody > tr:nth-child(1) > td:nth-child(8) > div > button')
                ->click('#sellerProductTable > tbody > tr:nth-child(1) > td:nth-child(8) > div > div > a:nth-child(1)')
                ->whenAvailable('#productDetails > div', function($modal){
                    $modal->assertSeeAnythingIn('div > div.modal-header > h4');

                });
                
        });
    }

    
}
