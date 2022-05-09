<?php

namespace Tests\Browser\Modules\Seller;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CommisionSetupTest extends DuskTestCase
{
    use WithFaker;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_for_visit_seller_commision_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                    ->visit('/admin/seller-commisions')
                    ->assertSee('Seller Commision');
        });
    }

    public function test_for_validate_check(){
        $this->test_for_visit_seller_commision_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#save_button_parent')
                ->waitFor('#edit_name_error', 15000)
                ->assertSeeIn('#edit_name_error', 'The name field is required.');
        });
    }

    public function test_for_update_commision(){
        $this->test_for_visit_seller_commision_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#DataTables_Table_0 > tbody > tr:nth-child(1) > td:nth-child(5) > div > button')
                ->click('#DataTables_Table_0 > tbody > tr:nth-child(1) > td:nth-child(5) > div > div > a')
                ->pause(10000)
                ->type('#itemEditForm > div > div > div:nth-child(2) > div > input', 'Flat Rate')
                ->type('#itemEditForm > div > div > div.col-xl-12.rate_div > div > input', '5')
                ->type('#itemEditForm > div > div > div:nth-child(4) > div > textarea', $this->faker->paragraph)
                ->click('#save_button_parent')
                ->waitFor('.toast-message',10000)
                ->assertSeeIn('.toast-message', 'Commision Updated Successfully.');
        });
    }

    
}
