<?php

namespace Modules\Setup\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Setup\Entities\City;

class CityTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_add_new_city()
    {
        $user = User::find(1);
        $this->actingAs($user);


        $this->post('/setup/location/city/store',[
            "name" => "test 99",
            "state" => 400,
            'country' => 18,
            'status' => 0

        ])->assertStatus(200);
    }

    public function test_for_get_state()
    {
        $user = User::find(1);
        $this->actingAs($user);


        $this->post('/setup/location/city/get-state',[
            'country_id' => 18

        ])->assertStatus(200);
    }

    public function test_for_get_edit_data()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $city = City::create([
            'name' => 'test 99',
            'country_id' => 18,
            'state_id' => 400,
            'status' => 1
        ]);
        $this->get('/setup/location/city/edit/'.$city->id)->assertSee('Edit City');

    }

    public function test_for_update_state()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $city = City::create([
            'name' => 'test 99',
            'country_id' => 18,
            'state_id' => 400,
            'status' => 0
        ]);

        $this->post('/setup/location/city/update',[
            "name" => "test 99",
            'status' => 1,
            'id' => $city->id,
            'country' => 18,
            'state' => 400

        ])->assertStatus(200);


    }

    public function test_for_status_change_state()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $city = City::create([
            'name' => 'test 99',
            'country_id' => 18,
            'state_id' => 400,
            'status' => 0
        ]);

        $this->post('/setup/location/city/status',[
            'id' => $city->id,
            'status' => 1

        ])->assertStatus(200);


    }

}
