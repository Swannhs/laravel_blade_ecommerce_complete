<?php

namespace Modules\SupportTicket\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\SupportTicket\Entities\TicketPriority;

class PriorityTest extends TestCase
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
        $this->post('/admin/ticket/priorities/store',[
            'name' => 'priority 99',
            'status' => 0,
            'form_type' => 1
        ])->assertSee('TableData');
    }

    public function test_for_get_edit_data()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $priority = TicketPriority::create([
            'name' => 'category 99',
            'status' => 0
        ]);
        $this->get('/admin/ticket/priorities/edit?id='.$priority->id)->assertSee('Update');
    }

    public function test_for_update_priority()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $priority = TicketPriority::create([
            'name' => 'category 99',
            'status' => 0
        ]);

        $this->post('/admin/ticket/priorities/update',[
            'name' => 'category 99',
            'status' => 0,
            'id' => $priority->id
        ])->assertSee('TableData');
    }

    public function test_for_delete_priority()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $priority = TicketPriority::create([
            'name' => 'category 99',
            'status' => 0
        ]);

        $this->post('/admin/ticket/priorities/delete',[
            'id' => $priority->id
        ])->assertSee('TableData');
    }

    public function test_for_status_change_priority()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $priority = TicketPriority::create([
            'name' => 'category 99',
            'status' => 0
        ]);

        $this->post('/admin/ticket/priorities/status',[
            'id' => $priority->id,
            'status' => 1
        ])->assertStatus(200);
    }
}
