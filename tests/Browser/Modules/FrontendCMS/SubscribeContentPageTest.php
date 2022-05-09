<?php

namespace Tests\Browser\Modules\FrontendCMS;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SubscribeContentPageTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_for_subscribe_content_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/frontendcms/subscribe-content')
                ->assertSee('Subscribe Content');
        });
    }

    public function test_for_update(){
        $this->test_for_subscribe_content_page();
        $this->browse(function (Browser $browser) {
            $browser->type('#formData > div > div:nth-child(2) > div > input', 'initial title edit')
                ->type('#formData > div > div:nth-child(3) > div > input', 'initials subtitle edit')
                ->type('#formData > div > div.col-xl-12 > div > div > div.note-editing-area > div.note-editable', 'initail description edit')
                ->click('#save_button_parent')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');
        });
    }

    public function test_for_validate(){
        $this->test_for_subscribe_content_page();
        $this->browse(function (Browser $browser) {
            $browser->type('#formData > div > div:nth-child(2) > div > input', '')
                ->type('#formData > div > div:nth-child(3) > div > input', '')
                ->type('#formData > div > div.col-xl-12 > div > div > div.note-editing-area > div.note-editable', '')
                ->click('#save_button_parent')
                ->waitForText('The title field is required.',25)
                ->assertSeeIn('#title_error', 'The title field is required.');
        });
    }
}
