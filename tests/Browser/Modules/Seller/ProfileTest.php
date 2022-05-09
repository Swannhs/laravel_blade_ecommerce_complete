<?php

namespace Tests\Browser\Modules\Seller;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProfileTest extends DuskTestCase
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
                    ->visit('/seller/profile')
                    ->assertSee('Seller Account')
                    ->click('#tab_2')
                    ->waitForText('Business Information')
                    ->assertSee('Business Information')
                    ->click('#tab_3')
                    ->waitForText('Bank Account')
                    ->assertSee('Bank Account')
                    ->click('#tab_4')
                    ->waitForText('WareHouse Address')
                    ->assertSee('WareHouse Address')
                    ->click('#tab_5')
                    ->waitForText('Return Address')
                    ->assertSee('Return Address');
        });
    }

    public function test_for_update_seller_account()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(4);
            $browser->loginAs($user)
                    ->visit('/seller/profile')
                    ->assertSee('Seller Account')
                    ->type('first_name', 'Amazcart')
                    ->type('last_name', 'Ltd')
                    ->type('email', 'amazcart@gmail.com')
                    ->type('seller_phone', '12387874598464')
                    ->type('shop_display_name', 'Amazcart')
                    ->click('#sellerAccountBtn')
                    
                    ->assertPathIs('/seller/profile');
        });
    }


}
