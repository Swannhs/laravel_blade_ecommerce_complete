<?php

namespace Modules\FrontendCMS\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\FrontendCMS\Entities\AboutUs;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class AboutUsPageTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_update_feature(){
        Storage::fake('public/upload');
        $this->actingAs(User::find(1));
        
        $this->post('/frontendcms/about-us/update/1',[
            'mainTitle' => 'for test',
            'subTitle' => 'for-test',
            'mainDescription' => 'ti-plus',
            'sec1_image' => UploadedFile::fake()->image('image.jpg', 1, 1),
            'sec2_image' => UploadedFile::fake()->image('image.jpg', 1, 1),
            'benifitTitle' => 'for test',
            'benifitDescription' => 'for test',
            'sellingTitle' => 'for test',
            'sellingDescription' => 'for-test',
            'slug' => 'for test',
            'price' => 'for test'
        ])->assertRedirect('/frontendcms/about-us');
        File::deleteDirectory(base_path('/uploads'));

    }
}
