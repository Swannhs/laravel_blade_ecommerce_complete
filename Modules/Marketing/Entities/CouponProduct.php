<?php

namespace Modules\Marketing\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Seller\Entities\SellerProduct;

class CouponProduct extends Model
{

    protected $guarded = ['id'];
    
    public function coupon(){
        return $this->belongsTo(Coupon::class,'coupon_id','id');
    }

    public function product(){
        return $this->belongsTo(SellerProduct::class, 'product_id', 'id');
    }
}
