<?php

namespace Modules\Setup\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Modules\Setup\Entities\Country;

class CountryTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_add_new_country()
    {
        $user = User::find(1);
        $this->actingAs($user);


        $this->post('/setup/location/country/store',[
            "name" => "test 99",
            "code" => "tc99",
            "phonecode" => "tcpc99",
            'status' => 0

        ])->assertStatus(200);


    }

    public function test_for_get_edit_data()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $country = Country::create([
            'name' => 'test 99',
            'code' => '7iufdj',
            'phonecode' => '9389',
            'status' => 0,
            'flag' => null
        ]);
        $this->get('/setup/location/country/edit/'.$country->id)->assertSee('Edit Country');

    }

    public function test_for_update_country()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $country = Country::create([
            'name' => 'test 99',
            'code' => '7iufdj',
            'phonecode' => '9389',
            'status' => 0,
            'flag' => null
        ]);

        $this->post('/setup/location/country/update',[
            "name" => "test 99",
            "code" => "tc99",
            "phonecode" => "tcpc99",
            'status' => 1,
            'id' => $country->id

        ])->assertStatus(200);


    }

    public function test_for_status_change_country()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $country = Country::create([
            'name' => 'test 99',
            'code' => '7iufdj',
            'phonecode' => '9389',
            'status' => 0,
            'flag' => null
        ]);

        $this->post('/setup/location/country/status',[
            'id' => $country->id,
            'status' => 1

        ])->assertStatus(200);


    }
}
