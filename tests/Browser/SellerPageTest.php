<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SellerPageTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_for_seller_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/merchant')
                    ->assertSee('Become A Merchant');
        });
    }
}
