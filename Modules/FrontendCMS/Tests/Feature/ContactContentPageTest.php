<?php

namespace Modules\FrontendCMS\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\FrontendCMS\Entities\ContactContent;
use Modules\FrontendCMS\Entities\InQuery;

class ContactContentPageTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_update_contact_content()
    {
        $this->actingAs(User::find(1));

        $content = ContactContent::first();
        
        $this->post('/frontendcms/contact-content/update',[
            'mainTitle' => 'for test',
            'subTitle' => 'for test',
            'slug' => 'for-test',
            'email' => 'test@test.com',
            'description' => 'test',
            'id' => $content->id,
        ])->assertStatus(200);
    }

    public function test_for_add_new_inquery()
    {
        $this->actingAs(User::find(1));
        
        $this->post('/frontendcms/query/store',[
            'name' => 'for test',
            'status' => 0,
        ])->assertStatus(200);
    }

    public function test_for_inwuery_edit_data()
    {
        $this->actingAs(User::find(1));
        
        $this->post('/frontendcms/query/store',[
            'name' => 'for test',
            'status' => 0,
        ]);

        $query = InQuery::orderBy('id','desc')->first();
        $url = '/frontendcms/query/'.$query->id. '/edit';
        $this->get($url)
        ->assertSee('Edit InQUery');
    }

    public function test_for_update_inquery()
    {
        $this->actingAs(User::find(1));
        
        $this->post('/frontendcms/query/store',[
            'name' => 'for test',
            'status' => 0,
        ]);
        $query = InQuery::orderBy('id','desc')->first();
        $this->post('/frontendcms/query/update',[
            'name' => 'for test',
            'status' => 0,
            'id' => $query->id
        ])->assertStatus(200);
    }

    public function test_for_delete_inquery()
    {
        $this->actingAs(User::find(1));
        
        $this->post('/frontendcms/query/store',[
            'name' => 'for test',
            'status' => 0,
        ]);
        $query = InQuery::orderBy('id','desc')->first();
        $this->post('/frontendcms/query/delete',[
            'id' => $query->id
        ])->assertStatus(200);
    }

    public function test_for_inquery_create_html()
    {
        $this->actingAs(User::find(1));
        
        $this->get('/frontendcms/query/create')
        ->assertStatus(200);
    }
}
