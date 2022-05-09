<?php

namespace Modules\Marketing\Tests\Feature;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Modules\Marketing\Entities\NewsLetter;

class NewsLetterTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_create_news_letter()
    {
        $this->actingAs(User::find(1));

        $subscriber = Subscription::create([
            'status' => 1,
            'email' => 'spn22@spondonit.com'
        ]);

        $this->post('/marketing/news-letter/store',[
            'title' => 'test title',
            'message' => 'test message',
            'publish_date' => date('Y-m-d'),
            'send_to' => "4",
            'subscriber_list' => [$subscriber->id]

        ])->assertSee('TableData');

    }

    public function test_for_update_news_letter()
    {
        $this->actingAs(User::find(1));

        $subscriber = Subscription::create([
            'status' => 1,
            'email' => 'spn22@spondonit.com'
        ]);

        $news_letter = NewsLetter::create([
            'title' => 'test title',
            'message' => 'test message',
            'publish_date' => date('Y-m-d'),
            'send_type' => 4,
            'send_user_ids' => json_encode([$subscriber->id]),
            'single_role_id' => null,
            'multiple_role_id' => null
        ]);

        $this->post('/marketing/news-letter/update',[
            'title' => 'test title',
            'message' => 'test message',
            'publish_date' => date('Y-m-d'),
            'send_to' => "4",
            'subscriber_list' => [$subscriber->id],
            'id' => $news_letter->id

        ])->assertSee('TableData');

    }

    public function test_for_delete_news_letter()
    {
        $this->actingAs(User::find(1));

        $subscriber = Subscription::create([
            'status' => 1,
            'email' => 'spn22@spondonit.com'
        ]);

        $news_letter = NewsLetter::create([
            'title' => 'test title',
            'message' => 'test message',
            'publish_date' => date('Y-m-d'),
            'send_type' => 4,
            'send_user_ids' => json_encode([$subscriber->id]),
            'single_role_id' => null,
            'multiple_role_id' => null
        ]);

        $this->post('/marketing/news-letter/delete',[
            'id' => $news_letter->id

        ])->assertSee('TableData');

    }

    public function test_for_test_mail_news_letter()
    {
        $this->actingAs(User::find(1));

        $subscriber = Subscription::create([
            'status' => 1,
            'email' => 'spn22@spondonit.com'
        ]);

        $news_letter = NewsLetter::create([
            'title' => 'test title',
            'message' => 'test message',
            'publish_date' => date('Y-m-d'),
            'send_type' => 4,
            'send_user_ids' => json_encode([$subscriber->id]),
            'single_role_id' => null,
            'multiple_role_id' => null
        ]);

        $this->post('/marketing/news-letter/test-mail',[
            'id' => $news_letter->id,
            'email' => 'spn21@spondonit.com'

        ])->assertSee('1');

    }

    public function test_for_role_user()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $this->get('/marketing/news-letter/role-user',[
            'id' => $user->role_id
        ])->assertSee('Select');

    }

    public function test_for_get_data()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $this->get('/marketing/news-letter/get-data')->assertSee('recordsTotal');

    }
}
