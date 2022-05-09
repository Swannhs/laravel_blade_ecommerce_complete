<?php

namespace Tests\Browser\Modules\InhouseOrder;

use App\Models\Order;
use App\Models\OrderPackageDetail;
use App\Models\OrderProductDetail;
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

class InhouseOrderTest extends DuskTestCase
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
        $order_packages = OrderPackageDetail::pluck('id');
        $order_products = OrderProductDetail::pluck('id');
        $orders = Order::pluck('id');

        OrderProductDetail::destroy($order_products);
        OrderProductDetail::destroy($order_packages);
        Order::destroy($orders);

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
                ->visit('/admin/in-house-order')
                ->assertSee('Inhouse order list');
        });
    }

    public function test_for_create_order(){
        $this->test_for_visit_index_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#main-content > section > div > div > div.col-md-12.mb-20 > div > div.col-lg-9 > div > div > ul > li:nth-child(5) > a')
                ->assertPathIs('/admin/in-house-order/create')
                ->assertSee('Create New Order')
                ->type('#shipping_name', $this->faker->name)
                ->type('#shipping_email', $this->faker->email)
                ->type('#shipping_phone', $this->faker->phoneNumber)
                ->type('#shipping_address', 'test address')
                ->click('#addressDiv > div > div:nth-child(6) > div > div')
                ->click('#addressDiv > div > div:nth-child(6) > div > div > ul > li:nth-child(2)')
                ->pause(8000)
                ->click('#stateDiv > div > div')
                ->click('#stateDiv > div > div > ul > li:nth-child(2)')
                ->pause(8000)
                ->click('#cityDiv > div > div')
                ->click('#cityDiv > div > div > ul > li:nth-child(2)')
                ->type('#shipping_postcode', rand(111111, 999999))
                ->click('#save_address_btn')
                ->waitFor('#resetAddress', 25)
                ->click('#add_form > div > div:nth-child(1) > div:nth-child(1) > div > div:nth-child(1) > div > div')
                ->click('#add_form > div > div:nth-child(1) > div:nth-child(1) > div > div:nth-child(1) > div > div > ul > li:nth-child(2)')
                ->pause(8000)
                ->click('#add_form > div > div:nth-child(1) > div:nth-child(1) > div > div:nth-child(1) > div > div')
                ->click('#add_form > div > div:nth-child(1) > div:nth-child(1) > div > div:nth-child(1) > div > div > ul > li:nth-child(2)')
                ->pause(8000)
                ->click('#submit_btn')
                ->assertPathIs('/admin/in-house-order')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Created successfully!');

        });
    }


}
