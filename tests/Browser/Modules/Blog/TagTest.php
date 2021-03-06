<?php

namespace Tests\Browser\Modules\Blog;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Modules\Blog\Entities\BlogTag;
use Tests\DuskTestCase;

class TagTest extends DuskTestCase
{
    use WithFaker;


    public function setUp(): void
    {
        parent::setUp();


    }

    public function tearDown(): void
    {
        $tags = BlogTag::pluck('id');
        BlogTag::destroy($tags);
        

        parent::tearDown(); // TODO: Change the autogenerated stub
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_visit_index_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                    ->visit('/blog/tags')
                    ->assertSee('Blog Tags');
        });
    }

    public function test_for_create_tag(){
        $this->test_visit_index_page();
        $this->browse(function (Browser $browser) {
            $browser->type('#name',$this->faker->name)
                    ->click('#add_btn')
                    ->assertPathIs('/blog/tags')
                    ->waitFor('.toast-message',25)
                    ->assertSeeIn('.toast-message', 'Operation done successfully.');
        });
    }

    public function test_for_edit_tag(){
        $this->test_for_create_tag();
        $this->browse(function (Browser $browser) {
            $tag = BlogTag::latest()->first();
            $browser->waitFor('#tagTable > tbody > tr > td:nth-child(3) > div > button', 25)
                ->click('#tagTable > tbody > tr > td:nth-child(3) > div > button')
                ->click('#tagTable > tbody > tr > td:nth-child(3) > div > div > a:nth-child(1)')
                ->assertPathIs('/blog/tags/'.$tag->id.'/edit')
                ->assertSee('Edit Blog Tags')
                ->type('#name', $this->faker->name)
                ->click('#updateBtn')
                ->assertPathIs('/blog/tags')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Operation done successfully.');
        });
    }

    public function test_for_delete_tag(){
        $this->test_for_create_tag();
        $this->browse(function (Browser $browser) {
            $tag = BlogTag::latest()->first();
            $browser->waitFor('#tagTable > tbody > tr > td:nth-child(3) > div > button', 25)
                ->click('#tagTable > tbody > tr > td:nth-child(3) > div > button')
                ->click('#tagTable > tbody > tr > td:nth-child(3) > div > div > a.dropdown-item.delete_tag')
                ->whenAvailable('#tag_delete_form', function($modal){
                    $modal->click('input.primary-btn.fix-gr-bg')
                    ->assertPathIs('/blog/tags');
                })
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Operation done successfully.');
        });
    }

    
}
