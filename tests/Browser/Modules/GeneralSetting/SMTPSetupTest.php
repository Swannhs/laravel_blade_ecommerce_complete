<?php

namespace Tests\Browser\Modules\GeneralSetting;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SMTPSetupTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_for_visit_smtp_index_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/generalsetting/smtp-setting')
                ->assertSee('SMTP Settings');
        });
    }

    public function test_for_smtp_update(){
        $this->test_for_visit_smtp_index_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#smtp > div:nth-child(1) > div > div')
                ->click('#smtp > div:nth-child(1) > div > div > ul > li:nth-child(1)')
                ->type('#smtp > div:nth-child(2) > div > input.primary_input_field', 'Amazcart Ltd')
                ->type('#smtp > div:nth-child(3) > div > input.primary_input_field', 'hafijurrahman970@gmail.com')
                ->type('#smtp > div:nth-child(4) > div > input.primary_input_field' ,'smtp.gmail.com')
                ->type('#smtp > div:nth-child(5) > div > input.primary_input_field', '587')
                ->type('#smtp > div:nth-child(6) > div > input.primary_input_field', 'hafijurrahman970@gmail.com')
                ->type('#smtp > div:nth-child(7) > div > input.primary_input_field', 'sldxtqmwhutuspbi')
                ->click('#smtp > div:nth-child(8) > div > div')
                ->click('#smtp > div:nth-child(8) > div > div > ul > li:nth-child(2)')
                ->type('#smtp > div:nth-child(9) > div > input.primary_input_field', 'utf-8')
                ->type('#main-content > section > div > div > div > div > form:nth-child(2) > div:nth-child(5) > div:nth-child(1) > div > textarea', 'test')
                ->type('#main-content > section > div > div > div > div > form:nth-child(2) > div:nth-child(5) > div:nth-child(2) > div > textarea', 'test')
                ->type('#main-content > section > div > div > div > div > form:nth-child(2) > div:nth-child(5) > div:nth-child(3) > div > textarea', 'test')
                ->click('#main-content > section > div > div > div > div > form:nth-child(2) > div:nth-child(5) > div.col-12.mb-45.pt_15 > div > button')
                ->assertPathIs('/generalsetting/smtp-setting')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');
        });
    }

    public function test_for_mail_sent(){
        $this->test_for_visit_smtp_index_page();
        $this->browse(function (Browser $browser) {
            $browser->type('#main-content > section > div > div > div > div > form:nth-child(4) > div.row > div:nth-child(1) > div > input', 'spn21@spondonit.com')
                ->type('#main-content > section > div > div > div > div > form:nth-child(4) > div.row > div:nth-child(2) > div > input', 'test mail')
                ->click('#main-content > section > div > div > div > div > form:nth-child(4) > div.submit_btn.text-center.mb-100.pt_15 > button')
                ->assertPathIs('/generalsetting/smtp-setting')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Mail has been sent Successfully');
                
                
        });
    }

    public function test_for_sendmail_update(){
        $this->test_for_visit_smtp_index_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#main-content > section > div > div > div > div > form:nth-child(2) > div:nth-child(2) > div > div > div')
                ->click('#main-content > section > div > div > div > div > form:nth-child(2) > div:nth-child(2) > div > div > div > ul > li:nth-child(2)')
                ->type('#sendmail > div:nth-child(1) > div > input.primary_input_field', 'Amazcart')
                ->type('#sendmail > div:nth-child(2) > div > input.primary_input_field', 'spn21@spondotit.com')
                ->type('#main-content > section > div > div > div > div > form:nth-child(2) > div:nth-child(5) > div:nth-child(1) > div > textarea', 'test')
                ->type('#main-content > section > div > div > div > div > form:nth-child(2) > div:nth-child(5) > div:nth-child(2) > div > textarea', 'test')
                ->type('#main-content > section > div > div > div > div > form:nth-child(2) > div:nth-child(5) > div:nth-child(3) > div > textarea', 'test')
                ->click('#main-content > section > div > div > div > div > form:nth-child(2) > div:nth-child(5) > div.col-12.mb-45.pt_15 > div > button')
                ->assertPathIs('/generalsetting/smtp-setting')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');

        });    
    }


}
