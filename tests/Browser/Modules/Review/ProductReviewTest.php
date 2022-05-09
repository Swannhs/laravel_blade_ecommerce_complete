<?php

namespace Tests\Browser\Modules\Review;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProductReviewTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_for_visit_pending_review_list()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/review/product-approve-list')
                    ->assertSee('Pending Product Review List');
        });
    }

    public function test_for_visit_seller_product_review_list()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(4))
                    ->visit('/seller/product-reviews')
                    ->assertSee('Product Review List');
        });
    }
    

}
