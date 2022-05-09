<?php
namespace Modules\Review\Repositories;

use Modules\Review\Entities\SellerReview;

class SellerReviewRepository {
    public function getAll(){
        return SellerReview::with('customer', 'seller');
    }

    public function getPendingAll(){
        return SellerReview::with('customer', 'seller')->where('status', 0);
    }
    public function getDeclinedAll(){
        return SellerReview::with('customer', 'seller')->where('status', 3);
    }

    public function approve($id){
        return SellerReview::findOrFail($id)->update([
            'status' => 1
        ]);
    }
    public function approveAll(){
        $reviews = SellerReview::where('status', 0)->get();
        foreach($reviews as $review){
            $review->update([
                'status' => 1
            ]);
        }
        return true;
    }
    public function deleteById($id){
        $review = SellerReview::where('id',$id)->first();
        $review->update([
            'status' => 3
        ]);
        
        return true;
    }

}
