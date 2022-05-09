<?php

namespace Tests\Browser\Modules\Product;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RecentViewConfigTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_for_visit_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                    ->visit('/product/recently-view-product-config')
                    ->assertSee('Recently Viewed Product Configuration');
        });
    }

    public function test_for_update_configure(){
        $this->test_for_visit_page();
        $this->browse(function (Browser $browser) {
            $browser->type('#main-content > section > div > form > div > div > div > div > div:nth-child(1) > div > input', '10')
                ->type('#main-content > section > div > form > div > div > div > div > div:nth-child(2) > div > input', '5')
                ->click('#main-content > section > div > form > div > div > div > div > div.col-12 > button')
                ->assertPathIs('/product/recently-view-product-config')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated Successfully!');
        });
    }
}
