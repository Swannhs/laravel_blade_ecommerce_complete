<?php
namespace Modules\Marketing\Repositories;

use Carbon\Carbon;
use Modules\Marketing\Entities\Coupon;
use Modules\Marketing\Entities\CouponProduct;
use Modules\Seller\Entities\SellerProduct;

class CouponRepository {

    public function getAll(){
        $user = auth()->user();
        if($user->role->type == 'superadmin' || $user->role->type == 'admin' || $user->role->type == 'staff'){
            return Coupon::with('coupon_uses');
        }
        elseif($user->role->type == 'seller'){
            return Coupon::with('coupon_uses')->where('created_by',$user->id);
        }else{
            return [];
        }
    }
    public function getProduct(){

        $user = auth()->user();
        if($user->role->type == 'superadmin' || $user->role->type == 'admin' || $user->role->type == 'staff'){
            return SellerProduct::with('product', 'seller.role')->activeSeller()->get();
        }
        elseif($user->role->type == 'seller'){
            return SellerProduct::where('user_id',$user->id)->activeSeller()->get();
        }else{
            return [];
        }
    }

    public function store($data){
        if($data['coupon_type'] == 3){
            $data['discount'] = 20;
        }

        $coupon = Coupon::create([
            'title' => $data['coupon_title'],
            'coupon_code' => $data['coupon_code'],
            'coupon_type' => $data['coupon_type'],
            'start_date' => Carbon::parse($data['start_date'])->format('Y-m-d'),
            'end_date' => Carbon::parse($data['end_date'])->format('Y-m-d'),
            'discount' => isset($data['discount'])?$data['discount']:null,
            'discount_type' => isset($data['discount_type'])?$data['discount_type']:null,
            'maximum_discount' => (isset($data['maximum_discount']) && $data['maximum_discount'] != '')?$data['maximum_discount']:null,
            'minimum_shopping' => isset($data['minimum_shopping'])?$data['minimum_shopping']:null,
            'is_multiple_buy' => isset($data['is_multiple'])?$data['is_multiple']:0
        ]);

        if($data['coupon_type'] == 1){
            foreach($data['product_list'] as $key => $product){
                CouponProduct::create([
                    'coupon_id' => $coupon->id,
                    'coupon_code' => $data['coupon_code'],
                    'product_id' => $product,
                ]);
            }
        }

        return true;
    }

    public function update($data){
        $coupon = Coupon::findOrFail($data['id']);
        if($coupon->coupon_type== 3){
            $data['discount'] = 20;
        }
        $coupon->update([
            'title' => $data['coupon_title'],
            'coupon_code' => $data['coupon_code'],
            'start_date' => Carbon::parse($data['start_date'])->format('Y-m-d'),
            'end_date' => Carbon::parse($data['end_date'])->format('Y-m-d'),
            'discount' => isset($data['discount'])?$data['discount']:null,
            'discount_type' => isset($data['discount_type'])?$data['discount_type']:null,
            'maximum_discount' => (isset($data['maximum_discount']) && $data['maximum_discount'] != '')?$data['maximum_discount']:null,
            'minimum_shopping' => isset($data['minimum_shopping'])?$data['minimum_shopping']:null,
            'is_multiple_buy' => isset($data['is_multiple'])?$data['is_multiple']:0
        ]);

        $coupon = Coupon::findOrFail($data['id']);
        if($coupon->coupon_type == 1){
            $notselectpro = CouponProduct::where('coupon_id',$coupon->id)->whereNotIn('product_id',$data['product_list'])->pluck('id');
            CouponProduct::destroy($notselectpro);
            foreach($data['product_list'] as $key => $product){
                CouponProduct::where('coupon_id',$coupon->id)->updateOrCreate([
                    'coupon_id' => $coupon->id,
                    'coupon_code' => $data['coupon_code'],
                    'product_id' => $product,
                ]);
            }
        }
        return true;
    }

    public function editById($id){
        return Coupon::findOrFail($id);
    }

    public function deleteById($id){
        $coupon = Coupon::findOrFail($id);
        if($coupon->coupon_type == 1){
            $products = $coupon->products->pluck('id');
            CouponProduct::destroy($products);
        }
        $coupon->delete();

        return true;
    }
}
