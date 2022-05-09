<?php
namespace Modules\Seller\Repositories;

use Modules\Review\Entities\ProductReview;
use Modules\Review\Entities\ReviewReply;
use App\Models\User;

class ProductReviewRepository {

    public function getAll()
    {
        $seller_id = getParentSellerId();
        
        if(auth()->check() && $seller_id != 0)
        {
            return ProductReview::where('seller_id',$seller_id)->where('status', 1);
        }else{
            return abort(404);
        }
    }

    public function getById($id){
        return ProductReview::findOrFail($id);
    }
    public function reviewStore($data){
        return ReviewReply::create([
            'review_id' => $data['review_id'],
            'review' => $data['review'],
            'status' => 1
        ]);
    }
}
