<?php

namespace Tests\Browser\Modules\FrontendCMS;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AboutUsPageTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_for_about_us_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/frontendcms/about-us')        
                ->assertSee('About Us Contant');
        });
    }

    public function test_for_update(){
        $this->test_for_about_us_page();
        $this->browse(function (Browser $browser) {
            $browser->type('#main-content > section > div > div > div:nth-child(2) > div > form > div > div:nth-child(2) > div > div:nth-child(1) > div:nth-child(2) > div > input', 'initial main title edit')
                ->type('#main-content > section > div > div > div:nth-child(2) > div > form > div > div:nth-child(2) > div > div:nth-child(1) > div:nth-child(3) > div > input', 'initial subtitle edit')
                ->type('#slug', 'initial-main-title-edit')
                ->attach('#document_file_1', public_path('/frontend/default/img/about_1.png'))
                ->attach('#document_file_2', public_path('/frontend/default/img/about_1.png'))
                ->type('#main-content > section > div > div > div:nth-child(2) > div > form > div > div:nth-child(3) > div > div:nth-child(1) > div > div > input', 'initial benefit title edit')
                ->type('#main-content > section > div > div > div:nth-child(2) > div > form > div > div:nth-child(4) > div > div:nth-child(1) > div:nth-child(1) > div > input', 'initial selling title edit')
                ->type('#main-content > section > div > div > div:nth-child(2) > div > form > div > div:nth-child(4) > div > div:nth-child(1) > div:nth-child(2) > div > input', 'Starting @ $7.00/month')
                ->type('#main-content > section > div > div > div:nth-child(2) > div > form > div > div:nth-child(2) > div > div:nth-child(2) > div > div > div > div.note-editing-area > div.note-editable', 'initial main Description edit')
                ->type('#main-content > section > div > div > div:nth-child(2) > div > form > div > div:nth-child(3) > div > div:nth-child(2) > div > div > div > div.note-editing-area > div.note-editable', 'initial benefit description edit')
                ->type('#main-content > section > div > div > div:nth-child(2) > div > form > div > div:nth-child(4) > div > div:nth-child(2) > div > div > div > div.note-editing-area > div.note-editable', 'initial selling description edit')
                ->click('#save_button_parent')
                ->assertPathIs('/frontendcms/about-us')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated Successfully');
        });
    }

    public function test_for_validate(){
        $this->test_for_about_us_page();
        $this->browse(function (Browser $browser) {
            $browser->type('#main-content > section > div > div > div:nth-child(2) > div > form > div > div:nth-child(2) > div > div:nth-child(1) > div:nth-child(2) > div > input', '')
                ->type('#main-content > section > div > div > div:nth-child(2) > div > form > div > div:nth-child(2) > div > div:nth-child(1) > div:nth-child(3) > div > input', '')
                ->type('#slug', '')
                ->type('#main-content > section > div > div > div:nth-child(2) > div > form > div > div:nth-child(3) > div > div:nth-child(1) > div > div > input', '')
                ->type('#main-content > section > div > div > div:nth-child(2) > div > form > div > div:nth-child(4) > div > div:nth-child(1) > div:nth-child(1) > div > input', '')
                ->type('#main-content > section > div > div > div:nth-child(2) > div > form > div > div:nth-child(4) > div > div:nth-child(1) > div:nth-child(2) > div > input', '')
                ->type('#main-content > section > div > div > div:nth-child(2) > div > form > div > div:nth-child(2) > div > div:nth-child(2) > div > div > div > div.note-editing-area > div.note-editable', '')
                ->type('#main-content > section > div > div > div:nth-child(2) > div > form > div > div:nth-child(3) > div > div:nth-child(2) > div > div > div > div.note-editing-area > div.note-editable', '')
                ->type('#main-content > section > div > div > div:nth-child(2) > div > form > div > div:nth-child(4) > div > div:nth-child(2) > div > div > div > div.note-editing-area > div.note-editable', '')
                ->click('#save_button_parent')
                ->assertPathIs('/frontendcms/about-us')
                ->waitForText('The main title field is required.',25)
                ->assertSeeIn('#main-content > section > div > div > div:nth-child(2) > div > form > div > div:nth-child(1) > div > ul > li:nth-child(1)', 'The main title field is required.');
        });
    }
}
