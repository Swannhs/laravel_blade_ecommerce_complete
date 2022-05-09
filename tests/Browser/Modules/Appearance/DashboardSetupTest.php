<?php

namespace Tests\Browser\Modules\Appearance;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DashboardSetupTest extends DuskTestCase
{
    
    public function setUp(): void
    {
        parent::setUp();

    }

    public function tearDown(): void
    {
        
    }
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_for_visit_index_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/appearance/dashboard')
                ->assertSee('Dashboard Setup');
        });
    }


    public function test_for_update(){
        Artisan::call('migrate:fresh');
        $this->test_for_visit_index_page();
        $this->browse(function (Browser $browser) {
            $browser->pause(1000)
                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(2) > div:nth-child(1) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',15)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)
                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(2) > div:nth-child(2) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(2) > div:nth-child(3) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(2) > div:nth-child(4) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(2) > div:nth-child(5) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(2) > div:nth-child(6) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(2) > div:nth-child(7) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(2) > div:nth-child(8) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(2) > div:nth-child(9) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(2) > div:nth-child(10) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(2) > div:nth-child(11) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(2) > div:nth-child(12) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(1) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)
                
                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(1) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(2) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(2) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(3) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(3) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(4) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(4) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(5) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(5) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(6) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(6) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(7) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(7) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(8) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(8) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(9) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(9) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(10) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(10) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(11) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(11) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(12) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(12) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(13) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(13) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(14) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(14) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(15) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(15) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(16) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(16) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(17) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(17) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(18) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(18) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(19) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(19) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(20) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(20) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(21) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(21) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(22) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(22) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(23) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(23) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(24) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(24) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(25) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(25) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(26) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(26) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(27) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(27) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(28) > ul > li:nth-child(2) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!')
                ->pause(5000)

                ->click('#main-content > section > div > div:nth-child(2) > div > div > div:nth-child(4) > div:nth-child(28) > ul > li:nth-child(1) > label > span')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');

        });
    }


}
