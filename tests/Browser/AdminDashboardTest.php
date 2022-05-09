<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminDashboardTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_for_visit_dashboard()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                    ->visit('/admin-dashboard')
                    ->assertSee('Quick Summery');
        });
    }

    public function test_for_tab_wise(){
        $this->test_for_visit_dashboard();
        $this->browse(function (Browser $browser) {
            $browser->click('#main-content > section > div > div:nth-child(1) > div:nth-child(2) > div > ul > li:nth-child(1)')
                ->waitForText('Total Product', 2000)
                ->assertSee('Total Product')
                ->click('#main-content > section > div > div:nth-child(1) > div:nth-child(2) > div > ul > li:nth-child(2)')
                ->waitForText('Total Product', 2000)
                ->assertSee('Total Product')
                ->click('#main-content > section > div > div:nth-child(1) > div:nth-child(2) > div > ul > li:nth-child(3)')
                ->waitForText('Total Product', 2000)
                ->assertSee('Total Product')
                ->click('#main-content > section > div > div:nth-child(1) > div:nth-child(2) > div > ul > li:nth-child(4)')
                ->waitForText('Total Product', 2000)
                ->assertSee('Total Product');
                
        });
    }
}
