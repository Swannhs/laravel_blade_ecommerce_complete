<?php

namespace Modules\Marketing\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Product\Entities\Product;
use Modules\Seller\Entities\SellerProduct;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Modules\Marketing\Entities\FlashDeal;
use Modules\Marketing\Entities\NewUserZone;
use Modules\Product\Entities\Category;
use Str;

class NewUserZoneTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_create_new_user_zone()
    {
        $this->actingAs(User::find(1));
        Storage::fake('/public');

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

        $category = Category::create([
            'name' => 'test name',
            'slug' => 'test-name',
            'parent_id' => 0,
            'searchable' => 1,
            'status' => 1
        ]);

        $this->post('/marketing/new-user-zone/store',[
            'title' => 'test title',
            'text_color' => '#000',
            'background_color' => '#fff',
            'product_navigation_label' => 'test label',
            'category_navigation_label' => 'test label',
            'coupon_navigation_label' => 'test label',
            'product_slogan' => 'test slogan',
            'category_slogan' => 'test slogan',
            'coupon_slogan' => 'test slogan',
            'banner_image' => UploadedFile::fake()->image('image.jpg', 1, 1),
            'product' => [$seller_product->id],
            'category' => [$category->id],
            'coupon_category' => [$category->id],
            'coupon' => 1,

        ])->assertRedirect('/marketing/new-user-zone');

        File::deleteDirectory(base_path('/uploads'));
    }


    public function test_for_get_product()
    {
        $this->actingAs(User::find(1));

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

        $this->post('/marketing/new-user-zone/product-list',[
            'product_id' => $seller_product->id

        ])->assertSee('productImg');

        
    }


    public function test_for_get_category()
    {
        $this->actingAs(User::find(1));

        $category = Category::create([
            'name' => 'test name',
            'slug' => 'test-name',
            'parent_id' => 0,
            'searchable' => 1,
            'status' => 1
        ]);

        $this->post('/marketing/new-user-zone/category-list',[
            'category_id' => $category->id

        ])->assertSee('category_delete_btn');
        
    }

    public function test_for_get_coupon_category()
    {
        $this->actingAs(User::find(1));

        $category = Category::create([
            'name' => 'test name',
            'slug' => 'test-name',
            'parent_id' => 0,
            'searchable' => 1,
            'status' => 1
        ]);

        $this->post('/marketing/new-user-zone/coupon-category-list',[
            'category_id' => $category->id

        ])->assertSee('category_delete_btn');
        
    }

    public function test_for_update_new_user_zone()
    {
        $this->actingAs(User::find(1));
        Storage::fake('/public');

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

        $category = Category::create([
            'name' => 'test name',
            'slug' => 'test-name',
            'parent_id' => 0,
            'searchable' => 1,
            'status' => 1
        ]);

        $new_user_zone = NewUserZone::create([
            'title' => 'test title',
            'background_color' => '#fff',
            'text_color' => '#000',
            'slug' => 'test-title'.'-'.Str::random(5),
            'product_navigation_label' => 'test label',
            'category_navigation_label' => 'test label',
            'coupon_navigation_label' => 'test label',
            'product_slogan' => 'test slogan',
            'category_slogan' => 'test slogan',
            'coupon_slogan' => 'test slogan',
            'banner_image' => 'test.jpg'
        ]);

        $this->post('/marketing/new-user-zone/update/'.encrypt($new_user_zone->id),[
            'title' => 'test title',
            'text_color' => '#000',
            'background_color' => '#fff',
            'product_navigation_label' => 'test label',
            'category_navigation_label' => 'test label',
            'coupon_navigation_label' => 'test label',
            'product_slogan' => 'test slogan',
            'category_slogan' => 'test slogan',
            'coupon_slogan' => 'test slogan',
            'banner_image' => UploadedFile::fake()->image('image.jpg', 1, 1),
            'product' => [$seller_product->id],
            'category' => [$category->id],
            'coupon_category' => [$category->id],
            'coupon' => 1,

        ])->assertRedirect('/marketing/new-user-zone');

        File::deleteDirectory(base_path('/uploads'));
    }

    public function test_for_delete_new_user_zone()
    {
        $this->actingAs(User::find(1));


        $new_user_zone = NewUserZone::create([
            'title' => 'test title',
            'background_color' => '#fff',
            'text_color' => '#000',
            'slug' => 'test-title'.'-'.Str::random(5),
            'product_navigation_label' => 'test label',
            'category_navigation_label' => 'test label',
            'coupon_navigation_label' => 'test label',
            'product_slogan' => 'test slogan',
            'category_slogan' => 'test slogan',
            'coupon_slogan' => 'test slogan',
            'banner_image' => 'test.jpg'
        ]);

        $this->post('/marketing/new-user-zone/delete',[
            'id' => $new_user_zone->id,

        ])->assertSee('SL');

    }

    public function test_for_status_change_new_user_zone()
    {
        $this->actingAs(User::find(1));

        $new_user_zone = NewUserZone::create([
            'title' => 'test title',
            'background_color' => '#fff',
            'text_color' => '#000',
            'slug' => 'test-title'.'-'.Str::random(5),
            'product_navigation_label' => 'test label',
            'category_navigation_label' => 'test label',
            'coupon_navigation_label' => 'test label',
            'product_slogan' => 'test slogan',
            'category_slogan' => 'test slogan',
            'coupon_slogan' => 'test slogan',
            'banner_image' => 'test.jpg'
        ]);

        $this->post('/marketing/new-user-zone/status',[
            'status' => 1,
            'id' => $new_user_zone->id
            

        ])->assertSee('SL');

        
    }

    public function test_for_featured_change_new_user_zone()
    {
        $this->actingAs(User::find(1));

        $new_user_zone = NewUserZone::create([
            'title' => 'test title',
            'background_color' => '#fff',
            'text_color' => '#000',
            'slug' => 'test-title'.'-'.Str::random(5),
            'product_navigation_label' => 'test label',
            'category_navigation_label' => 'test label',
            'coupon_navigation_label' => 'test label',
            'product_slogan' => 'test slogan',
            'category_slogan' => 'test slogan',
            'coupon_slogan' => 'test slogan',
            'banner_image' => 'test.jpg'
        ]);

        $this->post('/marketing/new-user-zone/featured',[
            'is_featured' => 1,
            'id' => $new_user_zone->id
            

        ])->assertSee(1);
        
    }
    

}
