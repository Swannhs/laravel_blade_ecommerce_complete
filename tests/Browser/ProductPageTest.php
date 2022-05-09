<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProductPageTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_for_product_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/item/MTQ=')
                    ->assertSee('Add To Cart');
        });
    }
}
