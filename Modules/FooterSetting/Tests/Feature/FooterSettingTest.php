<?php

namespace Modules\FooterSetting\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\FooterSetting\Entities\FooterWidget;

class FooterSettingTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_footer_setting()
    {
        $this->actingAs(User::find(1));
        $response = $this->post('/footer/footer-setting',[
            'copy_right' => 'test',
            'id' => 1
        ]);
        
        $response->assertStatus(200);
    }

    public function test_for_footer_setting_widget_create(){
        $this->actingAs(User::find(1));

        $response = $this->post('/footer/footer-widget',[
            'name' => 'test',
            'slug' => 'test',
            'category' => 1,
            'section' => 1,
            'page' => 1,
            'status' => 1,
            'is_static' => 0,
            'user_id' => 1
        ]);
        $response->assertStatus(200);
    }

    public function test_for_footer_setting_widget_update(){
        
        $this->actingAs(User::find(1));

        $this->post('/footer/footer-widget',[
            'name' => 'test',
            'slug' => 'test',
            'category' => 1,
            'section' => 1,
            'page' => 1,
            'status' => 1,
            'is_static' => 0,
            'user_id' => 1
        ]);
        $widget = FooterWidget::orderBy('id','desc')->first();

        $this->post('/footer/footer-widget-update',[
            'name' => 'test',
            'slug' => 'test',
            'category' => 1,
            'section' => 1,
            'page' => 1,
            'status' => 1,
            'is_static' => 0,
            'user_id' => 1,
            'id' => $widget->id
        ])->assertRedirect('/footer/footer-setting');
    }

    public function test_for_footer_setting_widget_delete(){
        
        $this->actingAs(User::find(1));

        $this->post('/footer/footer-widget',[
            'name' => 'test',
            'slug' => 'test',
            'category' => 1,
            'section' => 1,
            'page' => 1,
            'status' => 1,
            'is_static' => 0,
            'user_id' => 1
        ]);
        $widget = FooterWidget::orderBy('id','desc')->first();
        $url = '/footer/footer-widget-delete/'. $widget->id; 

        $this->get($url)->assertRedirect('/footer/footer-setting');
    }

    public function test_for_footer_setting_widget_status_change(){
        
        $this->actingAs(User::find(1));

        $this->post('/footer/footer-widget',[
            'name' => 'test',
            'slug' => 'test',
            'category' => 1,
            'section' => 1,
            'page' => 1,
            'status' => 1,
            'is_static' => 0,
            'user_id' => 1
        ]);
        $widget = FooterWidget::orderBy('id','desc')->first();
        $this->post('/footer/footer-widget-status',[

            'status' => 1,
            'id' => $widget->id
        ])->assertStatus(200);
    }

}
