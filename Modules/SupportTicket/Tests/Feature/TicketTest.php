<?php

namespace Modules\SupportTicket\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\SupportTicket\Entities\SupportTicket;
use Modules\SupportTicket\Entities\TicketCategory;
use Modules\SupportTicket\Entities\TicketPriority;
use Modules\SupportTicket\Entities\TicketStatus;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class TicketTest extends TestCase
{
    use DatabaseTransactions;
    // use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_add_new_ticket()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $category = TicketCategory::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $priority = TicketPriority::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $status = TicketStatus::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $this->post('/admin/ticket/tickets',[
            "subject" => "test 99",
            "ticket_id" => "32908450349056",
            "priority_id" => $priority->id,
            "user_id" => "6",
            "category_id" => $category->id,
            "status" => $status->id,
            "refer_id" => "2",
            "description" => "<p>for testtig</p>",
        ])->assertRedirect('/admin/ticket/tickets');

    }

    public function test_for_update_ticket()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $category = TicketCategory::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $priority = TicketPriority::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $status = TicketStatus::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $ticket = SupportTicket::create([
            'reference_no' => '9848604936569097-test',
            'subject' => 'test 99',
            'description' => 'test 99',
            "priority_id" => $priority->id,
            "user_id" => "6",
            "category_id" => $category->id,
            "status_id" => $status->id
        ]);
        

        $this->put('/admin/ticket/tickets/'.$ticket->id,[
            "subject" => "test 99",
            "ticket_id" => "32908450349056",
            "priority_id" => $priority->id,
            "user_id" => "6",
            "category_id" => $category->id,
            "status" => $status->id,
            "refer_id" => "2",
            "description" => "<p>for testtig</p>",
        ])->assertRedirect('/admin/ticket/tickets');

    }

    public function test_for_delete_ticket()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $category = TicketCategory::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $priority = TicketPriority::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $status = TicketStatus::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $ticket = SupportTicket::create([
            'reference_no' => '9848604936569097-test',
            'subject' => 'test 99',
            'description' => 'test 99',
            "priority_id" => $priority->id,
            "user_id" => "6",
            "category_id" => $category->id,
            "status_id" => $status->id
        ]);
        

        $this->post('/admin/ticket/delete',[
            'id' => $ticket->id
        ])->assertRedirect('/admin/ticket/tickets');

    }

    public function test_for_send_reply_from_admin()
    {
        $user = User::find(1);
        $this->actingAs($user);
        Storage::fake('uploads');

        $category = TicketCategory::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $priority = TicketPriority::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $status = TicketStatus::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $ticket = SupportTicket::create([
            'reference_no' => '9848604936569097-test',
            'subject' => 'test 99',
            'description' => 'test 99',
            "priority_id" => $priority->id,
            "user_id" => "6",
            "category_id" => $category->id,
            "status_id" => $status->id
        ]);
        

        $this->post('/admin/ticket/message',[
            'ticket_id' => $ticket->id,
            'type' => 1,
            'status_id' => $status->id,
            'text' => 'test',
            'ticket_file' => [UploadedFile::fake()->image('image.jpg', 1, 1)]
        ])->assertRedirect(session()->previousUrl());

        File::deleteDirectory(base_path('/uploads'));

    }

    public function test_for_asign_user()
    {
        $user = User::find(1);
        $this->actingAs($user);
        Storage::fake('uploads');

        $category = TicketCategory::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $priority = TicketPriority::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $status = TicketStatus::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $ticket = SupportTicket::create([
            'reference_no' => '9848604936569097-test',
            'subject' => 'test 99',
            'description' => 'test 99',
            "priority_id" => $priority->id,
            "user_id" => "6",
            "category_id" => $category->id,
            "status_id" => $status->id
        ]);
        

        $this->put('/admin/ticket/assign-user',[
            'ticket_id' => $ticket->id,
            'refer_id' => 3
        ])->assertRedirect(session()->previousUrl());


    }

    public function test_for_search_ticket()
    {
        $user = User::find(1);
        $this->actingAs($user);
        Storage::fake('uploads');

        $category = TicketCategory::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $priority = TicketPriority::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $status = TicketStatus::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $ticket = SupportTicket::create([
            'reference_no' => '9848604936569097-test',
            'subject' => 'test 99',
            'description' => 'test 99',
            "priority_id" => $priority->id,
            "user_id" => "6",
            "category_id" => $category->id,
            "status_id" => $status->id
        ]);
        

        $this->get('/admin/ticket/search?'.'category_id='.$category->id)->assertStatus(200);


    }

    //seller

    public function test_for_seller_add_new_ticket()
    {
        $user = User::find(4);
        $this->actingAs($user);

        $category = TicketCategory::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $priority = TicketPriority::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $status = TicketStatus::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $this->post('/seller/support-ticket',[
            "subject" => "test 99",
            "ticket_id" => "32908450349056",
            "priority_id" => $priority->id,
            "user_id" => $user->id,
            "category_id" => $category->id,
            "description" => "<p>for testtig</p>",
            'ticket_file' => [UploadedFile::fake()->image('image.jpg', 1, 1)]
        ])->assertRedirect('/seller/support-ticket');
        File::deleteDirectory(base_path('uploads'));

    }

    public function test_for_seller_update_ticket()
    {
        $user = User::find(4);
        $this->actingAs($user);

        $category = TicketCategory::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $priority = TicketPriority::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $status = TicketStatus::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $ticket = SupportTicket::create([
            'reference_no' => '9848604936569097-test',
            'subject' => 'test 99',
            'description' => 'test 99',
            "priority_id" => $priority->id,
            "user_id" => $user->id,
            "category_id" => $category->id
        ]);
        

        $this->post('/seller/support-ticket/update/'.$ticket->id,[
            "subject" => "test 99",
            "ticket_id" => "32908450349056",
            "priority_id" => $priority->id,
            "category_id" => $category->id,
            "description" => "<p>for testtig</p>",
            'ticket_file' => [UploadedFile::fake()->image('image.jpg', 1, 1)]
        ])->assertRedirect('/seller/support-ticket');

        File::deleteDirectory(base_path('uploads'));

    }

    public function test_for_seller_messgae_reply()
    {
        $user = User::find(4);
        $this->actingAs($user);

        $category = TicketCategory::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $priority = TicketPriority::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $status = TicketStatus::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $ticket = SupportTicket::create([
            'reference_no' => '9848604936569097-test',
            'subject' => 'test 99',
            'description' => 'test 99',
            "priority_id" => $priority->id,
            "user_id" => $user->id,
            "category_id" => $category->id
        ]);
        

        $this->post('/seller/support-ticket/message',[
            'ticket_id' => $ticket->id,
            'type' => 1,
            'text' => 'test',
            'ticket_file' => [UploadedFile::fake()->image('image.jpg', 1, 1)]

        ])->assertRedirect(session()->previousUrl());
        File::deleteDirectory(base_path('uploads'));

    }


    public function test_for_search_seller_ticket()
    {
        $user = User::find(4);
        $this->actingAs($user);

        $category = TicketCategory::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        $priority = TicketPriority::create([
            'name' => 'test 99',
            'status' => 1
        ]);

        

        $ticket = SupportTicket::create([
            'reference_no' => '9848604936569097-test',
            'subject' => 'test 99',
            'description' => 'test 99',
            "priority_id" => $priority->id,
            "user_id" => $user->id,
            "category_id" => $category->id
        ]);
        

        $this->get('/seller/support-ticket/search?'.'category_id='.$category->id)->assertStatus(200);


    }


}
