<?php

namespace Modules\FrontendCMS\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\FrontendCMS\Entities\ReturnExchange;

class ReturnExchangePageTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_return_exchange_update()
    {
        $this->actingAs(User::find(1));
        $return = ReturnExchange::first();

        $this->post('/frontendcms/return-exchange/update',[
            'mainTitle' => 'main title',
            'returnTitle' => 'for-test',
            'slug' => 'slug',
            'exchangeTitle' => 'test',
            'returnDescription' => 'test',
            'exchangeDescription' => 'test',
            'id' => $return->id,
        ])->assertStatus(200);
    }
}
