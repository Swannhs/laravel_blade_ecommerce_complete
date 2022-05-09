<?php

namespace Modules\Marketing\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Seller\Entities\SellerProduct;

class NewUserZoneProduct extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    
    public function newUserZone(){
        return $this->belongsTo(NewUserZone::class,'new_user_zone_id','id');
    }
    public function product(){
        return $this->belongsTo(SellerProduct::class,'seller_product_id','id')->activeSeller();
    }
}
