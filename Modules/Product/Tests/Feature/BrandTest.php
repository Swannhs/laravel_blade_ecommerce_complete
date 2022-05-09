<?php

namespace Modules\Product\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Modules\Product\Entities\Brand;

class BrandTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_create_brand()
    {
        $user = User::find(1);
        $this->actingAs($user);
        Storage::fake('/public');

        $this->post('/product/brands-store',[
            'name' => 'test category 99',
            'description' => 'brand description',
            'link' => '#',
            'meta_title' => 'test',
            'meta_description' => 1,
            'status' => 0,
            'logo' => UploadedFile::fake()->image('image.jpg', 56, 56),
            'featured' => 1
        ])->assertRedirect('/product/brands-list');

        File::deleteDirectory(base_path('/uploads'));
    }

    public function test_for_update_brand()
    {
        $user = User::find(1);
        $this->actingAs($user);
        Storage::fake('/public');

        $brand = Brand::create([
            'name' => 'test name 99',
            'status' => 0,
            'logo' => 'test.jpg'
        ]);

        $this->post('/product/brands-update/'.$brand->id,[
            'name' => 'test category 99 edit',
            'description' => 'brand description',
            'link' => '#',
            'meta_title' => 'test',
            'meta_description' => 1,
            'status' => 0,
            'logo' => UploadedFile::fake()->image('image.jpg', 56, 56),
            'featured' => 1
        ])->assertRedirect('/product/brands-list');

        File::deleteDirectory(base_path('/uploads'));
    }

    public function test_for_delete_brand()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $brand = Brand::create([
            'name' => 'test name 99',
            'status' => 0,
            'logo' => 'test.jpg'
        ]);

        $this->get('/product/brands-destroy/'.$brand->id)->assertRedirect('/product/brands-list');

    }

    public function test_for_status_change_brand()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $brand = Brand::create([
            'name' => 'test name 99',
            'status' => 0,
            'logo' => 'test.jpg'
        ]);

        $this->post('/product/brands-update-status',[
            'id' => $brand->id,
            'status' => 1
        ])->assertSee(1);

    }

    public function test_for_featured_change_brand()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $brand = Brand::create([
            'name' => 'test name 99',
            'status' => 0,
            'logo' => 'test.jpg'
        ]);

        $this->post('/product/brands-update-feature',[
            'id' => $brand->id,
            'status' => 1
        ])->assertSee(1);

    }

    public function test_for_load_more_brand()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $this->post('/product/load-more-brand',[
            'skip' => 10
        ])->assertSee('brands');

    }

}
