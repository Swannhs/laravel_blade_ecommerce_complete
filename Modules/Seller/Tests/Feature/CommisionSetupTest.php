<?php

namespace Modules\Seller\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\MultiVendor\Entities\SellerCommssionType;

class CommisionSetupTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_get_edit_data()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $commision = SellerCommssionType::find(1);
        $this->get('/admin/seller-commisions/'.$commision->id.'/edit')->assertStatus(200);
    }

    public function test_for_update_commision()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $commision = SellerCommssionType::find(1);
        $this->post('/admin/seller-commisions/'.$commision->id.'/update',[
            'name' => 'test commision',
            'rate' => 10,
            'description' => 'test description'
        ])->assertStatus(200);
    }
}
