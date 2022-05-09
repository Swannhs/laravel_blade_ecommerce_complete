<?php
namespace App\Repositories;

use Modules\Marketing\Entities\CustomerCouponStore;

class CouponRepository{

    public function getAll($user_id){
        return CustomerCouponStore::with('coupon')->where('customer_id', $user_id)->get();
    }
    public function store($data, $user_id){
        return CustomerCouponStore::create([
            'customer_id' => $user_id,
            'coupon_id' => $data
        ]);
    }
    
    public function deleteById($id, $user_id){
        $coupon = CustomerCouponStore::where('id', $id)->where('customer_id', $user_id)->first();
        if($coupon){
            $coupon->delete();
            return true;
        }else{
            return false;
        }

    }
}