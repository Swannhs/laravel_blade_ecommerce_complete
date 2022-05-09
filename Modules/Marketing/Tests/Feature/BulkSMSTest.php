<?php

namespace Modules\Marketing\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Marketing\Entities\BulkSMS;

class BulkSMSTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_create_bulk_sms()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $this->post('/marketing/bulk-sms/store',[
            'title' => 'test title',
            'message' => 'test message',
            'publish_date' => date('Y-m-d'),
            'send_to' => "2",
            'role_user' => [$user->id],
            'role' => '1'

        ])->assertSee('TableData');
    }

    public function test_for_get_edit_data()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $sms = BulkSMS::create([
                'title' => 'test title',
                'message' => 'test message',
                'publish_date' => date('Y-m-d'),
                'send_type' => 2,
                'send_user_ids' => json_encode([$user->id]),
                'single_role_id' => '1',
                'multiple_role_id' => null
            ]);    

        $this->get('/marketing/bulk-sms/edit?id='.$sms->id)->assertSee('Update Bulk SMS');
    }

    public function test_for_update_bulk_sms()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $sms = BulkSMS::create([
            'title' => 'test title',
            'message' => 'test message',
            'publish_date' => date('Y-m-d'),
            'send_type' => 2,
            'send_user_ids' => json_encode([$user->id]),
            'single_role_id' => '1',
            'multiple_role_id' => null
        ]); 

        $this->post('/marketing/bulk-sms/update',[
            'title' => 'test title',
            'message' => 'test message',
            'publish_date' => date('Y-m-d'),
            'send_to' => "2",
            'role_user' => [$user->id],
            'role' => '1',
            'id' => $sms->id

        ])->assertSee('TableData');
    }

    public function test_for_delete_bulk_sms()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $sms = BulkSMS::create([
            'title' => 'test title',
            'message' => 'test message',
            'publish_date' => date('Y-m-d'),
            'send_type' => 2,
            'send_user_ids' => json_encode([$user->id]),
            'single_role_id' => '1',
            'multiple_role_id' => null
        ]); 

        $this->post('/marketing/bulk-sms/delete',[
            'id' => $sms->id

        ])->assertSee('TableData');
    }

    public function test_for_get_role_user()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $this->get('/marketing/bulk-sms/role-user?id='.$user->role_id)->assertSee('Select');
    }

    public function test_for_get_data()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $this->get('/marketing/bulk-sms/get-data')->assertSee('recordsTotal');
    }

    public function test_for_test_sms()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $sms = BulkSMS::create([
            'title' => 'test title',
            'message' => 'test message',
            'publish_date' => date('Y-m-d'),
            'send_type' => 2,
            'send_user_ids' => json_encode([$user->id]),
            'single_role_id' => '1',
            'multiple_role_id' => null
        ]); 

        $this->post('/marketing/bulk-sms/test-sms',[
            'id' => $sms->id,
            'phone' => '01729975293'

        ])->assertSee('TableData');
    }



}
