<?php

namespace Modules\FrontendCMS\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Modules\FrontendCMS\Entities\Benifit;
use Modules\FrontendCMS\Entities\Faq;
use Modules\FrontendCMS\Entities\WorkingProcess;

class MerchantPageTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_merchant_page_update()
    {
        $this->actingAs(User::find(1));

        $this->post('/frontendcms/merchant-content/update',[
            'id' => 1,
            'mainTitle' => 'initial main title',
            'subTitle' => 'initial sub title',
            'slug' => 'initail slug',
            'Maindescription' => 'initial Main Description',
            'pricing' => 'initail pricing',
            'benifitTitle' => 'initial Benifit Title',
            'benifitDescription' => 'initial Benifit Description',
            'howitworkTitle' => 'initial How it work title',
            'howitworkDescription' => 'initial how it work Description',
            'pricingTitle' => 'initial pricing title',
            'pricingDescription' => 'initial pricing Description',
            'queryTitle' => 'initial query title',
            'queryDescription' => 'initial query Description',
            'faqTitle' => 'initial faq title',
            'faqDescription' => 'initial faq Description',
            'pricing_id' => 1
        ])->assertStatus(200);
    }

    public function test_for_create_benefit(){
        $this->actingAs(User::find(1));
        Storage::fake('public');

        $this->post('/frontendcms/benefit',[
            'title' => 'test benefit',
            'description' => 'test description',
            'status' => 0,
            'image' => $file = UploadedFile::fake()->image('image.jpg', 1, 1)
        ])->assertOk();
        File::deleteDirectory(base_path('/uploads'));
    }

    public function test_for_update_benefit(){
        $this->actingAs(User::find(1));
        Storage::fake('public');

        $this->post('/frontendcms/benefit',[
            'title' => 'test benefit',
            'description' => 'test description',
            'status' => 0,
            'image' => $file = UploadedFile::fake()->image('image.jpg', 1, 1)
        ]);

        $benefit = Benifit::orderBy('id','desc')->first();
        $this->post('/frontendcms/benefit/update',[
            'title' => 'test benefit',
            'description' => 'test description',
            'status' => 0,
            'image' => $file = UploadedFile::fake()->image('image.jpg', 1, 1),
            'id' => $benefit->id
        ])->assertStatus(200);

        File::deleteDirectory(base_path('/uploads'));

    }

    public function test_for_delete_benefit(){
        $this->actingAs(User::find(1));
        Storage::fake('public');

        $this->post('/frontendcms/benefit',[
            'title' => 'test benefit',
            'description' => 'test description',
            'status' => 0,
            'image' => $file = UploadedFile::fake()->image('image.jpg', 1, 1)
        ]);

        $benefit = Benifit::orderBy('id','desc')->first();
        $this->post('/frontendcms/benefit/delete',[
            'id' => $benefit->id
        ])->assertStatus(200);
        File::deleteDirectory(base_path('/uploads'));

    }
    
    public function test_for_create_how_it_work(){
        $this->actingAs(User::find(1));
        Storage::fake('public');

        $this->post('/frontendcms/how-it-work',[
            'title' => 'test process',
            'description' => 'test description',
            'status' => 0,
            'position' => 0,
            'image' => $file = UploadedFile::fake()->image('image.jpg', 1, 1)
        ])->assertStatus(200);
        File::deleteDirectory(base_path('/uploads'));
    }

    public function test_for_update_how_it_work(){
        $this->actingAs(User::find(1));
        Storage::fake('public');

        $this->post('/frontendcms/how-it-work',[
            'title' => 'test process',
            'description' => 'test description',
            'status' => 0,
            'position' => 0,
            'image' => UploadedFile::fake()->image('image.jpg', 1, 1)
        ]);

        $process = WorkingProcess::orderBy('id','desc')->first();

        $this->post('/frontendcms/how-it-work/update',[
            'title' => 'test process',
            'description' => 'test description',
            'status' => 0,
            'position' => 0,
            'image' => UploadedFile::fake()->image('image.jpg', 1, 1),
            'id' => $process->id
        ])->assertStatus(200);
        File::deleteDirectory(base_path('/uploads'));

    }

    public function test_for_delete_how_it_work(){
        $this->actingAs(User::find(1));
        Storage::fake('public');

        $this->post('/frontendcms/how-it-work',[
            'title' => 'test process',
            'description' => 'test description',
            'status' => 0,
            'position' => 0,
            'image' => UploadedFile::fake()->image('image.jpg', 1, 1)
        ]);

        $process = WorkingProcess::orderBy('id','desc')->first();

        $this->post('/frontendcms/how-it-work/delete',[
            'id' => $process->id
        ])->assertStatus(200);
        File::deleteDirectory(base_path('/uploads'));

    }

    public function test_for_create_faq(){
        $this->actingAs(User::find(1));
        Storage::fake('public');

        $this->post('/frontendcms/faq',[
            'title' => 'test faq',
            'description' => 'test description',
            'status' => 0,
        ])->assertStatus(200);
    }

    public function test_for_update_faq(){
        $this->actingAs(User::find(1));
        Storage::fake('public');

        $this->post('/frontendcms/faq',[
            'title' => 'test faq',
            'description' => 'test description',
            'status' => 0,
        ]);

        $faq = Faq::orderBy('id','desc')->first();

        $this->post('/frontendcms/faq/update',[
            'title' => 'test faq edit',
            'description' => 'test description',
            'status' => 0,
            'id' => $faq->id
        ])->assertStatus(200);

    }

    public function test_for_delete_faq(){
        $this->actingAs(User::find(1));
        Storage::fake('public');

        $this->post('/frontendcms/faq',[
            'title' => 'test faq',
            'description' => 'test description',
            'status' => 0,
        ]);

        $faq = Faq::orderBy('id','desc')->first();

        $this->post('/frontendcms/faq/delete',[
            'id' => $faq->id
        ])->assertStatus(200);

    }

}
