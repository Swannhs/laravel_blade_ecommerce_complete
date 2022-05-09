<?php

namespace Modules\Marketing\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Marketing\Entities\ReferralCode;

class ReferralTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_update_setting()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $this->post('/marketing/referral-code/update-setup',[
            'id' => 1,
            'amount' => 10,
            'maximum_limit' => 10,
            'status' => 1
        ])->assertStatus(200);
    }

    public function test_for_status_change()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $referral = ReferralCode::create([
            'user_id' => $user->id,
            'referral_code' => '73459385834',
            'status' => 1,
        ]);

        $this->post('/marketing/referral-code/status',[
            'id' => $referral->id,
            'status' => 1
        ])->assertSee(1);
    }

    public function test_for_get_data()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $this->get('/marketing/referral-code/get-data')->assertSee('recordsTotal');
    }
}
