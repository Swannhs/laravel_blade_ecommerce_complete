<?php

namespace Modules\Marketing\Tests\Feature;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriberTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_status_change()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $subscriber = Subscription::create([
            'status' => 1,
            'email' => 'spn22@spondonit.com'
        ]);

        $this->post('/marketing/subscriber/status',[
            'status' => 0,
            'id' => $subscriber->id

        ])->assertSee('SL');

    }

    public function test_for_delete_subscriber()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $subscriber = Subscription::create([
            'status' => 1,
            'email' => 'spn22@spondonit.com'
        ]);

        $this->post('/marketing/subscriber/delete',[
            'id' => $subscriber->id

        ])->assertSee('SL');

    }
    public function test_for_get_data()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $this->get('/marketing/subscribers/get-data')->assertSee('recordsTotal');

    }
}
