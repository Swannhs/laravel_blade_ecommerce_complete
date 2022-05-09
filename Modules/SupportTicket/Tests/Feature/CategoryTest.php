<?php

namespace Modules\SupportTicket\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\SupportTicket\Entities\TicketCategory;

class CategoryTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_create_category()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $this->post('/admin/ticket/categories/store',[
            'name' => 'category 99',
            'status' => 0,
            'form_type' => 1
        ])->assertSee('TableData');
    }

    public function test_for_get_edit_data()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $category = TicketCategory::create([
            'name' => 'category 99',
            'status' => 0
        ]);
        $this->get('/admin/ticket/categories/edit?id='.$category->id)->assertSee('Update');
    }

    public function test_for_update_category()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $category = TicketCategory::create([
            'name' => 'category 99',
            'status' => 0
        ]);

        $this->post('/admin/ticket/categories/update',[
            'name' => 'category 99',
            'status' => 0,
            'id' => $category->id
        ])->assertSee('TableData');
    }

    public function test_for_delete_category()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $category = TicketCategory::create([
            'name' => 'category 99',
            'status' => 0
        ]);

        $this->post('/admin/ticket/categories/delete',[
            'id' => $category->id
        ])->assertSee('TableData');
    }

    public function test_for_status_change_category()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $category = TicketCategory::create([
            'name' => 'category 99',
            'status' => 0
        ]);

        $this->post('/admin/ticket/categories/status',[
            'id' => $category->id,
            'status' => 1
        ])->assertStatus(200);
    }

}
