<?php

namespace Modules\Language\Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LanguageTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_add_new_language()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $this->post('/language/store',[
            'name' => 'test lan 99',
            'code' => 'test99',
            'native' => 'test lan 99'
        ])->assertLocation('/language');
    }
}
