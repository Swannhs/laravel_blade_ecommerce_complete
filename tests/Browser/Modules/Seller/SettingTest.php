<?php

namespace Tests\Browser\Modules\Seller;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SettingTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_for_visit_index_page()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(4);
            $browser->loginAs($user)
                    ->visit('/seller/setting')
                    ->assertSee('Seller Setting')
                    ->click('#seller_logo')
                    ->waitForText('Logo & Banner')
                    ->assertSee('Logo & Banner')
                    ->click('#delivery_option')
                    ->waitForText('Delivery Options')
                    ->assertSee('Delivery Options')
                    ->click('#shipping_provider')
                    ->waitForText('Shipping Provider')
                    ->assertSee('Shipping Provider')
                    ->click('#tax')
                    ->waitForText('TAX')
                    ->assertSee('TAX')
                    ->click('#social_link')
                    ->waitForText('Social Link')
                    ->assertSee('Social Link');
        });
    }

    public function test_for_upload_logo_and_banner(){
        $this->browse(function (Browser $browser) {
            $user = User::find(4);
            $browser->loginAs($user)
                    ->visit('/seller/setting')
                    ->assertSee('Seller Setting')
                    ->click('#seller_logo')
                    ->waitForText('Logo & Banner')
                    ->assertSee('Logo & Banner')
                    ->attach('#site_logo', __DIR__.'/file/avatar.jpg')
                    ->attach('#favicon_logo', __DIR__.'/file/banner.png')
                    ->click('#banner_logo_submit_btn')
                    ->back();
        });
    }

    


}
