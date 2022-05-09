<?php

namespace Tests\Browser\Modules\FrontendCMS;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TitlePageTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_for_index_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/frontendcms/title-setting')
                ->assertSee('Title settings');
        });
    }

    public function test_for_update(){
        $this->test_for_index_page();
        $this->browse(function (Browser $browser) {
            $browser->type('#up_sale_product_display_title', 'Up Sale Products')
                ->type('#cross_sale_product_display_title', 'Cross Sale Products')
                ->click('#main-content > section > div > div > form > div.submit_btn.text-center > button')
                ->assertPathIs('/frontendcms/title-setting')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Title has been updated Successfully');
        });
    }
}
