<?php

namespace Modules\FrontendCMS\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\FrontendCMS\Entities\Pricing;

class PricingPlanPageTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_create_pricing_plan()
    {
        $this->actingAs(User::find(1));
        
        $this->post('/frontendcms/pricing',[
            'name' => 'for test',
            'monthly_cost' => 5,
            'yearly_cost' => 50,
            'team_size' => 20,
            'stock_limit' => 50,
            'commission' => 5,
            'transaction_fee' => 2,
            'best_for' => 'test',
            'status' => 0,
            'is_monthly' => 1,
            'is_yearly' => 1,
            'is_featured' => 1,
        ])->assertStatus(200);
    }

    public function test_for_get_edit_data(){
        $this->actingAs(User::find(1));

        $this->post('/frontendcms/pricing',[
            'name' => 'for test',
            'monthly_cost' => 5,
            'yearly_cost' => 50,
            'team_size' => 20,
            'stock_limit' => 50,
            'commission' => 5,
            'transaction_fee' => 2,
            'best_for' => 'test',
            'status' => 0,
            'is_monthly' => 1,
            'is_yearly' => 1,
            'is_featured' => 1,
        ]);

        $pricing = Pricing::orderBy('id','desc')->first();
        $url = '/frontendcms/pricing/'.$pricing->id. '/edit';
        $this->get($url)
        ->assertSee('Edit Pricing Plan');
    }

    public function test_for_update_pricing_plan()
    {
        $this->actingAs(User::find(1));
        
        $this->post('/frontendcms/pricing',[
            'name' => 'for test',
            'monthly_cost' => 5,
            'yearly_cost' => 50,
            'team_size' => 20,
            'stock_limit' => 50,
            'commission' => 5,
            'transaction_fee' => 2,
            'best_for' => 'test',
            'status' => 0,
            'is_monthly' => 1,
            'is_yearly' => 1,
            'is_featured' => 1,
        ]);

        $pricing = Pricing::orderBy('id','desc')->first();

        $this->post('/frontendcms/pricing/update',[
            'name' => 'for test',
            'monthly_cost' => 5,
            'yearly_cost' => 50,
            'team_size' => 20,
            'stock_limit' => 50,
            'commission' => 5,
            'transaction_fee' => 2,
            'best_for' => 'test',
            'status' => 0,
            'is_monthly' => 1,
            'is_yearly' => 1,
            'is_featured' => 1,
            'id' => $pricing->id
        ])->assertStatus(200);
    }

    public function test_for_delete_pricing_plan()
    {
        $this->actingAs(User::find(1));
        
        $this->post('/frontendcms/pricing',[
            'name' => 'for test',
            'monthly_cost' => 5,
            'yearly_cost' => 50,
            'team_size' => 20,
            'stock_limit' => 50,
            'commission' => 5,
            'transaction_fee' => 2,
            'best_for' => 'test',
            'status' => 0,
            'is_monthly' => 1,
            'is_yearly' => 1,
            'is_featured' => 1,
        ]);

        $pricing = Pricing::orderBy('id','desc')->first();

        $this->post('/frontendcms/pricing/delete',[
            'id' => $pricing->id
        ])->assertStatus(200);
    }
}
