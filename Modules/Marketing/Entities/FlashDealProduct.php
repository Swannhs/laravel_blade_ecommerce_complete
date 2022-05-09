<?php

namespace Modules\Marketing\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Seller\Entities\SellerProduct;

class FlashDealProduct extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    
    public function flashDeal(){
        return $this->belongsTo(FlashDeal::class,'flash_deal_id','id');
    }

    public function product(){
        return $this->belongsTo(SellerProduct::class,'seller_product_id','id')->activeSeller();
    }
}
