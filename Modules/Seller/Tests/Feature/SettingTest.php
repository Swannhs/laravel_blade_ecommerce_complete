<?php

namespace Modules\Seller\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\MultiVendor\Entities\SellerSocialLink;

class SettingTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_add_social_link()
    {
        $user = User::find(4);
        $this->actingAs($user);

        $this->post('/seller/setting/social-link/store',[
            "url" => "#",
            "icon" => "ti-facebook",
            "status" => 0

        ])->assertSee('TableData');
    }

    public function test_for_update_social_link()
    {
        $user = User::find(4);
        $this->actingAs($user);

        $link = SellerSocialLink::create([
            'url' => '#',
            'icon' => 'ti-facebook',
            'status' => 0,
            'user_id' => $user->id
        ]);

        $this->post('/seller/setting/social-link/update',[
            "url" => "#",
            "icon" => "ti-facebook",
            "status" => 1,
            'id' => $link->id

        ])->assertSee('TableData');
    }

    public function test_for_delete_social_link()
    {
        $user = User::find(4);
        $this->actingAs($user);

        $link = SellerSocialLink::create([
            'url' => '#',
            'icon' => 'ti-facebook',
            'status' => 0,
            'user_id' => $user->id
        ]);

        $this->post('/seller/setting/social-link/delete',[
            'id' => $link->id

        ])->assertSee('TableData');
    }
}
