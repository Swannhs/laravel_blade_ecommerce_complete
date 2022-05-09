<?php

namespace Modules\FrontendCMS\Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomePageTest extends TestCase
{
    /**
     * A basic unit test example.
     *@test
     * @return void
     */
    public function change_section_to_update()
    {
        $this->actingAs(User::find(1));

        $response = $this->post('/frontendcms/homepage/getsection-form',[
            'value' => 'best_deals'
        ])->assertSee('Product List');
        
    }
    
    public function test_for_update_section_data(){
        $this->actingAs(User::find(1));

        $response = $this->post('/frontendcms/homepage/update',[
            'form_for' => 'best_deals',
            'id' => 1,
            'status' => 1,
            'title' => 'Best Deals',
            'column_size' => 'col-lg-12',
            'type' => 4
        ])->assertStatus(200);
    }
}
