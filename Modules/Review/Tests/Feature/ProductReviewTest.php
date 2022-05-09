<?php

namespace Modules\Review\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Product\Entities\Product;
use Modules\Review\Entities\ProductReview;
use Modules\Seller\Entities\SellerProduct;

class ProductReviewTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_approve_product_review()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $product = Product::create([
            'product_name' => 'test name',
            'product_type' => 1,
            'shipping_type' => 0,
            'shipping_cost' => 0,
            'discount' => 0,
            'tax' => 0,
            'is_physical' => 1,
            'is_approved' => 1
        ]);
        $seller_product = SellerProduct::create([
            'user_id' => 5,
            'product_id' => $product->id,
            'discount' => 0,
            'tax' => 0,
            'status' => 1,
            'stock_manage' => 1,
            'is_approved' => 1,
        ]);

        $review = ProductReview::create([
            'customer_id' => 1,
            'seller_id' => 4,
            'product_id' => $seller_product->id,
            'order_id' => 443545,
            'package_id' => 443545,
            'review' => 'test review',
            'rating' => 4,
            'is_anonymous' => 1,
            'status' => 0,
        ]);

        $this->post('/review/product/approve',[
            'id' => $review->id,
        ])->assertSee('TableData');
    }

    public function test_for_approve_all_product_review()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $product = Product::create([
            'product_name' => 'test name',
            'product_type' => 1,
            'shipping_type' => 0,
            'shipping_cost' => 0,
            'discount' => 0,
            'tax' => 0,
            'is_physical' => 1,
            'is_approved' => 1
        ]);
        $seller_product = SellerProduct::create([
            'user_id' => 5,
            'product_id' => $product->id,
            'discount' => 0,
            'tax' => 0,
            'status' => 1,
            'stock_manage' => 1,
            'is_approved' => 1,
        ]);

        $review = ProductReview::create([
            'customer_id' => 1,
            'seller_id' => 4,
            'product_id' => $seller_product->id,
            'order_id' => 443545,
            'package_id' => 443545,
            'review' => 'test review',
            'rating' => 4,
            'is_anonymous' => 1,
            'status' => 0,
        ]);

        $this->post('/review/product/approve-all')->assertSee('TableData');
    }

    public function test_for_deny_product_review()
    {
        $user = User::find(1);
        $this->actingAs($user);

        $product = Product::create([
            'product_name' => 'test name',
            'product_type' => 1,
            'shipping_type' => 0,
            'shipping_cost' => 0,
            'discount' => 0,
            'tax' => 0,
            'is_physical' => 1,
            'is_approved' => 1
        ]);
        $seller_product = SellerProduct::create([
            'user_id' => 5,
            'product_id' => $product->id,
            'discount' => 0,
            'tax' => 0,
            'status' => 1,
            'stock_manage' => 1,
            'is_approved' => 1,
        ]);

        $review = ProductReview::create([
            'customer_id' => 1,
            'seller_id' => 4,
            'product_id' => $seller_product->id,
            'order_id' => 443545,
            'package_id' => 443545,
            'review' => 'test review',
            'rating' => 4,
            'is_anonymous' => 1,
            'status' => 0,
        ]);

        $this->post('/review/product/delete',[
            'id' => $review->id
        ])->assertSee('TableData');
    }

    public function test_for_product_review_reply_get_form()
    {
        $user = User::find(4);
        $this->actingAs($user);

        $product = Product::create([
            'product_name' => 'test name',
            'product_type' => 1,
            'shipping_type' => 0,
            'shipping_cost' => 0,
            'discount' => 0,
            'tax' => 0,
            'is_physical' => 1,
            'is_approved' => 1
        ]);
        $seller_product = SellerProduct::create([
            'user_id' => 5,
            'product_id' => $product->id,
            'discount' => 0,
            'tax' => 0,
            'status' => 1,
            'stock_manage' => 1,
            'is_approved' => 1,
        ]);

        $review = ProductReview::create([
            'customer_id' => 1,
            'seller_id' => 4,
            'product_id' => $seller_product->id,
            'order_id' => 443545,
            'package_id' => 443545,
            'review' => 'test review',
            'rating' => 4,
            'is_anonymous' => 1,
            'status' => 1,
        ]);

        $this->get('/seller/product-reviews/reply?id='.$review->id)->assertSee('Reply To Customer');
    }

    public function test_for_product_review_reply()
    {
        $user = User::find(4);
        $this->actingAs($user);

        $product = Product::create([
            'product_name' => 'test name',
            'product_type' => 1,
            'shipping_type' => 0,
            'shipping_cost' => 0,
            'discount' => 0,
            'tax' => 0,
            'is_physical' => 1,
            'is_approved' => 1
        ]);
        $seller_product = SellerProduct::create([
            'user_id' => 5,
            'product_id' => $product->id,
            'discount' => 0,
            'tax' => 0,
            'status' => 1,
            'stock_manage' => 1,
            'is_approved' => 1,
        ]);

        $review = ProductReview::create([
            'customer_id' => 1,
            'seller_id' => 4,
            'product_id' => $seller_product->id,
            'order_id' => 443545,
            'package_id' => 443545,
            'review' => 'test review',
            'rating' => 4,
            'is_anonymous' => 1,
            'status' => 1,
        ]);

        $this->post('/seller/product-reviews/reply',[
            'review_id' => $review->id,
            'review' => 'test rev iew'
        ])->assertSee('TableData');
    }
    
}
