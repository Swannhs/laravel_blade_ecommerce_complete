<?php

namespace Modules\Product\Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Modules\Product\Entities\Attribute;
use Modules\Product\Entities\AttributeValue;
use Modules\Product\Entities\Brand;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductSku;
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
    public function test_for_create_single_product()
    {
        $user = User::find(1);
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
        ])->assertRedirect('/product');

        File::deleteDirectory(base_path('/uploads'));
    }

    public function test_for_create_variant_product()
    {
        $user = User::find(1);
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
        ])->assertRedirect('/product');

        File::deleteDirectory(base_path('/uploads'));
    }

    public function test_for_get_atrritube_data(){
        $user = User::find(1);
        $this->actingAs($user);

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

        $this->post('/product/get-attribute-values',[
            'ids' => [$attribute->id]
        ])->assertSee('choice_options');

    }


    public function test_for_get_sku_combination(){
        $user = User::find(1);
        $this->actingAs($user);

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

        $this->post('/product/sku-combination',[
            'product_name' => 'test product',
            'choice_no' => [$attribute->id],
            'choice_options_'.$attribute->id => [$attributeValue->id],

        ])->assertSee('table-bordered');

    }

    public function test_for_sku_combination_edit()
    {
        $user = User::find(1);
        $this->actingAs($user);
        Storage::fake('/public');

        

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

        $this->post('/product/sku-combination-edit',[
            'id' => $product->id,
            'product_name' => $product->product_name,
            'choice_no' => [$attribute->id],
            'choice_options_'.$attribute->id => [$attributeValue->id],
        ])->assertSee('table-bordered');
    }

    public function test_for_update_single_product()
    {
        $user = User::find(1);
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
        ])->assertRedirect('/product');

        File::deleteDirectory(base_path('/uploads'));
    }

    public function test_for_update_variant_product()
    {
        $user = User::find(1);
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
        ])->assertRedirect('/product');

        File::deleteDirectory(base_path('/uploads'));
    }

    public function test_for_show_product()
    {
        $user = User::find(1);
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

        $productSKU = ProductSku::create([
            'product_id' => $product->id,
            'sku' =>  'sku-7485784',
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
        ]);

        $this->post('/product/show',[
            'id' => $product->id
        ])->assertSee('productDetails');
    }

    public function test_for_delete_product()
    {
        $user = User::find(1);
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

        $productSKU = ProductSku::create([
            'product_id' => $product->id,
            'sku' =>  'sku-7485784',
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
        ]);

        $this->post('/product/destroy',[
            'id' => $product->id
        ])->assertSee('ProductList');
    }

    public function test_for_status_change_product()
    {
        $user = User::find(1);
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

        $productSKU = ProductSku::create([
            'product_id' => $product->id,
            'sku' =>  'sku-7485784',
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
        ]);

        $this->post('/product/update-status',[
            'id' => $product->id,
            'status' => 1
        ])->assertSee('ProductList');
    }

    public function test_for_status_change_sku()
    {
        $user = User::find(1);
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

        $productSKU = ProductSku::create([
            'product_id' => $product->id,
            'sku' =>  'sku-7485784',
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
        ]);

        $this->post('/product/sku-status',[
            'id' => $productSKU->id,
            'status' => 1
        ])->assertStatus(200);
    }

    public function test_for_delete_sku()
    {
        $user = User::find(1);
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

        $productSKU = ProductSku::create([
            'product_id' => $product->id,
            'sku' =>  'sku-7485784',
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
        ]);

        $this->post('/product/sku-delete',[
            'id' => $productSKU->id
        ])->assertSee('ProductSKUList');
    }

    public function test_for_update_sku()
    {
        $user = User::find(1);
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

        $productSKU = ProductSku::create([
            'product_id' => $product->id,
            'sku' =>  'sku-7485784',
            'purchase_price' => 100,
            'selling_price' => 100,
            'additional_shipping' => 0,
            'status' => 1,
        ]);

        $this->post('/product/sku-edit',[
            'id' => $productSKU->id,
            'purchase_price' => 120,
            'selling_price' => 220,
        ])->assertSee('ProductSKUList');
    }


    public function test_for_request_product_approve()
    {
        $user = User::find(1);
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
            'is_approved' => 0,
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

        $this->post('/product/request-product/approved',[
            'id' => $product->id,
            'is_approved' => 1,
        ])->assertSee('RequestProductList');
    }
    

}
