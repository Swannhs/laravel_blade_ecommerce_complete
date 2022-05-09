<?php

namespace Modules\Blog\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Blog\Entities\BlogTag;

class TagTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_delete_tag()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $tag = BlogTag::create([
            'name' => 'test tag'
        ]);
        
        $this->delete('/blog/tags/'.$tag->id)->assertRedirect('blog/tags');

    }
}
