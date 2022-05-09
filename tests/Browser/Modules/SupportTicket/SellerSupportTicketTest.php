<?php

namespace Tests\Browser\Modules\SupportTicket;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Modules\SupportTicket\Entities\SupportTicket;
use Tests\DuskTestCase;

class SellerSupportTicketTest extends DuskTestCase
{
    use WithFaker;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    
     public function test_for_visit_index_page(){
        $this->browse(function (Browser $browser) {
            $browser->loginAs(5)
                ->visit('/seller/support-ticket')
                ->assertSee('Support Ticket');
        });
     }

     public function test_for_create_ticket(){
         $this->test_for_visit_index_page();
         $this->browse(function (Browser $browser) {
             $browser->click('#main-content > section > div > div.row.justify-content-between.p-3 > div:nth-child(2) > a')
                ->assertPathIs('/seller/support-ticket/create')
                ->assertSee('Open a Ticket')
                ->type('#subject', 'test supprot ticket')
                ->type('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(2) > div.col-lg-3 > div > div > input', rand(111111111111,999999999999))
                ->click('#priority_list_div > div > div.nice-select.primary_select.mb-15')
                ->click('#priority_list_div > div > div.nice-select.primary_select.mb-15.open > ul > li:nth-child(3)')
                ->attach('#ticket_file', __DIR__.'/files/ticket_file_2.pdf')
                ->click('#ticket_file_add')
                ->pause(1000)
                ->attach('#ticket_file_1', __DIR__.'/files/ticket_file_1.png')
                ->pause(1000)
                ->click('#category_list_div > div > div.nice-select.primary_select.mb-15')
                ->click('#category_list_div > div > div.nice-select.primary_select.mb-15.open > ul > li:nth-child(3)')
                ->type('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(2) > div.col-xl-12 > div > div > div.note-editing-area > div.note-editable', $this->faker->paragraph)
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(3) > div > div > button')
                ->assertPathIs('/seller/support-ticket')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Created successfully!');
         });
     }

     public function test_for_validate_create_form(){
        $this->test_for_visit_index_page();
        $this->browse(function (Browser $browser) {
            $browser->click('#main-content > section > div > div.row.justify-content-between.p-3 > div:nth-child(2) > a')
               ->assertPathIs('/seller/support-ticket/create')
               ->assertSee('Open a Ticket')
               ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(3) > div > div > button')
               ->assertPathIs('/seller/support-ticket/create')
               ->assertSeeIn('#error_subject', 'The subject field is required.')
               ->assertSeeIn('#error_priority_id', 'The priority id field is required.')
               ->assertSeeIn('#error_category_id', 'The category id field is required.')
               ->assertSeeIn('#error_message', 'The description field is required.');
        });       
     }

