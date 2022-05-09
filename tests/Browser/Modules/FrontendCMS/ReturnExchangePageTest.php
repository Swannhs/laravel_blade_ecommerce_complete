<?php

namespace Tests\Browser\Modules\FrontendCMS;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ReturnExchangePageTest extends DuskTestCase
{
    
    public function test_for_return_exchange_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/frontendcms/return-exchange')
                ->assertSee('Return & Exchange');
        });
    }

    public function test_for_update(){
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/frontendcms/return-exchange')
                ->type('#mainTitle', 'main title edit')
                ->type('#slug', 'main-title-edit')
                ->type('#returnTitle', 'return Title edit')
                ->type('#exchangeTitle', 'exchange Title edit')
                ->type('#formData > div > div:nth-child(2) > div > div.col-xl-5 > div > div > div > div.note-editing-area > div.note-editable','return Description edit')
                ->type('#formData > div > div:nth-child(3) > div > div.col-xl-5 > div > div > div > div.note-editing-area > div.note-editable', 'exchange Description edit')
                ->click('#mainSubmit')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');
        });
    }
}
