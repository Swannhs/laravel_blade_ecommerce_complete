<?php

namespace Modules\Seller\Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductSku;
use Modules\Seller\Entities\SellerProduct;
use Modules\Seller\Entities\SellerProductSKU;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Modules\Product\Entities\Attribute;
use Modules\Product\Entities\AttributeValue;
use Modules\Product\Entities\Brand;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\UnitType;
use Modules\Shipping\Entities\ShippingMethod;

class ProductTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_add_excisting_single_product()
    {
        $user = User::find(4);
        $this->actingAs($user);

        $product = Product::create([
            'product_name' => 'test name',
            'product_type' => 1,
            'shipping_type' => 0,
            'shipping_cost' => 0,
            'discount' => 0,
            'tax' => 0,
            'is_physical' => 1,
            'is_approved' => 1,
            'thumbnail_image' => 'test.jpg'
        ]);

        $productSKU = ProductSku::create([
            'product_id' => $product->id,
            'sku' =>  'sku-7485784',
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
        ]);

        $this->post('/seller/product',[
            "product_id" => $product->id,
            "stock_manage" => "1",
            "product_stock" => 5,
            "purchase_price" => 6000,
            "selling_price" => 6250,
            "product_name" => "ktm rc 390 by amazcart",
            "tax" => 5,
            "tax_type" => 0,
            "discount" => 50,
            "discount_type" => 1,
            "discount_start_date" => "05/01/2021",
            "discount_end_date" => "05/31/2021"
        ])->assertRedirect('/seller/product');

    }

    public function test_for_add_excisting_variant_product()
    {
        $user = User::find(4);
        $this->actingAs($user);
        Storage::fake('/public');

        $product = Product::create([
            'product_name' => 'test name',
            'product_type' => 2,
            'shipping_type' => 0,
            'shipping_cost' => 0,
            'discount' => 0,
            'tax' => 0,
            'is_physical' => 1,
            'is_approved' => 1,
            'thumbnail_image' => 'test.jpg'
        ]);

        $productSKU_1 = ProductSku::create([
            'product_id' => $product->id,
            'sku' =>  'sku-7485784',
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
        ]);

        $productSKU_2 = ProductSku::create([
            'product_id' => $product->id,
            'sku' =>  'sku-7485784',
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
        ]);


        $this->post('/seller/product',[
            "product_id" => $product->id,
            "stock_manage" => "1",
            "purchase_price_sku" => [110, 110],
            "selling_price_sku" => [130,130],
            "product_name" => "ktm rc 390 by amazcart",
            "tax" => 5,
            "tax_type" => 0,
            "discount" => 50,
            "discount_type" => 1,
            "discount_start_date" => "05/01/2021",
            "discount_end_date" => "05/31/2021",
            'stock' => [5,25],
            'product_skus' => [$productSKU_1->id,$productSKU_2->id],
            'thumbnail_image' => UploadedFile::fake()->image('image.jpg', 1, 1)

        ])->assertRedirect('seller/product');
        File::deleteDirectory(base_path('/uploads'));

    }
    public function test_for_update_excisting_single_product()
    {
        $user = User::find(4);
        $this->actingAs($user);

        $product = Product::create([
            'product_name' => 'test name',
            'product_type' => 1,
            'shipping_type' => 0,
            'shipping_cost' => 0,
            'discount' => 0,
            'tax' => 0,
            'is_physical' => 1,
            'is_approved' => 1,
            'thumbnail_image' => 'test.jpg'
        ]);

        $productSKU = ProductSku::create([
            'product_id' => $product->id,
            'sku' =>  'sku-7485784',
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
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
                    
        $seller_product_sku = SellerProductSKU::create([
            'user_id' => $user->id,
            'product_id' => $seller_product->id,
            'product_sku_id' => $productSKU->id,
            'product_stock' => 10,
            'purchase_price' => 100,
            'selling_price' => 100,
            'status' => 1
        ]);

        $this->post('/seller/product/update/'.$seller_product->id,[
            "stock_manage" => "1",
            "product_stock" => 5,
            "purchase_price" => 6000,
            "selling_price" => 6250,
            "tax" => 5,
            "tax_type" => 0,
            "discount" => 50,
            "discount_type" => 1,
            "discount_start_date" => "05/01/2021",
            "discount_end_date" => "05/31/2021"
        ])->assertRedirect('/seller/product');

    }

    public function test_for_update_excisting_variant_product()
    {
        $user = User::find(4);
        $this->actingAs($user);
        Storage::fake('/public');

        $product = Product::create([
            'product_name' => 'test name',
            'product_type' => 2,
            'shipping_type' => 0,
            'shipping_cost' => 0,
            'discount' => 0,
            'tax' => 0,
            'is_physical' => 1,
            'is_approved' => 1,
            'thumbnail_image' => 'test.jpg'
        ]);

        $productSKU_1 = ProductSku::create([
            'product_id' => $product->id,
            'sku' =>  'sku-7485784',
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
        ]);

        $productSKU_2 = ProductSku::create([
            'product_id' => $product->id,
            'sku' =>  'sku-7485784',
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
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
                    
        $seller_product_sku_1 = SellerProductSKU::create([
            'user_id' => $user->id,
            'product_id' => $seller_product->id,
            'product_sku_id' => $productSKU_1->id,
            'product_stock' => 10,
            'purchase_price' => 100,
            'selling_price' => 100,
            'status' => 1
        ]);
        $seller_product_sku_2 = SellerProductSKU::create([
            'user_id' => $user->id,
            'product_id' => $seller_product->id,
            'product_sku_id' => $productSKU_2->id,
            'product_stock' => 10,
            'purchase_price' => 100,
            'selling_price' => 100,
            'status' => 1
        ]);


        $this->post('/seller/product/update/'.$seller_product->id,[
            "product_id" => $product->id,
            "stock_manage" => "1",
            "purchase_price_sku" => [110, 110],
            "selling_price_sku" => [130,130],
            "product_name" => "ktm rc 390 by amazcart",
            "tax" => 5,
            "tax_type" => 0,
            "discount" => 50,
            "discount_type" => 1,
            "discount_start_date" => "05/01/2021",
            "discount_end_date" => "05/31/2021",
            'status_'.$productSKU_1->id => $productSKU_1->id,
            'status_'.$productSKU_2->id => $productSKU_2->id,
            'stock' => [5,25],
            'product_skus' => [$productSKU_1->id,$productSKU_2->id],
            'thumbnail_image' => UploadedFile::fake()->image('image.jpg', 1, 1)

        ])->assertRedirect('seller/product');

        File::deleteDirectory(base_path('/uploads'));

    }

    public function test_for_delete_variant_from_product()
    {
        $user = User::find(4);
        $this->actingAs($user);

        $product = Product::create([
            'product_name' => 'test name',
            'product_type' => 2,
            'shipping_type' => 0,
            'shipping_cost' => 0,
            'discount' => 0,
            'tax' => 0,
            'is_physical' => 1,
            'is_approved' => 1,
            'thumbnail_image' => 'test.jpg'
        ]);

        $productSKU_1 = ProductSku::create([
            'product_id' => $product->id,
            'sku' =>  'sku-7485784',
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
        ]);

        $productSKU_2 = ProductSku::create([
            'product_id' => $product->id,
            'sku' =>  'sku-7485784',
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
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
                    
        $seller_product_sku_1 = SellerProductSKU::create([
            'user_id' => $user->id,
            'product_id' => $seller_product->id,
            'product_sku_id' => $productSKU_1->id,
            'product_stock' => 10,
            'purchase_price' => 100,
            'selling_price' => 100,
            'status' => 1
        ]);
        $seller_product_sku_2 = SellerProductSKU::create([
            'user_id' => $user->id,
            'product_id' => $seller_product->id,
            'product_sku_id' => $productSKU_2->id,
            'product_stock' => 10,
            'purchase_price' => 100,
            'selling_price' => 100,
            'status' => 1
        ]);


        $this->post('/seller/product/variant/delete',[
            "id" => $seller_product_sku_2->id

        ])->assertStatus(200);


    }

    public function test_for_status_change_product()
    {
        $user = User::find(4);
        $this->actingAs($user);

        $product = Product::create([
            'product_name' => 'test name',
            'product_type' => 2,
            'shipping_type' => 0,
            'shipping_cost' => 0,
            'discount' => 0,
            'tax' => 0,
            'is_physical' => 1,
            'is_approved' => 1,
            'thumbnail_image' => 'test.jpg'
        ]);

        $productSKU_1 = ProductSku::create([
            'product_id' => $product->id,
            'sku' =>  'sku-7485784',
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
        ]);

        $productSKU_2 = ProductSku::create([
            'product_id' => $product->id,
            'sku' =>  'sku-7485784',
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
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
                    
        $seller_product_sku_1 = SellerProductSKU::create([
            'user_id' => $user->id,
            'product_id' => $seller_product->id,
            'product_sku_id' => $productSKU_1->id,
            'product_stock' => 10,
            'purchase_price' => 100,
            'selling_price' => 100,
            'status' => 1
        ]);
        $seller_product_sku_2 = SellerProductSKU::create([
            'user_id' => $user->id,
            'product_id' => $seller_product->id,
            'product_sku_id' => $productSKU_2->id,
            'product_stock' => 10,
            'purchase_price' => 100,
            'selling_price' => 100,
            'status' => 1
        ]);


        $this->post('/seller/product/update-status',[
            "id" => $seller_product->id,
            'status' => 0

        ])->assertStatus(200);


    }

    public function test_for_delete_product()
    {
        $user = User::find(4);
        $this->actingAs($user);

        $product = Product::create([
            'product_name' => 'test name',
            'product_type' => 2,
            'shipping_type' => 0,
            'shipping_cost' => 0,
            'discount' => 0,
            'tax' => 0,
            'is_physical' => 1,
            'is_approved' => 1,
            'thumbnail_image' => 'test.jpg'
        ]);

        $productSKU_1 = ProductSku::create([
            'product_id' => $product->id,
            'sku' =>  'sku-7485784',
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
        ]);

        $productSKU_2 = ProductSku::create([
            'product_id' => $product->id,
            'sku' =>  'sku-7485784',
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
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
                    
        $seller_product_sku_1 = SellerProductSKU::create([
            'user_id' => $user->id,
            'product_id' => $seller_product->id,
            'product_sku_id' => $productSKU_1->id,
            'product_stock' => 10,
            'purchase_price' => 100,
            'selling_price' => 100,
            'status' => 1
        ]);
        $seller_product_sku_2 = SellerProductSKU::create([
            'user_id' => $user->id,
            'product_id' => $seller_product->id,
            'product_sku_id' => $productSKU_2->id,
            'product_stock' => 10,
            'purchase_price' => 100,
            'selling_price' => 100,
            'status' => 1
        ]);


        $this->post('/seller/product/delete',[
            "id" => $seller_product->id,

        ])->assertStatus(200);

    }

    public function test_for_get_sku()
    {
        $user = User::find(4);
        $this->actingAs($user);

        $product = Product::create([
            'product_name' => 'test name',
            'product_type' => 2,
            'shipping_type' => 0,
            'shipping_cost' => 0,
            'discount' => 0,
            'tax' => 0,
            'is_physical' => 1,
            'is_approved' => 1,
            'thumbnail_image' => 'test.jpg'
        ]);

        $productSKU_1 = ProductSku::create([
            'product_id' => $product->id,
            'sku' =>  'sku-7485784',
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
        ]);

        $productSKU_2 = ProductSku::create([
            'product_id' => $product->id,
            'sku' =>  'sku-7485784',
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
        ]);


        $this->post('/seller/product/variant',[
            "ids" => [$productSKU_1->id, $productSKU_2->id],
            "stock_manage" => "1"
        ])->assertSee('variants');

    }

    public function test_for_get_sku_edit()
    {
        $user = User::find(4);
        $this->actingAs($user);

        $product = Product::create([
            'product_name' => 'test name',
            'product_type' => 2,
            'shipping_type' => 0,
            'shipping_cost' => 0,
            'discount' => 0,
            'tax' => 0,
            'is_physical' => 1,
            'is_approved' => 1,
            'thumbnail_image' => 'test.jpg'
        ]);

        $productSKU_1 = ProductSku::create([
            'product_id' => $product->id,
            'sku' =>  'sku-7485784',
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
        ]);

        $productSKU_2 = ProductSku::create([
            'product_id' => $product->id,
            'sku' =>  'sku-7485784',
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
        ]);


        $this->post('/seller/product/variant/edit',[
            "id" => $productSKU_1->id,
            "stock_manage" => "1"
        ])->assertSee('variants');

    }


    // new product test

    public function test_for_create_single_my_product()
    {
        $user = User::find(4);
        $this->actingAs($user);
        Storage::fake('/public');

        $brand = Brand::create([
            'name' => 'test name 99',
            'status' => 0,
            'logo' => 'test.jpg'
        ]);

        $category = Category::create([
            'name' => 'test name',
            'slug' => 'test-name',
            'parent_id' => 0,
            'searchable' => 1,
            'status' => 1
        ]);

        $unit = UnitType::create([
            'name' => 'test 99',
            'status' => 0
        ]);
        
        $shipping_method = ShippingMethod::create([
            'method_name' => 'test 99',
            'phone' => '9182983424',
            'shipping_time' => '8-12 days',
            'cost' => 5,
            'is_active' => 1
        ]);

        $this->post('/product/store',[
            'product_type' => 1,
            'product_name' => 'test product 99',
            'sku' => 'sku-7485784',
            'model_number' => 'euirwe7457845',
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'unit_type_id' => $unit->id,
            'barcode_type' => 'c39',
            'minimum_order_qty' => '1',
            'max_order_qty' => '5',
            "tags" => "tag,tag 2",
            "description" => "<p>test</p>",
            "purchase_price" => "0",
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
            'shipping_methods' => [$shipping_method->id],
            "video_provider" => "youtube",
            "video_link" => null,
            "status" => "1",
            "display_in_details" => "1",
            'thumbnail_image' => UploadedFile::fake()->image('image.jpg', 56, 56)
        ])->assertRedirect('/seller/product');

        File::deleteDirectory(base_path('/uploads'));
    }

    public function test_for_visit_edit_my_product()
    {
        $user = User::find(4);
        $this->actingAs($user);
        Storage::fake('/public');

        $brand = Brand::create([
            'name' => 'test name 99',
            'status' => 0,
            'logo' => 'test.jpg'
        ]);

        $category = Category::create([
            'name' => 'test name',
            'slug' => 'test-name',
            'parent_id' => 0,
            'searchable' => 1,
            'status' => 1
        ]);

        $unit = UnitType::create([
            'name' => 'test 99',
            'status' => 0
        ]);
        
        $shipping_method = ShippingMethod::create([
            'method_name' => 'test 99',
            'phone' => '9182983424',
            'shipping_time' => '8-12 days',
            'cost' => 5,
            'is_active' => 1
        ]);

        $product = Product::create([
            'product_name' => 'test name',
            'product_type' => 1,
            'shipping_type' => 0,
            'shipping_cost' => 0,
            'discount' => 0,
            'tax' => 0,
            'is_physical' => 1,
            'is_approved' => 1,
            'thumbnail_image' => 'test.jpg'
        ]);

        $productSKU = ProductSku::create([
            'product_id' => $product->id,
            'sku' =>  'sku-7485784',
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
        ]);


        $this->get('/seller/product/'.$product->id.'/edit')->assertStatus(200);

    }

    public function test_for_update_single_my_product()
    {
        $user = User::find(4);
        $this->actingAs($user);
        Storage::fake('/public');

        $brand = Brand::create([
            'name' => 'test name 99',
            'status' => 0,
            'logo' => 'test.jpg'
        ]);

        $category = Category::create([
            'name' => 'test name',
            'slug' => 'test-name',
            'parent_id' => 0,
            'searchable' => 1,
            'status' => 1
        ]);

        $unit = UnitType::create([
            'name' => 'test 99',
            'status' => 0
        ]);
        
        $shipping_method = ShippingMethod::create([
            'method_name' => 'test 99',
            'phone' => '9182983424',
            'shipping_time' => '8-12 days',
            'cost' => 5,
            'is_active' => 1
        ]);

        $product = Product::create([
            'product_name' => 'test name',
            'product_type' => 1,
            'shipping_type' => 0,
            'shipping_cost' => 0,
            'discount' => 0,
            'tax' => 0,
            'is_physical' => 1,
            'is_approved' => 1,
            'thumbnail_image' => 'test.jpg'
        ]);

        $productSKU = ProductSku::create([
            'product_id' => $product->id,
            'sku' =>  'sku-7485784',
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
        ]);

        $this->post('/product/update/'.$product->id,[
            'id' => $product->id,
            'product_type' => 1,
            'product_name' => 'test product 99',
            'sku' => 'sku-7485784',
            'model_number' => 'euirwe7457845',
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'unit_type_id' => $unit->id,
            'barcode_type' => 'c39',
            'minimum_order_qty' => '1',
            'max_order_qty' => '5',
            "tags" => "tag,tag 2",
            "description" => "<p>test</p>",
            "purchase_price" => "0",
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
            'shipping_methods' => [$shipping_method->id],
            "video_provider" => "youtube",
            "video_link" => null,
            "status" => "1",
            "display_in_details" => "1",
            'thumbnail_image' => UploadedFile::fake()->image('image.jpg', 56, 56)
        ])->assertRedirect('/seller/product');

        File::deleteDirectory(base_path('/uploads'));
    }

    public function test_for_create_variant_my_product()
    {
        $user = User::find(4);
        $this->actingAs($user);
        Storage::fake('/public');

        $brand = Brand::create([
            'name' => 'test name 99',
            'status' => 0,
            'logo' => 'test.jpg'
        ]);

        $category = Category::create([
            'name' => 'test name',
            'slug' => 'test-name',
            'parent_id' => 0,
            'searchable' => 1,
            'status' => 1
        ]);

        $unit = UnitType::create([
            'name' => 'test 99',
            'status' => 0
        ]);

        $attribute = Attribute::create([
            'name' => 'test 99',
            'description' => 'test description',
            'display_type' => 'radio_button',
            'status' => 0
        ]);
        $attributeValue = AttributeValue::create([
            "value" => 'a',
            "attribute_id" => $attribute->id,
            "created_at" => Carbon::now()
        ]);

        
        $shipping_method = ShippingMethod::create([
            'method_name' => 'test 99',
            'phone' => '9182983424',
            'shipping_time' => '8-12 days',
            'cost' => 5,
            'is_active' => 1
        ]);

        $this->post('/product/store',[
            'product_type' => 2,
            'product_name' => 'test product 99',
            'model_number' => 'euirwe7457845',
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'unit_type_id' => $unit->id,
            'barcode_type' => 'c39',
            'minimum_order_qty' => '1',
            'max_order_qty' => '5',
            "tags" => "tag,tag 2",
            "description" => "<p>test</p>",
            "tax" => "0",
            "tax_type" => "1",
            "discount" => "0",
            "discount_type" => "1",
            "specification" => "<p>test</p>",
            "is_physical" => "1",
            
            'str_attribute_id' => [$attribute->id],
            'str_id' => [$attributeValue->id],
            'purchase_price_sku' => [100],
            'selling_price_sku' => [200],
            'sku' => ['shkhjshj'],
            'sku_additional_shipping' => [0],

            "meta_title" => null,
            "meta_description" => null,
            'shipping_methods' => [$shipping_method->id],
            "video_provider" => "youtube",
            "video_link" => null,
            "status" => "1",
            "display_in_details" => "1",
            'thumbnail_image' => UploadedFile::fake()->image('image.jpg', 56, 56)
        ])->assertRedirect('/seller/product');

        File::deleteDirectory(base_path('/uploads'));
    }
    
    public function test_for_update_variant_my_product()
    {
        $user = User::find(4);
        $this->actingAs($user);
        Storage::fake('/public');

        $brand = Brand::create([
            'name' => 'test name 99',
            'status' => 0,
            'logo' => 'test.jpg'
        ]);

        $category = Category::create([
            'name' => 'test name',
            'slug' => 'test-name',
            'parent_id' => 0,
            'searchable' => 1,
            'status' => 1
        ]);

        $unit = UnitType::create([
            'name' => 'test 99',
            'status' => 0
        ]);

        $attribute = Attribute::create([
            'name' => 'test 99',
            'description' => 'test description',
            'display_type' => 'radio_button',
            'status' => 0
        ]);
        $attributeValue = AttributeValue::create([
            "value" => 'a',
            "attribute_id" => $attribute->id,
            "created_at" => Carbon::now()
        ]);

        
        $shipping_method = ShippingMethod::create([
            'method_name' => 'test 99',
            'phone' => '9182983424',
            'shipping_time' => '8-12 days',
            'cost' => 5,
            'is_active' => 1
        ]);

        $product = Product::create([
            'product_name' => 'test name',
            'product_type' => 2,
            'shipping_type' => 0,
            'shipping_cost' => 0,
            'discount' => 0,
            'tax' => 0,
            'is_physical' => 1,
            'is_approved' => 1,
            'thumbnail_image' => 'test.jpg'
        ]);

        $productSKU = ProductSku::create([
            'product_id' => $product->id,
            'sku' =>  'sku-7485784',
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
        ]);

        $this->post('/product/update/'.$product->id,[
            'id' => $product->id,
            'product_type' => 2,
            'product_name' => 'test product 99',
            'model_number' => 'euirwe7457845',
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'unit_type_id' => $unit->id,
            'barcode_type' => 'c39',
            'minimum_order_qty' => '1',
            'max_order_qty' => '5',
            "tags" => "tag,tag 2",
            "description" => "<p>test</p>",
            "tax" => "0",
            "tax_type" => "1",
            "discount" => "0",
            "discount_type" => "1",
            "specification" => "<p>test</p>",
            "is_physical" => "1",
            
            'str_attribute_id' => [$attribute->id],
            'str_id' => [$attributeValue->id],
            'purchase_price_sku' => [100],
            'selling_price_sku' => [200],
            'sku' => ['shkhjshj'],
            'sku_additional_shipping' => [0],

            "meta_title" => null,
            "meta_description" => null,
            'shipping_methods' => [$shipping_method->id],
            "video_provider" => "youtube",
            "video_link" => null,
            "status" => "1",
            "display_in_details" => "1",
            'thumbnail_image' => UploadedFile::fake()->image('image.jpg', 56, 56)
        ])->assertRedirect('/seller/product');

        File::deleteDirectory(base_path('/uploads'));
    }
}
