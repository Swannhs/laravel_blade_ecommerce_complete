<?php

namespace Tests\Browser\Modules\GeneralSetting;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Modules\GeneralSetting\Entities\EmailTemplate;
use Tests\DuskTestCase;

class EmailTemplateTest extends DuskTestCase
{
    use WithFaker;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_for_email_template_visit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/generalsetting/email-templates')
                ->assertSee('Email Template');
        });
    }

    public function test_for_create_email_template(){
        $this->test_for_email_template_visit();
        $this->browse(function (Browser $browser) {
            $browser->click('#main-content > section > div > div > div.col-12 > div > div > ul > li > a')
                ->assertPathIs('/generalsetting/email-templates/create')
                ->assertSee('Email Template')
                ->click('#main-content > section > div > div > div.col-lg-12.white_box_50px.box_shadow_white > form > div.row > div:nth-child(1) > div > div')
                ->click('#main-content > section > div > div > div.col-lg-12.white_box_50px.box_shadow_white > form > div.row > div:nth-child(1) > div > div > ul > li:nth-child(3)')
                ->type('#main-content > section > div > div > div.col-lg-12.white_box_50px.box_shadow_white > form > div.row > div:nth-child(4) > div > input', $this->faker->title)
                ->click('#main-content > section > div > div > div.col-lg-12.white_box_50px.box_shadow_white > form > div.row > div:nth-child(5) > div > div')
                ->click('#main-content > section > div > div > div.col-lg-12.white_box_50px.box_shadow_white > form > div.row > div:nth-child(5) > div > div > ul > li:nth-child(1)')
                ->click('#main-content > section > div > div > div.col-lg-12.white_box_50px.box_shadow_white > form > div.row > div:nth-child(5) > div > div')
                ->click('#main-content > section > div > div > div.col-lg-12.white_box_50px.box_shadow_white > form > div.row > div:nth-child(5) > div > div > ul > li:nth-child(2)')
                ->type('#main-content > section > div > div > div.col-lg-12.white_box_50px.box_shadow_white > form > div.row > div:nth-child(7) > div > div > div.note-editing-area > div.note-editable > div:nth-child(1) > h1', $this->faker->title)
                ->type('#main-content > section > div > div > div.col-lg-12.white_box_50px.box_shadow_white > form > div.row > div:nth-child(7) > div > div > div.note-editing-area > div.note-editable > div:nth-child(3) > h1', $this->faker->title)
                ->type('#main-content > section > div > div > div.col-lg-12.white_box_50px.box_shadow_white > form > div.row > div:nth-child(8) > div > input', $this->faker->email)
                ->click('#main-content > section > div > div > div.col-lg-12.white_box_50px.box_shadow_white > form > div.submit_btn.text-center.mb-100.pt_15 > button')
                ->assertPathIs('/generalsetting/email-templates/create')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Template has been created successfully !!!');
        });

    }

    public function test_for_validate_create(){
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/generalsetting/email-templates/create')
                ->assertSee('Email Template')
                ->click('#main-content > section > div > div > div.col-lg-12.white_box_50px.box_shadow_white > form > div.submit_btn.text-center.mb-100.pt_15 > button')
                ->assertPathIs('/generalsetting/email-templates/create')
                ->assertSeeIn('#main-content > section > div > div > div.col-lg-12.white_box_50px.box_shadow_white > form > div.row > div:nth-child(4) > div > span', 'The subject field is required.')
                ->assertSeeIn('#main-content > section > div > div > div.col-lg-12.white_box_50px.box_shadow_white > form > div.row > div:nth-child(8) > div > span', 'The email footer field is required.');

        });
    }

    public function test_for_manage_template(){
        $this->test_for_email_template_visit();
        $this->browse(function (Browser $browser) {
            $template = EmailTemplate::first();
            $browser->click('#DataTables_Table_0 > tbody > tr:nth-child(1) > td:nth-child(6) > a')
                ->assertPathIs('/generalsetting/email-templates/'.$template->id.'/manage')
                ->type('#main-content > section > div > div > div.col-lg-12.white_box_50px.box_shadow_white > form > div.row > div:nth-child(2) > div > input', 'Order Invoice')
                ->type('#main-content > section > div > div > div.col-lg-12.white_box_50px.box_shadow_white > form > div.row > div:nth-child(6) > div > input', 'test@test.com')
                ->click('#main-content > section > div > div > div.col-lg-12.white_box_50px.box_shadow_white > form > div.submit_btn.text-center.mb-100.pt_15 > button')
                ->assertPathIs('/generalsetting/email-templates/'.$template->id.'/manage')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Template has been updated successfully !!!');
        });
    }

    public function test_for_status_change_template(){
        $this->test_for_email_template_visit();
        $this->browse(function (Browser $browser) {
            $browser->click('#DataTables_Table_0 > tbody > tr:nth-child(1) > td:nth-child(5) > label > div')
            ->waitFor('.toast-message',25)
            ->assertSeeIn('.toast-message', 'Successfully Updated');
        });
    }
    
}
