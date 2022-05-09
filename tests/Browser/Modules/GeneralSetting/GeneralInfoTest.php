<?php

namespace Tests\Browser\Modules\GeneralSetting;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class GeneralInfoTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_for_general_info_visit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/generalsetting')
                ->assertSee('General Settings');
        });
    }

    public function test_for_update_general_info(){
        $this->test_for_general_info_visit();
        $this->browse(function (Browser $browser) {
            $browser->attach('#site_logo', __DIR__.'/files/logo.png')
                ->attach('#favicon_logo', __DIR__.'/files/favicon.png')
                ->type('#site_title', 'Amaz cart LTD')
                ->type('#copyright_text', 'Copyright © 2019 - 2020 All rights reserved | This application is made by <a href="https://codecanyon.net/user/codethemes" target="_blank"><font color="#ff0000">Codethemes</font></a>')
                ->click('#main-content > section > div > div > div > div:nth-child(2) > form > div.General_system_wrap_area > div:nth-child(2) > div > div:nth-child(4) > div > div')
                ->click('#main-content > section > div > div > div > div:nth-child(2) > form > div.General_system_wrap_area > div:nth-child(2) > div > div:nth-child(4) > div > div > ul > li:nth-child(2)')
                ->click('#main-content > section > div > div > div > div:nth-child(2) > form > div.General_system_wrap_area > div:nth-child(2) > div > div:nth-child(5) > div > div')
                ->click('#main-content > section > div > div > div > div:nth-child(2) > form > div.General_system_wrap_area > div:nth-child(2) > div > div:nth-child(5) > div > div > ul > li:nth-child(1)')
                ->click('#main-content > section > div > div > div > div:nth-child(2) > form > div.General_system_wrap_area > div:nth-child(2) > div > div:nth-child(6) > div > div')
                ->click('#main-content > section > div > div > div > div:nth-child(2) > form > div.General_system_wrap_area > div:nth-child(2) > div > div:nth-child(6) > div > div > ul > li:nth-child(2)')
                ->click('#main-content > section > div > div > div > div:nth-child(2) > form > div.General_system_wrap_area > div:nth-child(2) > div > div:nth-child(7) > div > div')
                ->click('#main-content > section > div > div > div > div:nth-child(2) > form > div.General_system_wrap_area > div:nth-child(2) > div > div:nth-child(7) > div > div > ul > li:nth-child(83)')
                ->type('#preloader', 'amazcart')
                ->click('#main-content > section > div > div > div > div:nth-child(2) > form > div.submit_btn.text-center.mt-4 > button')
                ->assertPathIs('/generalsetting')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated Successfully');
        });
    }

    public function test_activation_update(){
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('generalsetting/activation')
                ->assertSee('General Settings')
                ->click('#DataTables_Table_0 > tbody > tr:nth-child(1) > td.text-right > label > div')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated Successfully');
        });
    }
}
