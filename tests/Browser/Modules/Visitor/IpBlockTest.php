<?php

namespace Tests\Browser\Modules\Visitor;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class IpBlockTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_for_visit_index_page(){
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/visitor/ignore-ip')
                ->assertSee('IP LIST');
        });
    }

    public function test_for_add_new_ip(){
        $this->test_for_visit_index_page();
        $this->browse(function (Browser $browser) {
            $browser->type('#ip', rand(1111111111, 9999999999))
                ->click('#unitForm > div > div > div.col-lg-12.text-center > button')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Added successfully!');
        });
    }

    public function test_for_validate_create(){
        $this->test_for_visit_index_page();
        $this->browse(function (Browser $browser) {
            $browser->type('#ip', '')
                ->click('#unitForm > div > div > div.col-lg-12.text-center > button')
                ->waitForText('The ip field is required.', 25);
        });
    }

    public function test_for_delete_ip(){
        $this->test_for_add_new_ip();
        $this->browse(function (Browser $browser) {
            $browser->pause(10000)
                ->click('#ip_list_datatable > tbody > tr > td:nth-child(3) > div > button')
                ->click('#ip_list_datatable > tbody > tr > td:nth-child(3) > div > div > a')
                ->whenAvailable('#confirm-delete > div > div > div.modal-body > div.mt-40.d-flex.justify-content-between', function($modal){
                    $modal->click('#delete_link')
                        ->assertPathIs('/visitor/ignore-ip');
                })
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Deleted successfully!');
        });
    }
}
