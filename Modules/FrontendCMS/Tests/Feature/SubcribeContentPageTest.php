<?php

namespace Modules\FrontendCMS\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\FrontendCMS\Entities\SubscribeContent;

class SubcribeContentPageTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_subscribe_content_update()
    {
        $this->actingAs(User::find(1));

        $content = SubscribeContent::first();
        
        $this->post('/frontendcms/subscribe-content/update',[
            'title' => 'for test',
            'subtitle' => 'for-test',
            'description' => 'test',
            'id' => $content->id,
        ])->assertStatus(200);

    }
}
