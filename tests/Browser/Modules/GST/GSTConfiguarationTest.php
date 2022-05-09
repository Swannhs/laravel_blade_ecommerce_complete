<?php

namespace Tests\Browser\Modules\GST;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class GSTConfiguarationTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_for_visit_index_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/gst-setup/gst/configuration')
                ->assertSee('GST Configuration /TAX/VAT');
        });
    }

    public function test_for_eneble_gst_update(){
        $this->test_for_visit_index_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#main-content > section > div > div > div > div > form > div > div:nth-child(1) > ul > li:nth-child(1) > label > span')
                ->pause(1000)
                ->assertSeeIn('#main-content > section > div > div > div > div > form > div > div.col-lg-12.inside_state_div > div > label', 'DELIVERY INSIDE STATE')
                ->click('#main-content > section > div > div > div > div > form > div > div.col-lg-12.inside_state_div > div > div')
                ->click('#main-content > section > div > div > div > div > form > div > div.col-lg-12.inside_state_div > div > div > ul > li:nth-child(3)')
                ->click('#main-content > section > div > div > div > div > form > div > div.col-lg-12.outside_state_div > div > div')
                ->click('#main-content > section > div > div > div > div > form > div > div.col-lg-12.outside_state_div > div > div > ul > li:nth-child(3)')
                ->click('#main-content > section > div > div > div > div > form > div > div.col-12 > div > button')
                ->assertPathIs('/gst-setup/gst/configuration')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');

        });
    }

    public function test_for_flat_rate_update(){
        $this->test_for_visit_index_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#main-content > section > div > div > div > div > form > div > div:nth-child(1) > ul > li:nth-child(2) > label > span')
                ->pause(1000)
                ->assertSeeIn('#main-content > section > div > div > div > div > form > div > div.col-lg-12.flat_div > div > label', 'FLAT TAX PERCENTAGE')
                ->click('#main-content > section > div > div > div > div > form > div > div.col-lg-12.flat_div > div > div')
                ->click('#main-content > section > div > div > div > div > form > div > div.col-lg-12.flat_div > div > div > ul > li:nth-child(4)')
                ->click('#main-content > section > div > div > div > div > form > div > div.col-12 > div > button')
                ->assertPathIs('/gst-setup/gst/configuration')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');
        });
    }
}
