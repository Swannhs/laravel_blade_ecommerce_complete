<?php

namespace Modules\Product\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Product\Entities\Category;

class CategoryTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_create_category()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $this->post('/product/category',[
            'name' => 'test category 99',
            'slug' => 'test-category-99',
            'commission_rate' => 5,
            'icon' => 'ti-close',
            'searchable' => 1,
            'status' => 0,
        ])->assertSee('TableData');
    }

    public function test_for_get_edit_form()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $category = Category::create([
            'name' => 'test name',
            'slug' => 'test-name',
            'parent_id' => 0,
            'searchable' => 1,
            'status' => 1
        ]);
        
        $this->get('/product/category/'.$category->id.'/edit')->assertSee('Edit Category');


    }

    public function test_for_update_category()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $category = Category::create([
            'name' => 'test category 99',
            'slug' => 'test-category-99',
            'parent_id' => 0,
            'searchable' => 1,
            'status' => 1
        ]);

        $this->post('/product/category/update',[
            'name' => 'test category 99',
            'slug' => 'test-category-99',
            'commission_rate' => 5,
            'icon' => 'ti-close',
            'searchable' => 1,
            'status' => 0,
            'id' => $category->id
        ])->assertSee('TableData');

    }
}
