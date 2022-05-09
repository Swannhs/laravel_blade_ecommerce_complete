<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ContactUsPageTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_for_contact_us_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/contact-us')
                    ->assertSee('Send Message');
        });

    }
}
