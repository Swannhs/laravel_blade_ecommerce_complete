<?php

namespace Modules\Product\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Product\Entities\Attribute;

class AttributeTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_create_attribute()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $this->post('/product/attribute-store',[
            'name' => 'test 99',
            'description' => 'brand description',
            'display_type' => 'radio_button',
            'status' => 0,
            'variant_values' => [
                'test a','test b','test c'
            ]
            
        ])->assertStatus(200);
    }

    public function test_for_get_edit_data()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $attribute = Attribute::create([
            'name' => 'test 99',
            'description' => 'test description',
            'display_type' => 'radio_button',
            'status' => 0
        ]);

        $this->get('/product/attribute-list/'.$attribute->id.'/edit')->assertStatus(200);
    }

    public function test_for_update_attribute()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $attribute = Attribute::create([
            'name' => 'test 99',
            'description' => 'test description',
            'display_type' => 'radio_button',
            'status' => 0
        ]);

        $this->post('/product/attribute-list/'.$attribute->id.'/update',[
            'name' => 'test 99',
            'description' => 'brand description',
            'display_type' => 'radio_button',
            'status' => 1,
            'edit_variant_values' => [
                'test a','test b','test c'
            ]
            
        ])->assertStatus(200);
    }

    public function test_for_get_show_data()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $attribute = Attribute::create([
            'name' => 'test 99',
            'description' => 'test description',
            'display_type' => 'radio_button',
            'status' => 0
        ]);

        $this->post('/product/attribute-list/show',[
            'id' => $attribute->id
        ])->assertStatus(200);
    }

    public function test_for_delete_attribute()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $attribute = Attribute::create([
            'name' => 'test 99',
            'description' => 'test description',
            'display_type' => 'radio_button',
            'status' => 0
        ]);

        $this->get('/product/attribute-destroy/'.$attribute->id)->assertRedirect('/product/attribute-list');
    }

}
