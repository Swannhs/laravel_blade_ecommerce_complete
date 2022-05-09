<?php

namespace Tests\Browser\Modules\FrontendCMS;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HomePageTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_for_home_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/frontendcms/homepage')
                    ->assertSee('Home Page');
        });
    }

    public function test_best_deal(){
        $this->test_for_home_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#main-content > section > div > div > div.col-3 > div > div > div.col-lg-12 > div > div')
                ->click('#main-content > section > div > div > div.col-3 > div > div > div.col-lg-12 > div > div > ul > li:nth-child(2)')
                ->waitForText('COLUMN SIZE',25)
                ->type('#title', 'Best Deals edit')
                ->click('#form_appand > div:nth-child(3) > div > div')
                ->click('#form_appand > div:nth-child(3) > div > div > ul > li.option.selected.focus')
                ->click('#for_product_type > div > div')
                ->click('#for_product_type > div > div > ul > li:nth-child(2)')
                ->click('#widget_form_btn')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');
                
        });
    }

    public function test_for_top_brands(){
        $this->test_for_home_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#main-content > section > div > div > div.col-3 > div > div > div.col-lg-12 > div > div')
                ->click('#main-content > section > div > div > div.col-3 > div > div > div.col-lg-12 > div > div > ul > li:nth-child(3)')
                ->waitForText('TYPE', 25)
                ->type('#title', 'Top Brands edit')
                ->click('#form_appand > div:nth-child(3) > div > div')
                ->click('#form_appand > div:nth-child(3) > div > div > ul > li.option.selected.focus')
                ->click('#for_product_type > div > div')
                ->click('#for_product_type > div > div > ul > li:nth-child(4)')
                ->click('#widget_form_btn')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');
        });
    }

    public function test_for_top_picks(){
        $this->test_for_home_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#main-content > section > div > div > div.col-3 > div > div > div.col-lg-12 > div > div')
                ->click('#main-content > section > div > div > div.col-3 > div > div > div.col-lg-12 > div > div > ul > li:nth-child(4)')
                ->waitForText('TYPE', 25)
                ->type('#title', 'Top Picks edit')
                ->click('#form_appand > div:nth-child(3) > div > div')
                ->click('#form_appand > div:nth-child(3) > div > div > ul > li.option.selected.focus')
                ->click('#for_product_type > div > div')
                ->click('#for_product_type > div > div > ul > li:nth-child(5)')
                ->click('#widget_form_btn')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');
        });
    }

    public function test_for_feature_categories(){
        $this->test_for_home_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#main-content > section > div > div > div.col-3 > div > div > div.col-lg-12 > div > div')
                ->click('#main-content > section > div > div > div.col-3 > div > div > div.col-lg-12 > div > div > ul > li:nth-child(5)')
                ->waitForText('TYPE', 25)
                ->type('#title', 'Feature Categories edit')
                ->click('#form_appand > div:nth-child(3) > div > div')
                ->click('#form_appand > div:nth-child(3) > div > div > ul > li:nth-child(5)')
                ->click('#for_product_type > div > div')
                ->click('#for_product_type > div > div > ul > li:nth-child(5)')
                ->click('#widget_form_btn')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');
        });
    }

    public function test_for_more_you_love(){
        $this->test_for_home_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#main-content > section > div > div > div.col-3 > div > div > div.col-lg-12 > div > div')
                ->click('#main-content > section > div > div > div.col-3 > div > div > div.col-lg-12 > div > div > ul > li:nth-child(6)')
                ->waitForText('TYPE', 25)
                ->type('#title','MORE PRODUCTS THAT YOU MAY LOVE edit')
                ->click('#form_appand > div:nth-child(3) > div > div')
                ->click('#form_appand > div:nth-child(3) > div > div > ul > li:nth-child(5)')
                ->click('#for_product_type > div > div')
                ->click('#for_product_type > div > div > ul > li:nth-child(5)')
                ->pause(1000)
                ->click('#widget_form_btn')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');
        });
    }

    public function test_for_validate(){
        $this->test_for_home_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#main-content > section > div > div > div.col-3 > div > div > div.col-lg-12 > div > div')
                ->click('#main-content > section > div > div > div.col-3 > div > div > div.col-lg-12 > div > div > ul > li:nth-child(6)')
                ->waitForText('TYPE', 25)
                ->type('#title','')
                ->click('#widget_form_btn')
                ->waitForText('The title field is required.', 25)
                ->assertSeeIn('#error_title', 'The title field is required.');
        });
    }
}
