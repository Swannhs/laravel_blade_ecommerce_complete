<?php

namespace Modules\Product\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Product\Entities\UnitType;

class ProductUnitTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_create_unit()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $this->post('/product/unit-store',[
            'name' => 'test 99',
            'status' => 0
            
        ])->assertStatus(200);
    }

    public function test_for_update_unit()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $unit = UnitType::create([
            'name' => 'test 99',
            'status' => 0
        ]);

        $this->post('/product/unit-update/'.$unit->id,[
            'name' => 'test 99 edit',
            'status' => 1
            
        ])->assertStatus(200);
    }

    public function test_for_delete_unit()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $unit = UnitType::create([
            'name' => 'test 99',
            'status' => 0
        ]);

        $this->get('/product/unit/destroy/'.$unit->id)->assertRedirect('product/units');
    }

}
