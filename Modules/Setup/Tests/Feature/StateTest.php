<?php

namespace Modules\Setup\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Setup\Entities\State;

class StateTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_add_new_state()
    {
        $user = User::find(1);
        $this->actingAs($user);


        $this->post('/setup/location/state/store',[
            "name" => "test 99",
            "country" => 1,
            'status' => 0

        ])->assertStatus(200);
    }

    public function test_for_get_edit_data()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $state = State::create([
            'name' => 'test 99',
            'country_id' => 1,
            'status' => 1
        ]);
        $this->get('/setup/location/state/edit/'.$state->id)->assertSee('Edit State');

    }

    public function test_for_update_state()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $state = State::create([
            'name' => 'test 99',
            'country_id' => 1,
            'status' => 0
        ]);

        $this->post('/setup/location/state/update',[
            "name" => "test 99",
            'status' => 1,
            'id' => $state->id,
            'country' => 1

        ])->assertStatus(200);


    }

    public function test_for_status_change_state()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $state = State::create([
            'name' => 'test 99',
            'country_id' => 1,
            'status' => 0
        ]);

        $this->post('/setup/location/state/status',[
            'id' => $state->id,
            'status' => 1

        ])->assertStatus(200);


    }
}
