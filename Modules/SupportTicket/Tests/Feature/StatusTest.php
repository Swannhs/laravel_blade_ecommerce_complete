<?php

namespace Modules\SupportTicket\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\SupportTicket\Entities\TicketStatus;

class StatusTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_create_priority()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $this->post('/admin/ticket/status/store',[
            'name' => 'status 99',
            'status' => 0,
            'form_type' => 1
        ])->assertSee('TableData');
    }

    public function test_for_get_edit_data()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $status = TicketStatus::create([
            'name' => 'status 99',
            'status' => 0
        ]);
        $this->get('/admin/ticket/status/edit?id='.$status->id)->assertSee('Update');
    }

    public function test_for_update_priority()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $status = TicketStatus::create([
            'name' => 'status 99',
            'status' => 0
        ]);

        $this->post('/admin/ticket/status/update',[
            'name' => 'status 99',
            'status' => 0,
            'id' => $status->id
        ])->assertSee('TableData');
    }

    public function test_for_delete_status()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $status = TicketStatus::create([
            'name' => 'status 99',
            'status' => 0
        ]);

        $this->post('/admin/ticket/status/delete',[
            'id' => $status->id
        ])->assertSee('TableData');
    }

    public function test_for_status_change_status()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $status = TicketStatus::create([
            'name' => 'status 99',
            'status' => 0
        ]);

        $this->post('/admin/ticket/status/status',[
            'id' => $status->id,
            'status' => 1
        ])->assertStatus(200);
    }
}
