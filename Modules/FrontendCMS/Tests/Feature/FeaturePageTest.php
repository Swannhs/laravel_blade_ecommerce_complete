<?php

namespace Modules\FrontendCMS\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\FrontendCMS\Entities\Feature;

class FeaturePageTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_add_new_feature()
    {
        $this->actingAs(User::find(1));

        $this->post('/frontendcms/features',[
            'title' => 'for test',
            'slug' => 'for-test',
            'icon' => 'ti-plus',
            'status' => 0,
        ])->assertStatus(200);
    }

    public function test_for_get_edit_data(){
        $this->actingAs(User::find(1));

        $this->post('/frontendcms/features',[
            'title' => 'for test',
            'slug' => 'for-test',
            'icon' => 'ti-plus',
            'status' => 0,
        ]);
        $feature = Feature::orderBy('id','desc')->first();
        $url = '/frontendcms/features/edit/'.$feature->id;
        $this->get($url)
        ->assertSee('Edit Feature');
    }

    public function test_for_update_feature(){
        $this->actingAs(User::find(1));

        $this->post('/frontendcms/features',[
            'title' => 'for test',
            'slug' => 'for-test',
            'icon' => 'ti-plus',
            'status' => 0,
        ]);
        $feature = Feature::orderBy('id','desc')->first();

        $this->post('/frontendcms/features/update',[
            'title' => 'for test',
            'slug' => 'for-test',
            'icon' => 'ti-plus',
            'status' => 0,
            'id' => $feature->id,
        ])->assertStatus(200);

    }

    public function test_for_delete_feature(){
        $this->actingAs(User::find(1));

        $this->post('/frontendcms/features',[
            'title' => 'for test',
            'slug' => 'for-test',
            'icon' => 'ti-plus',
            'status' => 0,
        ]);
        $feature = Feature::orderBy('id','desc')->first();
        $this->post('/frontendcms/features/delete',[
            'id' => $feature->id,
        ])->assertStatus(200);
    }


}