     public function test_for_edit_ticket(){
         $this->test_for_create_ticket();
         $this->browse(function (Browser $browser) {
             $ticket = SupportTicket::latest()->first();
             $browser->pause(9000)
                ->click('#dataListTable > tbody > tr > td:nth-child(6) > div > button')
                ->click('#dataListTable > tbody > tr > td:nth-child(6) > div > div > a:nth-child(2)')
                ->assertPathIs('/seller/support-ticket/'.$ticket->id.'/edit')
                ->assertSee('Update Ticket')
                ->type('#subject', 'test support ticket edit')
                ->type('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(3) > div.col-lg-3 > div > div > input', rand(111111111111,999999999999))
                ->click('#priority_list_div > div > div.nice-select.primary_select.mb-15')
                ->click('#priority_list_div > div > div.nice-select.primary_select.mb-15.open > ul > li:nth-child(2)')
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(3) > div:nth-child(4) > div > div.row.ml-0 > div:nth-child(1) > span > a')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Deleted successfully!')
                ->pause(5000)
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(3) > div:nth-child(4) > div > div.row.ml-0 > div > span > a')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Deleted successfully!')
                ->attach('#ticket_file',  __DIR__.'/files/ticket_file_1.png')
                ->click('#ticket_file_add')
                ->pause(1000)
                ->attach('#ticket_file_1', __DIR__.'/files/ticket_file_2.pdf')
                ->click('#category_list_div > div > div.nice-select.primary_select.mb-15')
                ->click('#category_list_div > div > div.nice-select.primary_select.mb-15.open > ul > li:nth-child(2)')
                ->type('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(3) > div.col-xl-12 > div > div > div.note-editing-area > div.note-editable', $this->faker->paragraph)
                ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(4) > div > div > button')
                ->assertPathIs('/seller/support-ticket')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');

         });
     }

     public function test_for_validate_edit_form(){
        $this->test_for_create_ticket();
        $this->browse(function (Browser $browser) {
            $ticket = SupportTicket::latest()->first();
            $browser->pause(9000)
               ->click('#dataListTable > tbody > tr > td:nth-child(6) > div > button')
               ->click('#dataListTable > tbody > tr > td:nth-child(6) > div > div > a:nth-child(2)')
               ->assertPathIs('/seller/support-ticket/'.$ticket->id.'/edit')
               ->assertSee('Update Ticket')
               ->type('#subject', '')
               ->type('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(3) > div.col-lg-3 > div > div > input', '')
               ->type('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(3) > div.col-xl-12 > div > div > div.note-editing-area > div.note-editable', '')
               ->click('#main-content > section > div > div > div:nth-child(2) > div > form > div:nth-child(4) > div > div > button')
               ->assertPathIs('/seller/support-ticket/'.$ticket->id.'/edit')
               ->assertSeeIn('#error_subject', 'The subject field is required.')
               ->assertSeeIn('#error_ticket_id', 'The ticket id field is required.')
               ->assertSeeIn('#error_message', 'The description field is required.');

        });
     }

     public function test_for_show(){
        $this->test_for_create_ticket();
        $this->browse(function (Browser $browser) {
            $ticket = SupportTicket::latest()->first();
            $browser->pause(9000)
               ->click('#dataListTable > tbody > tr > td:nth-child(6) > div > button')
               ->click('#dataListTable > tbody > tr > td:nth-child(6) > div > div > a:nth-child(1)')
               ->assertPathIs('/seller/support-ticket/'.$ticket->id.'/show')
               ->type('#main-content > section > div > div > div.col-lg-8.col-xl-9 > div > div > div.col-lg-12 > form > div > div.col-12.mb-30 > div > div.note-editing-area > div.note-editable', $this->faker->paragraph)
               ->attach('#ticket_file', __DIR__.'/files/ticket_file_2.pdf')
               ->click('#ticket_file_add')
               ->pause(1000)
               ->attach('#ticket_file_1',  __DIR__.'/files/ticket_file_1.png')
               ->click('#main-content > section > div > div > div.col-lg-8.col-xl-9 > div > div > div.col-lg-12 > form > div > div:nth-child(5) > div > button')
               ->assertPathIs('/seller/support-ticket/'.$ticket->id.'/show')
               ->waitFor('.toast-message',25)
               ->assertSeeIn('.toast-message', 'Send successfully!')
               ->click('#main-content > section > div > div > div.col-12 > div > div.table_btn_wrap > ul > li > div > button')
               ->click('#main-content > section > div > div > div.col-12 > div > div.table_btn_wrap > ul > li > div > div > a')
               ->assertPathIs('/seller/support-ticket/'.$ticket->id.'/edit')
               ->assertSee('Update Ticket');

        });
     }

     public function test_for_filter_ticket(){
        $this->test_for_create_ticket();
        $this->browse(function (Browser $browser) {
            $browser->click('#main-content > section > div > div:nth-child(2) > div:nth-child(1) > form > div > div:nth-child(1) > div > div')
                ->click('#main-content > section > div > div:nth-child(2) > div:nth-child(1) > form > div > div:nth-child(1) > div > div > ul > li:nth-child(3)')
                ->click('#main-content > section > div > div:nth-child(2) > div:nth-child(1) > form > div > div:nth-child(2) > div > div')
                ->click('#main-content > section > div > div:nth-child(2) > div:nth-child(1) > form > div > div:nth-child(2) > div > div > ul > li:nth-child(3)')
                ->click('#main-content > section > div > div:nth-child(2) > div:nth-child(1) > form > div > div.col-lg-12.mt-20.text-right > button')
                ->assertPathIs('/seller/support-ticket')
                ->pause(9000)
                ->assertSeeAnythingIn('#dataListTable > tbody > tr > td:nth-child(2)');
        });
     }


     
}
