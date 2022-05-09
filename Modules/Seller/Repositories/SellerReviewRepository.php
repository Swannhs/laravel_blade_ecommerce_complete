<?php
namespace Modules\Seller\Repositories;

use Modules\Review\Entities\SellerReview;

class SellerReviewRepository {

    public function getAll(){
        return SellerReview::where('seller_id',auth()->user()->id)->where('status', 1)->latest()->get();
    }

}
