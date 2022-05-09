<?php

namespace Tests\Browser\Modules\Seller;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SellerListTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_for_visit_seller_list()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                    ->visit('/admin/merchants')
                    ->assertSee('Seller List');
        });
    }

    public function test_for_create_seller(){
        $this->test_for_visit_seller_list();
        $this->browse(function (Browser $browser) {
            $browser->click('#create_new_seller_btn')
                ->assertPathIs('admin/merchant-create')
                ->assertSee('Create a Seller');
        });
    }


    public function test_for_visit_seller_details_page()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                    ->visit('/admin/merchant/4/details')
                    ->assertSee('Seller Details');
        });
    }

    public function test_for_visit_seller_edit_page()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)
                    ->visit('/admin/profile-edit/4')
                    ->assertSee('Seller Profile');
        });
    }


}
