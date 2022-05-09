<?php

namespace Modules\Appearance\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Modules\Appearance\Entities\HeaderCategoryPanel;
use Modules\Appearance\Entities\HeaderProductPanel;
use Modules\Appearance\Entities\HeaderSliderPanel;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Seller\Entities\SellerProduct;

class HeaderPageTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_update_slider_genaral_setting()
    {
        $this->actingAs(User::find(1));

        $this->post('/appearance/headers/update',[
            'column_size' => '8 column',
            'id' => 1,
            'is_enable' => 1
        ])->assertSee('1');
    }

    public function test_for_add_slider()
    {
        $this->actingAs(User::find(1));
        Storage::fake('/public');

        $this->post('/appearance/headers/setup/add-element',[
            'name' => 'test slider',
            'id' => 1,
            'url' => '#',
            'status' => 0,
            'is_newtab' => 1,
            'slider_image' => UploadedFile::fake()->image('image.jpg', 1, 1)
        ])->assertSee('Slider List');
        File::deleteDirectory(base_path('/uploads'));
    }

    public function test_for_update_slider()
    {
        $this->actingAs(User::find(1));
        Storage::fake('/public');

        $slider = HeaderSliderPanel::create([
                    'name' => 'test slider',
                    'url' => '#',
                    'slider_image' => 'test.jpg',
                    'status' => 0,
                    'is_newtab' => 1
                ]);

        $this->post('/appearance/headers/setup/update-element',[
            'header_id' => 1,
            'name' => 'test slider',
            'id' => $slider->id,
            'url' => '#',
            'status' => 0,
            'is_newtab' => 1,
            'slider_image' => UploadedFile::fake()->image('image.jpg', 1, 1)
        ])->assertSee('Slider List');
        File::deleteDirectory(base_path('/uploads'));
    }

    public function test_for_delete_slider()
    {
        $this->actingAs(User::find(1));

        $slider = HeaderSliderPanel::create([
                    'name' => 'test slider',
                    'url' => '#',
                    'slider_image' => 'test.jpg',
                    'status' => 0,
                    'is_newtab' => 1
                ]);

        $this->post('/appearance/headers/setup/delete-element',[
            'header_id' => 1,
            'id' => $slider->id,
        ])->assertSee('Slider List');
    }


    public function test_for_add_category()
    {
        $this->actingAs(User::find(1));

        $category = Category::create([
            'name' => 'test name',
            'slug' => 'test-name',
            'parent_id' => 0,
            'searchable' => 1,
            'status' => 1
        ]);

        $this->post('/appearance/headers/setup/add-element',[
            'id' => 2,
            'category' => [$category->id]
        ])->assertSee('Category List');
    }

    public function test_for_update_category()
    {
        $this->actingAs(User::find(1));

        $category = Category::create([
            'name' => 'test name',
            'slug' => 'test-name',
            'parent_id' => 0,
            'searchable' => 1,
            'status' => 1
        ]);

        $element = HeaderCategoryPanel::create([
                    'title' => $category->name,
                    'category_id' => $category->id,
                    'status' => 1,
                    'is_newtab' => 0
                ]);

        $this->post('/appearance/headers/setup/update-element',[
            'header_id' => 2,
            'id' => $element->id,
            'category' => $category->id,
            'is_newtab' => 1,
            'title' => 'test title'
        ])->assertSee('Category List');
    }

    public function test_for_delete_category()
    {
        $this->actingAs(User::find(1));

        $category = Category::create([
            'name' => 'test name',
            'slug' => 'test-name',
            'parent_id' => 0,
            'searchable' => 1,
            'status' => 1
        ]);

        $element = HeaderCategoryPanel::create([
                    'title' => $category->name,
                    'category_id' => $category->id,
                    'status' => 1,
                    'is_newtab' => 0
                ]);

        $this->post('/appearance/headers/setup/delete-element',[
            'header_id' => 2,
            'id' => $element->id
        ])->assertSee('Category List');
    }

    public function test_for_add_product_in_product_section()
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
        
        $this->post('/appearance/headers/setup/add-element',[
            'id' => 3,
            'product' => [$seller_product->id]
        ])->assertSee('Product List');
    }

    public function test_for_update_product_in_product_section()
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

        $element = HeaderProductPanel::create([
                    'title' => $seller_product->product->product_name,
                    'product_id' => $seller_product->id,
                    'status' => 1,
                    'is_newtab' => 0
                ]);
        
        $this->post('/appearance/headers/setup/update-element',[
            'id' => $element->id,
            'header_id' => 3,
            'product' => $seller_product->id,
            'title' => 'test title',
            'is_newtab' => 1
        ])->assertSee('Product List');
    }

    public function test_for_update_new_user_zone()
    {
        $this->actingAs(User::find(1));
        
        $this->post('/appearance/headers/setup/update-element',[
            'title' => 'test title',
            'header_id' => 4,
            'navigation_label' => 'test label',
            'pricing' => '$5',
            'new_user_zone_id' => 1
        ])->assertSee(1);
    }
    
}
