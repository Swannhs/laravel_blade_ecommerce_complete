<?php

namespace Tests\Browser\Modules\Review;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SellerReviewTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_for_visit_pending_seller_review()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/review/seller-approve-list')
                    ->assertSee('Pending Seller Review List');
        });
    }

    public function test_for_visit_my_review()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(4))
                    ->visit('/seller/my-reviews')
                    ->assertSee('My Review List');
        });
    }
}
