<?php

namespace Modules\FrontendCMS\Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\FrontendCMS\Entities\StaticPage;

class StaticPageTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_status_change()
    {
        $this->actingAs(User::find(1));

        $this->post('/frontendcms/static-page',[
            'title' => 'test title',
            'slug' => 'test-title',
            'description' => 'test description',
            'status' => 0
        ]);
        $page = StaticPage::orderBy('id','desc')->first();
        
        $this->post('/frontendcms/static-page/status-update',[
            'status' => 1,
            'id' => $page->id,
        ])->assertStatus(200);
    }

    public function test_for_delete_static_page()
    {
        $this->actingAs(User::find(1));

        $this->post('/frontendcms/static-page',[
            'title' => 'test title',
            'slug' => 'test-title',
            'description' => 'test description',
            'status' => 1
        ]);

        $page = StaticPage::orderBy('id','desc')->first();
        
        $this->post('/frontendcms/static-page/delete',[
            'id' => $page->id,
        ])->assertStatus(200);
    }

}
