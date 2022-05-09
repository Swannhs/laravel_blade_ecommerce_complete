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
use Str;

class FlashDealTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_create_flash_deal()
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

        $this->post('/marketing/flash-deals/store',[
            'title' => 'test title',
            'text_color' => '#000',
            'background_color' => '#fff',
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d'),
            'banner_image' => UploadedFile::fake()->image('image.jpg', 1, 1),
            'products' => [$seller_product->id],
            'discount' => [5],
            'discount_type' => [1],
            'date' => '12-12-2020 to 12-12-2020'
        ])->assertRedirect('/marketing/flash-deals');

        File::deleteDirectory(base_path('/uploads'));

    }

    public function test_for_update_flash_deal()
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

        $flash_deal = FlashDeal::create([
            'title' => 'test title',
            'background_color' => '#000',
            'text_color' => '#fff',
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d'),
            'slug' => 'test-title'.'-'. Str::random(5),
            'banner_image' => 'test.jpg'
        ]);


        $this->post('/marketing/flash-deals/update/'.encrypt($flash_deal->id),[
            'title' => 'test title',
            'text_color' => '#000',
            'background_color' => '#fff',
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d'),
            'banner_image' => UploadedFile::fake()->image('image.jpg', 1, 1),
            'products' => [$seller_product->id],
            'discount' => [5],
            'discount_type' => [1],
            'date' => '12-12-2020 to 12-12-2020'
        ])->assertRedirect('/marketing/flash-deals');

        File::deleteDirectory(base_path('/uploads'));

    }

    public function test_for_delete_flash_deal()
    {
        $this->actingAs(User::find(1));

        $flash_deal = FlashDeal::create([
            'title' => 'test title',
            'background_color' => '#000',
            'text_color' => '#fff',
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d'),
            'slug' => 'test-title'.'-'. Str::random(5),
            'banner_image' => 'test.jpg'
        ]);


        $this->post('/marketing/flash-deals/delete',[
            'id' => $flash_deal->id
        ])->assertSee('SL');


    }

    public function test_for_status_change_flash_deal()
    {
        $this->actingAs(User::find(1));


        $flash_deal = FlashDeal::create([
            'title' => 'test title',
            'background_color' => '#000',
            'text_color' => '#fff',
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d'),
            'slug' => 'test-title'.'-'. Str::random(5),
            'banner_image' => 'test.jpg'
        ]);


        $this->post('/marketing/flash-deals/status',[
            'id' => $flash_deal->id,
            'status' => 1
        ])->assertSee('SL');

    }

    public function test_for_feature_change_flash_deal()
    {
        $this->actingAs(User::find(1));


        $flash_deal = FlashDeal::create([
            'title' => 'test title',
            'background_color' => '#000',
            'text_color' => '#fff',
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d'),
            'slug' => 'test-title'.'-'. Str::random(5),
            'banner_image' => 'test.jpg'
        ]);


        $this->post('/marketing/flash-deals/featured',[
            'id' => $flash_deal->id,
            'is_featured' => 1
        ])->assertSee(1);

    }

}
