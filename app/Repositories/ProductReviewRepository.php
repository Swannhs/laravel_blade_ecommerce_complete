<?php

namespace App\Repositories;

use App\Models\OrderPackageDetail;
use App\Models\User;
use Modules\Review\Entities\ProductReview;
use Modules\Review\Entities\SellerReview;
use App\Traits\ImageStore;
use App\Traits\Notification;
use Modules\GeneralSetting\Entities\EmailTemplateType;
use Modules\Review\Entities\ReviewImage;

class ProductReviewRepository
{
    use ImageStore, Notification;

    public function store($data, $user = null)
    {

        $old_review = ProductReview::where('customer_id', $user->id)->where('seller_id', $data['seller_id'])->where('package_id', $data['package_id'])->first();

        if ($old_review) {
            return false;
        } else {
            $product_type_temp = '';
            foreach ($data['product_id'] as $key => $id) {

                $product_type_temp = $data['product_type'][$key];
                $review = ProductReview::create([
                    'customer_id' => $user->id,
                    'seller_id' => $data['seller_id'],
                    'product_id' => $id,
                    'type' => $product_type_temp,
                    'order_id' => $data['order_id'],
                    'package_id' => $data['package_id'],
                    'review' => isset($data['product_review'][$key]) ? $data['product_review'][$key] : null,
                    'rating' => ($product_type_temp == 'product') ? $data['product_rating_' . $id] : $data['giftcard_rating_' . $id],
                    'is_anonymous' => isset($data['is_anonymous']) ? $data['is_anonymous'] : 0
                ]);
                if ($product_type_temp == 'product') {
                    if (isset($data['product_images_' . $id])) {
                        foreach ($data['product_images_' . $id] as $key => $image) {
                            $imagename = ImageStore::saveImage($image);
                            ReviewImage::create([
                                'review_id' => $review->id,
                                'product_id' => $id,
                                'type' => $product_type_temp,
                                'image' => $imagename
                            ]);
                        }
                    }
                } else {
                    if (isset($data['gift_images_' . $id])) {
                        foreach ($data['gift_images_' . $id] as $key => $image) {
                            $imagename = ImageStore::saveImage($image);
                            ReviewImage::create([
                                'review_id' => $review->id,
                                'product_id' => $id,
                                'type' => $product_type_temp,
                                'image' => $imagename
                            ]);
                        }
                    }
                }
            }
            $sellerReview = SellerReview::create([
                'seller_id' => $data['seller_id'],
                'order_id' => $data['order_id'],
                'rating' => $data['seller_rating'],
                'review' => isset($data['seller_review']) ? $data['seller_review'] : null,
                'customer_id' => $user->id,
                'is_anonymous' => isset($data['is_anonymous']) ? $data['is_anonymous'] : 0
            ]);

            if(auto_approve_seller_review()){
                $sellerReview->status = 1;
                $sellerReview->save();
            }

            if(auto_approve_product_review()){
                // Send Notification to seller direct
                $review->status = 1;
                $review->save();
                $this->notificationUrl = route('seller.product-reviews.index');
                $this->typeId = EmailTemplateType::where('type', 'review_email_template')->first()->id;
                $this->notificationSend("Product review", $data['seller_id']);
            }else{
                // Send Notification to admin
                $this->notificationUrl = route('review.product.index');
                $this->typeId = EmailTemplateType::where('type', 'review_email_template')->first()->id;
                $user1 = User::where('role_id', 1)->first();
                $user2 = User::where('role_id', 2)->first();
                $this->notificationSend("Product review", $user1->id);
                $this->notificationSend("Product review", $user2->id);
            }


            OrderPackageDetail::where('id', $data['package_id'])->update([
                'is_reviewed' => 1
            ]);

            return true;
        }
    }

    public function waitingForReview($user)
    {

        return OrderPackageDetail::with('order', 'products.giftCard', 'products.seller_product_sku.product.product', 'products.seller_product_sku.product_variations.attribute', 'products.seller_product_sku.product_variations.attribute_value.color')->where('delivery_status', '>=', 5)->where('is_reviewed', 0)->whereHas('order', function ($query) use ($user) {
            $query->where('customer_id', $user->id);
        })->get();
    }

    public function reviewList($user_id)
    {
        return OrderPackageDetail::with('order', 'reviews', 'reviews.giftcard', 'reviews.product.product', 'products.seller_product_sku.product_variations.attribute', 'products.seller_product_sku.product_variations.attribute_value.color', 'reviews.product.product', 'reviews.reply', 'reviews.seller', 'reviews.images')->where('is_reviewed', 1)->whereHas('order', function ($query) use ($user_id) {
            $query->where('customer_id', $user_id);
        })->get();
    }
}
