<?php

namespace Modules\Blog\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Blog\Entities\BlogCategory;

class CategoryTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_delete_category()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $category = BlogCategory::create([
            'name' => 'test name',
            'parent_id' => 0,
            'level' => 2,
            'image_url' => 'test.jpg'
        ]);

        $this->delete('/blog/categories/'.$category->id)->assertRedirect('/blog/categories');

    }
}
