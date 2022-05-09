<?php

namespace Tests\Browser\Modules\OrderManage;

use App\Models\Order;
use App\Models\OrderPackageDetail;
use App\Models\OrderProductDetail;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Modules\Customer\Entities\CustomerAddress;
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

class OrderManageTest extends DuskTestCase
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
    protected $customerAddress;
    protected $order;
    protected $orderPackage;

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

        $this->customerAddress = CustomerAddress::create([
            'customer_id' => 4,
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumberm,
            'address' => 'test address',
            'country' => 18,
            'state' => 348,
            'city' => 7293,
            'postcode' => rand(11111111,99999999),
            'is_shipping_default' => 1,
            'is_billing_default' => 1

        ]);

        $this->order = Order::create([
            'customer_id' => 4,
            'order_number' => 'order-'.rand(1111111,99999999),
            'payment_type' => 1,
            'is_paid' => 0,
            'is_confirmed' => 0,
            'is_completed' => 0,
            'customer_email' => 'test@test.com',
            'customer_phone' => '016278732173',
            'customer_shipping_address' => $this->customerAddress->id,
            'customer_billing_address' => $this->customerAddress->id,
            'number_of_package' => 1,
            'grand_total' => 240,
            'sub_total' => 200,
            'discount_total' => 10,
            'shipping_total' => 5,
            'number_of_item' => 2,
            'order_status' => 1,
            'tax_amount' => 30

        ]);

        $this->orderPackage = OrderPackageDetail::create([
            'order_id' => $this->order->id,
            'seller_id' => 5,
            'package_code' => rand(111111,99999999),
            'number_of_product' => 2,
            'shipping_cost' => 5,
            'shipping_date' => '12-07-2021',
            'shipping_method' => $this->product_shippings[0],
            'tax_amount' => 30
        ]);

        OrderProductDetail::create([
            'package_id' => $this->orderPackage->id,
            'type' => 'product',
            'product_sku_id' => $this->sellerProductSKUS[0],
            'qty' => 2,
            'price' => 100,
            'total_price' => 200,
            'tax_amount' => 30
        ]);


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
    public function test_for_visit__total_index_page(){
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/ordermanage/total-sales-list')
                ->assertSee('Pending Orders');
        });
    }

    public function test_for_shw_order_total_order(){
        $this->test_for_visit__total_index_page();
        $this->browse(function (Browser $browser) {
            $order = Order::latest()->first();
            $browser->pause(10000)
                ->click('#orderPendingTable > tbody > tr:nth-child(1) > td:nth-child(9) > div >button')
                ->click('#orderPendingTable > tbody > tr:nth-child(1) > td:nth-child(9) > div > div > a')
                ->assertPathIs('/ordermanage/sales-details/'.$order->id)
                ->assertSee('Billing Info')
                ->click('#add_product > section > div > div > div.col-4.student-details > form > div > div:nth-child(1) > div > div')
                ->click('#add_product > section > div > div > div.col-4.student-details > form > div > div:nth-child(1) > div > div > ul > li:nth-child(2)')
                ->click('#add_product > section > div > div > div.col-4.student-details > form > div > div:nth-child(2) > div > div')
                ->click('#add_product > section > div > div > div.col-4.student-details > form > div > div:nth-child(2) > div > div > ul > li:nth-child(2)')
                ->click('#add_product > section > div > div > div.col-4.student-details > form > div > div:nth-child(4) > button')
                ->assertPathIs('/ordermanage/sales-details/'.$order->id)
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');
        });
    }
}
