<?php

namespace Modules\Setup\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnalyticToolTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_update_google_analytics()
    {
        $user = User::find(1);
        $this->actingAs($user);


        $this->post('/setup/analytics/google-analytics-update',[
            "business_id" => 13,
            "analytics_id" => 1,
            'tracking_id' => '8937498359',
            'status' => 0

        ])->assertStatus(200);
    }

    public function test_for_update_facebook_pixel()
    {
        $user = User::find(1);
        $this->actingAs($user);


        $this->post('/setup/analytics/facebook-pixel-update',[
            "business_id" => 14,
            "analytics_id" => 2,
            'facebook_pixel_id' => '8937498359',
            'status' => 1

        ])->assertStatus(200);
    }
}
