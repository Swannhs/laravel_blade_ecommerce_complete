<?php

namespace Modules\Blog\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Modules\Blog\Entities\BlogCategory;
use Modules\Blog\Entities\BlogPost;
use Carbon\Carbon;

class PostTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_create_new_post()
    {
        $user = User::find(1);
        $this->actingAs($user);
        Storage::fake('public/upload');
        $category = BlogCategory::create([
            'name' => 'test category',
            'level' => 1,
            'parent_id' => 0
        ]);

        $this->post('/blog/posts',[
            'title' => 'test post 2222222222222',
            'slug' => 'test-post-2222222222222',
            'content' => 'this is for testting',
            'file' =>UploadedFile::fake()->image('image.jpg', 1, 1),
            'status' => 1,
            'is_commentable' => 1,
            'tag' => "tag 1,Tag 2 edit,tag 3",
            'categories' => [$category->id]
        ])->assertRedirect('/blog/posts');

        File::deleteDirectory(base_path('/uploads'));
    }

    public function test_for_update_post()
    {
        $user = User::find(1);
        $this->actingAs($user);
        Storage::fake('public/upload');
        $category = BlogCategory::create([
            'name' => 'test category',
            'level' => 1,
            'parent_id' => 0
        ]);

        $post = BlogPost::create([
            'author_id'  => $user->id,
            'title'      => 'test title 222222222',
            'slug'       => 'test-slug-222222222',
            'content'    => 'test content',
            'image_url'  => 'test,jpg',
            'status'     => 1,
            'is_commentable' =>  1,
            'published_at' => Carbon::now()
        ]);
        
        $this->put('/blog/posts/'.$post->id,[
            'title' => 'test post',
            'slug' => 'test-post',
            'content' => 'this is for testting',
            'file' =>UploadedFile::fake()->image('image.jpg', 1, 1),
            'status' => 1,
            'is_commentable' => 1,
            'tag' => "tag 1,Tag 2 edit,tag 3",
            'categories' => [$category->id]
        ])->assertRedirect('/blog/posts');

        File::deleteDirectory(base_path('/uploads'));
    }

    public function test_for_status_change()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $post = BlogPost::create([
            'author_id'  => $user->id,
            'title'      => 'test title 222222222',
            'slug'       => 'test-slug-222222222',
            'content'    => 'test content',
            'image_url'  => 'test,jpg',
            'status'     => 1,
            'is_commentable' =>  1,
            'published_at' => Carbon::now()
        ]);
        
        $this->post('/blog/post/status/update',[
            'id' => $post->id,
            'status' => 1
            
        ])->assertStatus(200);

    }

    public function test_for_approved()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $post = BlogPost::create([
            'author_id'  => $user->id,
            'title'      => 'test title 222222222',
            'slug'       => 'test-slug-222222222',
            'content'    => 'test content',
            'image_url'  => 'test,jpg',
            'status'     => 1,
            'is_commentable' =>  1,
            'published_at' => Carbon::now()
        ]);
        
        $this->post('/blog/post/approve',[
            'id' => $post->id
            
        ])->assertSee('success');

    }

    public function test_for_delete_post()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $post = BlogPost::create([
            'author_id'  => $user->id,
            'title'      => 'test title 222222222',
            'slug'       => 'test-slug-222222222',
            'content'    => 'test content',
            'image_url'  => 'test,jpg',
            'status'     => 1,
            'is_commentable' =>  1,
            'published_at' => Carbon::now()
        ]);
        
        $this->delete('/blog/posts/'.$post->id)->assertRedirect('blog/posts');

    }

}
