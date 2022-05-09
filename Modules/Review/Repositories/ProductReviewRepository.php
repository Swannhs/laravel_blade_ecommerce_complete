<?php

namespace Modules\Review\Repositories;

use Modules\Review\Entities\ProductReview;
use App\Traits\ImageStore;
use App\Traits\Notification;
use Modules\GeneralSetting\Entities\EmailTemplateType;
use Modules\GeneralSetting\Entities\GeneralSetting;
use Modules\Review\Entities\ReviewImage;

class ProductReviewRepository
{
    use ImageStore, Notification;

    public function getAll()
    {
        return ProductReview::with('product', 'giftcard');
    }

    public function getPendingAll()
    {
        return ProductReview::with('product', 'giftcard')->where('status', 0);
    }
    public function getDeclinedAll()
    {
        return ProductReview::with('product', 'giftcard')->where('status', 3);
    }

    public function approve($id)
    {
        $product_review = ProductReview::findOrFail($id);
        if ($product_review->type == 'product') {
            $seller_product = $product_review->product;
            $total_review = ($seller_product->reviews->count() > 0) ? $seller_product->reviews->count() : 1;

            $seller_product->update([
                'avg_rating' => number_format($seller_product->reviews->sum('rating') / $total_review, 2)
            ]);

            if ($seller_product->product->category_id != null || $seller_product->product->category_id != 0) {
                $category = $seller_product->product->category;
                $category->update([
                    'avg_rating' => number_format($category->sellerProductsAll()->sum('avg_rating') / count($category->sellerProductsAll()), 2)
                ]);
            }

            if ($seller_product->product->brand_id != null || $seller_product->product->brand_id != 0) {
                $brand = $seller_product->product->brand;
                $brand->update([
                    'avg_rating' => number_format($brand->sellerProductsAll()->sum('avg_rating') / count($brand->sellerProductsAll()), 2)
                ]);
            }
        } else {
            $giftcard = $product_review->giftcard;
            $total_review = ($giftcard->reviews->count() > 0) ? $giftcard->reviews->count() : 1;
            $giftcard->update([
                'avg_rating' => number_format($giftcard->reviews->sum('rating') / $total_review, 2)
            ]);
        }

        // Send Notification
        $this->sendNotificationToSeller($product_review->seller_id);

        return $product_review->update([
            'status' => 1
        ]);
    }
    public function approveAll()
    {
        $reviews = ProductReview::where('status', 0)->get();
        foreach ($reviews as $product_review) {

            if ($product_review->type == 'product') {
                $seller_product = $product_review->product;
                $total_review = ($seller_product->reviews->count() > 0) ? $seller_product->reviews->count() : 1;

                $seller_product->update([
                    'avg_rating' => number_format($seller_product->reviews->sum('rating') / $total_review, 2)
                ]);

                if ($seller_product->product->category_id != null || $seller_product->product->category_id != 0) {
                    $category = $seller_product->product->category;
                    $category->update([
                        'avg_rating' => number_format($category->sellerProductsAll()->sum('avg_rating') / count($category->sellerProductsAll()), 2)
                    ]);
                }

                if ($seller_product->product->brand_id != null || $seller_product->product->brand_id != 0) {
                    $brand = $seller_product->product->brand;
                    $brand->update([
                        'avg_rating' => number_format($brand->sellerProductsAll()->sum('avg_rating') / count($brand->sellerProductsAll()), 2)
                    ]);
                }
            } else {
                $giftcard = $product_review->giftcard;
                $total_review = ($giftcard->reviews->count() > 0) ? $giftcard->reviews->count() : 1;
                $giftcard->update([
                    'avg_rating' => number_format($giftcard->reviews->sum('rating') / $total_review, 2)
                ]);
            }

            $product_review->update([
                'status' => 1
            ]);

            // Send Notification
            $this->sendNotificationToSeller($product_review->seller_id);
        }
        return true;
    }
    public function deleteById($id)
    {
        $review = ProductReview::where('id', $id)->first();
        $review->update([
            'status' => 3
        ]);

        return true;
    }

    public function getReviewConfiguration()
    {
        return GeneralSetting::first();
    }

    public function reviewConfigurationUpdate($request)
    {
        $generatlSetting = GeneralSetting::first();
        $generatlSetting->auto_approve_product_review = $request->product_review_status;
        $generatlSetting->auto_approve_seller_review = $request->seller_review_status;
        $generatlSetting->save();
    }


    public function sendNotificationToSeller($sellerId)
    {
        $this->notificationUrl = route('seller.product-reviews.index');
        $this->typeId = EmailTemplateType::where('type', 'product_review_approve_email_template')->first()->id;
        $this->notificationSend("Product review", $sellerId);
    }
}
