<?php

namespace Modules\Review\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Review\Entities\SellerReview;

class SellerReviewTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_approve_seller_review()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $review = SellerReview::create([
            'customer_id' => 1,
            'seller_id' => 4,
            'order_id' => 443545,
            'package_id' => 443545,
            'review' => 'test review',
            'rating' => 4,
            'is_anonymous' => 1,
            'status' => 0,
        ]);
        
        $this->post('/review/seller/approve',[
            'id' => $review->id,
        ])->assertSee('TableData');

    }

    public function test_for_approve_all_seller_review()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $review = SellerReview::create([
            'customer_id' => 1,
            'seller_id' => 4,
            'order_id' => 443545,
            'package_id' => 443545,
            'review' => 'test review',
            'rating' => 4,
            'is_anonymous' => 1,
            'status' => 0,
        ]);
        
        $this->post('/review/seller/approve-all')->assertSee('TableData');

    }

    public function test_for_deny_seller_review()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $review = SellerReview::create([
            'customer_id' => 1,
            'seller_id' => 4,
            'order_id' => 443545,
            'package_id' => 443545,
            'review' => 'test review',
            'rating' => 4,
            'is_anonymous' => 1,
            'status' => 0,
        ]);
        
        $this->post('/review/seller/delete',[
            'id' => $review->id,
        ])->assertSee('TableData');

    }
}
