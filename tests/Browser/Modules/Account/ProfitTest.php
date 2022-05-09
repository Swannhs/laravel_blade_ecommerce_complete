<?php

namespace Tests\Browser\Modules\Account;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProfitTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_for_visit_index_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/account/profit')
                ->assertSee('Profit');
        });
    }

    public function test_for_search_by_custom_date(){
        $this->test_for_visit_index_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#date_range')
                ->pause(1000)
                ->click('div.daterangepicker.ltr.show-ranges.opensright.show-calendar > div.drp-calendar.left > div.calendar-table > table > tbody > tr:nth-child(2) > td:nth-child(1)')
                ->click('div.daterangepicker.ltr.show-ranges.opensright.show-calendar > div.drp-calendar.right > div.calendar-table > table > tbody > tr:nth-child(3) > td:nth-child(7)')
                ->click('div.daterangepicker.ltr.show-ranges.opensright.show-calendar > div.drp-buttons > button.applyBtn.btn.btn-sm.btn-primary')
                ->pause(5000)
                ->waitForTextIn('#DataTables_Table_1 > tbody > tr:nth-child(1) > td.sorting_1', '1st '.date('M').', 2021 - 18th '.date('M',strtotime('first day of +1 month')).', 2021', 25);
        });

    }
}
